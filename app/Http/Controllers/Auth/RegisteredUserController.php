<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

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
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(12)->symbols()->numbers()
            ],
        ], [
            'name.unique' => 'Ce nom d’utilisateur est déjà pris.',
            'email.unique' => 'Cet email est déjà utilisé par un autre compte.',
            'password.min' => 'Le mot de passe doit contenir au moins 12 caractères.',
            'password.symbols' => 'Le mot de passe doit contenir au moins un symbole.',
            'password.numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $colorPalette = ['#06b6d4', '#8b5cf6', '#c72626ff', '#dd872bff', '#84cc16', '#eab308', '#1c1917', '#4043d1ff', '#ec4899'];
        $randomColor = $colorPalette[array_rand($colorPalette)];

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'couleur' => $randomColor,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('projet.index'));
    }
}
