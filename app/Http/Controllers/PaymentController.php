<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;


class PaymentController extends Controller
{
    public function checkout($plan)
    {
        // For now, we'll just mock the plan details based on the slug.
        // In a real app, you might look this up from a config or database.
        
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
                Subscription::update($session->subscription, [
                    'cancel_at' => now()->addDays(30)->timestamp,
                ]);

            }
        }

        return redirect()->route('premium')->with('success', 'Subscription activated and set to end in 30 days.');
    }
}
