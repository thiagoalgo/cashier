<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    public function __construct()
    {
        //
    }

    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'payment_intent.succeeded') {
            Log::info('StripeEventListener@handle' . json_encode($event->payload));
            return;
        }

        if ($event->payload['type'] === 'checkout.session.completed') {
            Log::info('StripeEventListener@handle checkout.session.completed');
            return;
        }

        if ($event->payload['type'] === 'checkout.session.async_payment_succeeded') {
            Log::info('StripeEventListener@handle checkout.session.async_payment_succeeded');
            return;
        }

        if ($event->payload['type'] === 'checkout.session.async_payment_failed') {
            Log::info('StripeEventListener@handle checkout.session.async_payment_failed');
            return;
        }
    }
}
