<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Services\DiscountService;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('book')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->book->price;
        });
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function addToCart(Book $book)
    {
        $cartItem = CartItem::updateOrCreate(
            ['user_id' => auth()->id(), 'book_id' => $book->id],
            ['quantity' => \DB::raw('quantity + 1')]
        );
        return redirect()->route('cart.index')->with('success', 'Livre ajouté au panier avec succès.');
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        $cartItem->update(['quantity' => $request->quantity]);
        return redirect()->route('cart.index')->with('success', 'Quantité mise à jour avec succès.');
    }

    public function removeFromCart(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Livre retiré du panier avec succès.');
    }

    public function checkout()
    {
        $user = auth()->user();
        $cart = $user->cart;
    
        if (!$cart) {
            // Gérer le cas où l'utilisateur n'a pas de panier
            return redirect()->route('home')->with('error', 'Votre panier est vide.');
        }

        // Récupérer les articles du panier de l'utilisateur connecté
    $cartItems = auth()->user()->cart()->with('book')->get();

    // Calculer le sous-total
    $subtotal = $cartItems->sum(function ($item) {
        return $item->book->price * $item->quantity;
    });

    // Calculer les taxes (par exemple, 10%)
    $taxRate = 0.10;
    $taxes = $subtotal * $taxRate;

    // Calculer les remises (si applicable)
    $discounts = 0; // À implémenter selon votre logique de remise

    // Calculer le total
    $total = $subtotal + $taxes - $discounts;
    return view('cart.checkout', compact('cartItems', 'subtotal', 'taxes', 'discounts', 'total'));
    
    }

    protected $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function applyCoupon(Request $request)
    {
        $total = $request->session()->get('cart_total', 0);
        $result = $this->discountService->applyCoupon($request->coupon_code, $total);

        if ($result['success']) {
            $request->session()->put('cart_total', $result['total']);
            $request->session()->put('coupon', $result['coupon']);
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

}

