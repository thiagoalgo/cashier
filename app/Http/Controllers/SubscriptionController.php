<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('subscription');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $plan = $request->input('plan');
        $priceId = $request->input('price_id');

        return $request->user()
            ->newSubscription('Assinatura mensal', $priceId)
            ->trialDays(7)
            ->checkout([
                'success_url' => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('subscription.cancel'),
                'metadata' => [
                    'plan' => $plan,
                    'price_id' => $priceId,
                    'user_id' => $request->user()->id,
                ],
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    #[NoReturn]
    public function success()
    {
        dd('Success');
    }

    #[NoReturn]
    public function cancel()
    {
        dd('cancel');
    }
}
