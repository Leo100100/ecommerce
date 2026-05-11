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

class VendedorRegistrationController extends Controller
{
    public function create(): View
    {
        return view('auth.register-vendedor');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'cnpj'                  => ['required', 'string', 'max:18', 'unique:users,cnpj'],
            'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'cnpj'     => preg_replace('/\D/', '', $request->cnpj),
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'vendedor' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
    }
}
