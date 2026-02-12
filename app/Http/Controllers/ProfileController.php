<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function manage(Request $request){
        $role = auth()->user()->role->value ;
        if($role === 'RECRUTEUR'){
            return view('profile.manage', ['u' => $request->user(),]);
        }else{
            return view('rechercheur.profile.edi', ['u' => $request->user(),]);
        }

        
    }

    public function manageUpdate(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:50'],
            'prenom' => ['required', 'string', 'max:50'],
            'biographie' => ['nullable', 'string'],
            'image' => ['nullable', 'url'],
            'role' => ['required', 'in:RECRUTEUR,RECHERCHEUR'],
            'entreprise' => ['nullable', 'string', 'max:150'],
            'site_web' => ['nullable', 'url', 'max:200'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'ville' => ['nullable', 'string', 'max:80'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'description_entreprise' => ['nullable', 'string'],
        ]);

        $user->update([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'biographie' => $data['biographie'],
            'image' => $data['image'],
            'role' => $data['role'],
        ]);

        if ($user->hasRole('recruteur')) {
            $recruteur = $user->recruteur()->firstOrCreate(['user_id' => $user->id], ['entreprise' => 'Indépendant']);
            
            $recruteur->update([
                'entreprise' => $data['entreprise'] ?? $recruteur->entreprise,
                'site_web' => $data['site_web'] ?? null,
                'telephone' => $data['telephone'] ?? null,
                'ville' => $data['ville'] ?? null,
                'adresse' => $data['adresse'] ?? null,
                'description_entreprise' => $data['description_entreprise'] ?? null,
            ]);
        }

        return redirect()
            ->route('profile.manage')
            ->with('status', 'Profil mis à jour ');
    }
}
