<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                'different:current_password',
                Password::min(12)->symbols()->numbers()
            ],
        ], [
            'current_password.required' => "Tu dois entrer ton mot de passe actuel.",
            'current_password.current_password' => "L'ancien mot de passe est incorrect.",
            'password.required' => "Merci de saisir un nouveau mot de passe.",
            'password.confirmed' => "La confirmation du mot de passe ne correspond pas.",
            'password.different' => "Le nouveau mot de passe doit être différent de l'ancien.",
            'password.min' => "Le mot de passe doit contenir au moins 12 caractères.",
            'password.symbols' => "Le mot de passe doit contenir au moins un symbole.",
            'password.numbers' => "Le mot de passe doit contenir au moins un chiffre.",
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }


}
