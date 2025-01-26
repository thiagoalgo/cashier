<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Cashier;

Route::view('/', 'welcome');


Route::get('/buy/product', function () {
    return view('buy-product');
})->middleware('auth')->name('buy-product');

Route::get('/buy/charge', function () {
    return view('buy-charge');
})->middleware('auth')->name('buy-charge');

Route::get('/subscription', function () {
    return view('subscription');
})->middleware('auth')->name('subscription');

Route::get('/checkout', function (Request $request) {
    $stripePriceId = 'price_1QfWrpH8Rnnrgm852YRiGHJ4';
    $quantity = 2;

    return $request->user()
        ->allowPromotionCodes()
        ->checkout([$stripePriceId => $quantity], [
            'success_url' => route('checkout-success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout-cancel'),
            'metadata' => [
                'price_id' => $stripePriceId,
                'user_id' => $request->user()->id,
            ],
        ]);
})->middleware('auth')->name('checkout');

Route::get('/checkout-charge', function (Request $request) {
    $price = 5000; // 50.00
    $description = 'Camiseta Larivum';
    $quantity = 2;

    return $request->user()
        ->allowPromotionCodes()
        ->checkoutCharge($price, $description, $quantity, [
            'success_url' => route('checkout-success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout-cancel'),
            'metadata' => [
                'description' => $description,
                'user_id' => $request->user()->id,
            ],
        ]);
})->middleware('auth')->name('checkout-charge');


Route::get('/checkout/success', function (Request $request) {
    $sessionId = $request->get('session_id');

    $metadata = Cashier::stripe()->checkout->sessions->retrieve($sessionId)->metadata;

    \Illuminate\Support\Facades\Log::info($metadata);

    return view('checkout-success');
})->middleware('auth')->name('checkout-success');

Route::get('/checkout/cancel', function (Request $request) {
    return view('checkout-cancel');
})->middleware('auth')->name('checkout-cancel');

// Para usar o contrller de webhook padrão do Cashier que responde automaticamente na rota /stripe/webhook
// Basta não criar (comentar) a rota abaixo
// Para criar um controller de webhook personalizado, descomente a rota abaixo e crie o controller
Route::post('/stripe/webhook', [\App\Http\Controllers\WebhookController::class, 'handleWebhook'])->name('cashier-webhook');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
