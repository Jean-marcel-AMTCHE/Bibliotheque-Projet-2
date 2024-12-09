<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;



// Routes publiques
Route::get('/', [BookController::class, 'index'])->name('home');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('books.search');
Route::get('/search', [BookController::class, 'search'])->name('books.search');
Route::get('/advanced-search', [SearchController::class, 'advancedSearch'])->name('books.advanced-search');
   



   




// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/admin', function () {
})->middleware('role:admin');
Route::get('/user', function () {
})->middleware('role:user');



// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');

    Route::post('/payment/paypal', [PaymentController::class, 'processPaypal'])->name('payment.paypal');
Route::post('/payment/stripe', [PaymentController::class, 'processStripe'])->name('payment.stripe');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::get('/payment/error', [PaymentController::class, 'error'])->name('payment.error');

Route::post('/payment/process', [PaymentController::class, 'process'])
    ->name('payment.checkout')
    ->middleware('auth');  // Assurez-vous que cette route est protégée

Log::info('Route payment.checkout définie', [
    'methods' => 'POST',
    'uri' => '/payment/process',
]);

Route::get('/purchase-history', [PurchaseHistoryController::class, 'index'])->middleware('auth')->name('purchase.history');
});Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

// Routes protégées pour les administrateurs
Route::middleware(['auth'])->group(function () {
    Route::resource('books', BookController::class);
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::patch('/messages/{message}/mark-as-read', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');
});

Route::get('books', [BookController::class, 'index'])->name('books.index');
Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');