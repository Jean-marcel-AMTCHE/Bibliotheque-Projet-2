<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Stripe\Stripe;

class PaymentService
{
    protected $paypalApiContext;

    public function __construct()
    {
        $this->paypalApiContext = new ApiContext(
            new OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.secret')
            )
        );

        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function processPayPalPayment(Cart $cart)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal($cart->total());

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription('Achat de livres');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('payment.success'))
            ->setCancelUrl(route('payment.cancel'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->paypalApiContext);
            return redirect($payment->getApprovalLink());
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors du traitement du paiement PayPal.');
        }
    }

    public function processStripePayment(Cart $cart)
    {
        try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Achat de livres',
                        ],
                        'unit_amount' => $cart->total() * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
            ]);

            return redirect($session->url);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors du traitement du paiement Stripe.');
        }
    }

    public function completePayment()
    {
        $cart = auth()->user()->cart;
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $cart->total(),
            'status' => 'completed'
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'book_id' => $item->book_id,
                'quantity' => $item->quantity,
                'price' => $item->book->price
            ]);
        }

        $cart->clear();
    }
}

