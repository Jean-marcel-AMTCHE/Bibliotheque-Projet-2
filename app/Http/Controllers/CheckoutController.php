<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $cart = auth()->user()->cart;
        $total = $cart->total();
        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $cart = auth()->user()->cart;

        if ($paymentMethod === 'paypal') {
            return $this->paymentService->processPayPalPayment($cart);
        } elseif ($paymentMethod === 'stripe') {
            return $this->paymentService->processStripePayment($cart);
        }

        return redirect()->back()->with('error', 'Méthode de paiement invalide.');
    }
}

