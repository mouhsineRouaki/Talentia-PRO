<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Recruteur;
use App\Models\Rechercheur;


class SocialAuthController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }
        
    public function handleGithubCallback()
    {
        $githubUser = Socialite::driver('github')->stateless()->user();
        
        $user = User::where('email', $githubUser->getEmail())->first();
        
    if (!$user) {
        $user = User::create([
            'nom' => $githubUser->name ?? $githubUser->nickname,
            'prenom' => $githubUser->nickname,
            'email' => $githubUser->getEmail(),
            'password' => \Hash::make(rand(100000,999999)),
            'role' => 'RECRUTEUR',
            'image' => $githubUser->avatar,
            'biographie' => '',
        ]);
    }

    Auth::login($user);

    if ($user->hasRole('recruteur')) {
        if (! Recruteur::where('user_id', $user->id)->exists()) {
                Recruteur::create([
                'user_id' => $user->id,
                'entreprise' => 'Indépendant', // Placeholder
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
