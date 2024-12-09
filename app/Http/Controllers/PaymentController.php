<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use App\Models\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Stripe\Stripe;
use Stripe\Charge;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;
use Stripe\Refund;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;


class PaymentController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );
$apiContext = new ApiContext(new OAuthTokenCredential(config('paypal.client_id'), config('paypal.secret')));
$apiContext->setConfig([
    'mode' => config('paypal.mode'),
    'http.ConnectionTimeOut' => 30,
    'log.LogEnabled' => true,
    'log.FileName' => storage_path('logs/paypal.log'),
    'log.LogLevel' => 'DEBUG'
]);
    }

    public function processPaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency('CAD')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription('Achat de livres');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('payment.success'))
            ->setCancelUrl(route('payment.cancel'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->apiContext);

         // Enregistrer la transaction dans la base de données
        \App\Models\Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $request->get('amount'),
            'payment_method' => 'paypal',
            'status' => 'pending'
        ]);
            return redirect()->away($payment->getApprovalLink());
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return redirect()->route('payment.error');
        }
    }

    public function processStripe(Request $request)
    {
        Stripe::setApiKey(config('stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => $request->get('amount') * 100, // Stripe utilise les centimes
                'currency' => 'usd',
                'source' => $request->get('stripeToken'),
                'description' => 'Achat de livres',
            ]);

            // Enregistrer la transaction dans la base de données
        \App\Models\Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $request->get('amount'),
            'payment_method' => 'stripe',
            'status' => 'completed'
        ]);

            return redirect()->route('payment.success');
        } catch (\Exception $ex) {
            return redirect()->route('payment.error');
        }
    }

    public function success()
    {
        // Logique pour gérer un paiement réussi
        return view('payment.success');
    }

    public function cancel()
    {
        // Logique pour gérer un paiement annulé
        return view('payment.cancel');
    }

    public function error()
    {
        // Logique pour gérer une erreur de paiement
        return view('payment.error');
    }

    public function refundPaypal(Request $request)
    {
        $saleId = $request->sale_id;
        $amount = $request->amount;

        $sale = new Sale();
        $sale->setId($saleId);

        $refundRequest = new RefundRequest();
        $amountObject = new Amount();
        $amountObject->setCurrency('USD')
                     ->setTotal($amount);
        $refundRequest->setAmount($amountObject);

        try {
            $refundedSale = $sale->refundSale($refundRequest, $this->apiContext);
            // Enregistrez le remboursement dans votre base de données
            return redirect()->back()->with('success', 'Remboursement PayPal effectué avec succès');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Erreur lors du remboursement PayPal: ' . $ex->getMessage());
        }
    }

    public function refundStripe(Request $request)
    {
        Stripe::setApiKey(config('stripe.secret'));

        try {
            $refund = Refund::create([
                'charge' => $request->charge_id,
                'amount' => $request->amount * 100, // Stripe utilise les centimes
            ]);

            // Enregistrez le remboursement dans votre base de données
            return redirect()->back()->with('success', 'Remboursement Stripe effectué avec succès');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Erreur lors du remboursement Stripe: ' . $ex->getMessage());
        }
    }

    public function history()
    {
        $user = auth()->user();
        
        $transactions = Transaction::where('user_id', $user->id)
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        
        return view('payment.history', ['transactions' => $transactions]);
    }

    public function process(Request $request)
{
        Log::info('PaymentController@process appelé', [
            'method' => $request->method(),
            'all_data' => $request->all(),
        ]);

    // Récupérer l'utilisateur connecté et son panier
    $user = auth()->user();
    $cart = Cart::where('user_id', $user->id)->with('books')->first();
    
    if (!$cart || $cart->books->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
    }

    // Calculer le total
    $total = $cart->books->sum(function($book) {
        return $book->price * $book->pivot->quantity;
    });

    // Appliquer les remises si nécessaire
    $total = $this->applyDiscounts($total, $user);

    // Choisir la méthode de paiement
    if ($request->payment_method === 'paypal') {
        // Intégration PayPal
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($total);
        $amount->setCurrency('EUR');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(route('payment.success'))
                     ->setCancelUrl(route('payment.cancel'));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return redirect()->route('cart.index')->with('error', 'Erreur lors du paiement PayPal.');
        }
    } 
    elseif ($request->payment_method === 'stripe') {
        // Intégration Stripe
        \Stripe\Stripe::setApiKey(config('stripe.secret'));

        try {
            $charge = \Stripe\Charge::create([
                'amount' => $total * 100, // Stripe utilise les centimes
                'currency' => 'eur',
                'source' => $request->stripeToken,
                'description' => 'Achat de livres',
            ]);

            // Enregistrer la transaction
            $this->saveTransaction($total, 'stripe', $charge->id);

            return redirect()->route('payment.success')->with('success', 'Paiement réussi avec Stripe.');
        } catch (\Exception $ex) {
            return redirect()->route('cart.index')->with('error', 'Erreur lors du paiement Stripe.');
        }
    }

    return redirect()->back()->with('error', 'Méthode de paiement non valide.');
}

private function applyDiscounts($total, $user)
{
    // Vérifier s'il y a des remises actives
    $activeDiscounts = Discount::where('active', true)
                               ->where('start_date', '<=', now())
                               ->where('end_date', '>=', now())
                               ->get();

    foreach ($activeDiscounts as $discount) {
        // Appliquer la remise globale
        if ($discount->type === 'global') {
            $total -= ($total * $discount->value / 100);
        }
        // Appliquer la remise spécifique à l'utilisateur
        elseif ($discount->type === 'user' && $discount->user_id === $user->id) {
            $total -= ($total * $discount->value / 100);
        }
    }

    // Vérifier si l'utilisateur a un coupon
    $coupon = $user->coupons()->where('used', false)->first();
    if ($coupon) {
        if ($coupon->type === 'fixed') {
            $total -= $coupon->value;
        } elseif ($coupon->type === 'percentage') {
            $total -= ($total * $coupon->value / 100);
        }
        $coupon->update(['used' => true]);
    }

    // S'assurer que le total n'est pas négatif
    return max($total, 0);
}



private function saveTransaction($amount, $method, $transactionId)
{
    Transaction::create([
        'user_id' => auth()->id(),
        'amount' => $amount,
        'payment_method' => $method,
        'transaction_id' => $transactionId,
    ]);

    // Vider le panier de l'utilisateur
    Cart::where('user_id', auth()->id())->delete();
}



}

