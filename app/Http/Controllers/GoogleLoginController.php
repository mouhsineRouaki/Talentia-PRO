<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();
        if(!$user)
        {
            $user = User::create([  
                                    'nom' => $googleUser->user["given_name"], 
                                    'prenom' => $googleUser->user["family_name"],
                                    'email' => $googleUser->email, 
                                    'password' => \Hash::make(rand(100000,999999)),
                                    'role' => 'RECRUTEUR',
                                    'image' => $googleUser->avatar,
                                    'biographie' => '',
                                ]);

        }

        Auth::login($user);

        if ($user->hasRole('recruteur')) {
            return redirect()->route('dashboard.recruteur');
        }

        return redirect()->route('dashboard.rechercheur');
    }
}