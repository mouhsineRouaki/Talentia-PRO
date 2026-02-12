<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Models\Recruteur;
use App\Models\Rechercheur;

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
            if (! Recruteur::where('user_id', $user->id)->exists()) {
                 Recruteur::create([
                    'user_id' => $user->id,
                    'entreprise' => 'Indépendant',
                    'site_web' => null,
                    'telephone' => null,
                    'ville' => null,
                    'adresse' => null,
                    'description_entreprise' => null,
                ]);
            }
            return redirect()->route('dashboard.recruteur');
        }

        if (! Rechercheur::where('user_id', $user->id)->exists()) {
             Rechercheur::create([
                'user_id' => $user->id,
                'titre_profil' => 'Nouveau Rechercheur',
                'specialite' => 'Généraliste',
                'cv_path' => null,
                'ville' => null,
            ]);
        }

        return redirect()->route('dashboard.rechercheur');
    }
}