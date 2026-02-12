<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Rechercheur;
use App\Models\Recruteur;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:300'],
            'titre_profil' => ['nullable', 'string', 'max:150'], // Validate titre_profil
        ]);
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'image' => $request->image,
        ]);

        if ($user->role === \App\UserRole::RECRUTEUR) {
            $user->assignRole('recruteur');
            Recruteur::create([
                'user_id' => $user->id,
                'entreprise' => 'Indépendant',
                'site_web' => null,
                'telephone' => null,
                'ville' => null,
                'adresse' => null,
                'description_entreprise' => null,
            ]);
        } else {
            $user->assignRole('rechercheur');
            Rechercheur::create([
                'user_id' => $user->id,
                'titre_profil' => $request->titre_profil ?? 'Nouveau Rechercheur',
                'specialite' => 'Généraliste',
                'cv_path' => null,
                'ville' => null,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        if ($user->hasRole('recruteur')) {
            return redirect()->route('dashboard.recruteur');
        }
        return redirect()->route('dashboard.rechercheur');
    }
}
