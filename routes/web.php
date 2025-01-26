<?php

use App\Http\Controllers\SubscribedController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Cashier;

Route::view('/', 'welcome');

/*****************************************************
 * Rotas de exemplo para testar ASSINATURAS com o Cashier
 *****************************************************/
Route::get('/subscription', [SubscriptionController::class, 'index'])->middleware('auth')->name('subscription');
Route::post('/subscription/store', [SubscriptionController::class, 'store'])->middleware('auth')->name('subscription.store');
Route::get('/subscription/success', [SubscriptionController::class, 'success'])->middleware('auth')->name('subscription.success');
Route::get('/subscription/cancel', [SubscriptionController::class, 'cancel'])->middleware('auth')->name('subscription.cancel');

// Rota de teste para verificar se um usuário tem uma assinatura ativa.

// Validação no Blade
Route::get('/subscribed', [SubscribedController::class, 'index'])->middleware('auth')->name('subscribed');



/*****************************************************
 * Rotas de exemplo para testar VENDAS com o Cashier
 *****************************************************/
Route::get('/buy/product', function () {
    return view('buy-product');
})->middleware('auth')->name('buy-product');

Route::get('/buy/charge', function () {
    return view('buy-charge');
})->middleware('auth')->name('buy-charge');

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
