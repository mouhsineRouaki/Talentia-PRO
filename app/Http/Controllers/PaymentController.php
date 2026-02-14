<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Subscription;


class PaymentController extends Controller
{
    public function checkout($plan)
    {        
        $plans = [
            'free' => [
                'name' => 'Free Starter',
                'price' => 0,
                'interval' => 'forever',
                'features' => ['Basic Profile', '3 Applications/mo']
            ],
            'pro' => [
                'name' => 'Professional',
                'price' => 29,
                'interval' => 'month',
                'features' => ['Unlimited Applications', 'Featured Profile', 'Priority Support']
            ],
            'business' => [
                'name' => 'Business',
                'price' => 99,
                'interval' => 'month',
                'features' => ['Unlimited Job Posts', 'Team Management', 'Dedicate Support']
            ]
        ];

        $selectedPlan = $plans[$plan] ?? $plans['pro'];

        return view('subscription.checkout', compact('selectedPlan'));
    }

    public function check($name, Request $request){
        $plan = Plan::whereName($name)->first();
        $planPrice = $plan->stripe_price_id;

        return $request->user()
            ->newSubscription('default', $planPrice)
            ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('premium'),
            ]);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if ($sessionId) {
            Stripe::setApiKey(config('cashier.secret'));
            $session = Session::retrieve($sessionId);
            
            if ($session->subscription) {
                $stripeSubscription = Subscription::retrieve($session->subscription);
                $request->user()->subscriptions()->updateOrCreate(
                    ['stripe_id' => $stripeSubscription->id],
                    [
                        'type' => 'default',
                        'stripe_status' => $stripeSubscription->status,
                        'stripe_price' => $stripeSubscription->items->data[0]->price->id,
                        'quantity' => 1,
                        'ends_at' => null,
                        'trial_ends_at' => null,
                    ]
                );

                Subscription::update($session->subscription, [
                    'cancel_at' => now()->addDays(30)->timestamp,
                ]);
            }
        }

        return redirect()->route('premium')->with('success', 'Subscription activated and set to end in 30 days.');
    }
}
