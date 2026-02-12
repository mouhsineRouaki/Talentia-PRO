<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


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
        return redirect()->route('dashboard.recruteur');
    }

    return redirect()->route('dashboard.rechercheur');
}
}
