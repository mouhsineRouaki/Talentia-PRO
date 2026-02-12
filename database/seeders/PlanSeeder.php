<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            ["name" => "Free Starter", "stripe_plan_id" => "prod_TxtHY7rPyuFfjG", "stripe_price_id" => "price_1SzxVDK20VStH8qrarukqsHT"],
            ["name" => "Professional", "stripe_plan_id" => "prod_TxtIlBeehZ3vFG", "stripe_price_id" => "price_1SzxW9K20VStH8qr2iWKkI2Q"],
            ["name" => "Business", "stripe_plan_id" => "prod_TxtLXdXfQjZZNj", "stripe_price_id" => "price_1SzxZ7K20VStH8qrXAKtVRUj"],
        ];

        foreach ($plans as $plan){
            Plan::create($plan);
        }
    }
}
