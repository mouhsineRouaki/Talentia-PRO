<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\Offers;

class AppServiceProvider extends ServiceProvider
{

    public function boot(): void {
        Livewire::component('offers-rechercheurs', Offers::class);
    }
}
