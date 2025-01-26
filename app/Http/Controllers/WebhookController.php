<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class WebhookController extends \Laravel\Cashier\Http\Controllers\WebhookController
{
    public function handlePaymentIntentSucceeded(array $payload)
    {
        Log::info('WebhookController@handlePaymentIntentSucceeded' . json_encode($payload));
    }
}
