<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendSubscriptionExpiryNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:send-expiry-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications to users whose subscription expires in 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetDate = now()->addDays(7)->startOfDay();
        
        $subscriptions = \Laravel\Cashier\Subscription::query()
            ->whereDate('ends_at', $targetDate)
            ->where('stripe_status', 'active') 
            ->get();

        foreach ($subscriptions as $subscription) {
            $user = $subscription->user;
            if ($user) {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SubscriptionExpiringSoon($user));
                $this->info("Notification sent to: {$user->email}");
            }
        }

        $this->info('Expiry notifications sent successfully.');
    }
}
