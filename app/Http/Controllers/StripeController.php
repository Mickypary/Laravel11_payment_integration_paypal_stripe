<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function payment(Request $request)
    {
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys

        //instantiation way
        // $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
        // $stripe->checkout->sessions->create([]);

        //static way
        $stripe = \Stripe\Stripe::setApiKey(config('stripe.stripe_sk'));

        $response =  \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Mobile Phone'
                        ],
                        'unit_amount' => $request->price * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('stripe_success'),
            'cancel_url' => route('stripe_cancel'),
        ]);

        // dd($response);
        return redirect()->away($response->url);
    }

    public function success(Request $request)
    {
        return 'Payment completed successfully';
    }

    public function cancel()
    {
        return 'Payment cancelled';
    }
}
