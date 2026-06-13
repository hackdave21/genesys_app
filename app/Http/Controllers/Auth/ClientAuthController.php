<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ClientAuthController extends Controller
{
    /**
     * Show the client login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('public.index');
        }
        return view('public.login');
    }

    /**
     * Handle client login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, true)) {
            $user = Auth::user();
            
            if (!$user->isActive()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Votre compte a été suspendu. Contactez le support.']);
            }

            $request->session()->regenerate();
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('public.index'));
        }

        return back()->withErrors([
            'email' => 'Identifiants de connexion incorrects.',
        ])->onlyInput('email');
    }

    /**
     * Show the client registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('public.index');
        }
        return view('public.register');
    }

    /**
     * Handle client registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|string|max:50',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'client',
            'status'   => 'active',
        ]);

        Auth::login($user);

        return redirect()->route('public.index')->with('success', 'Votre compte a été créé avec succès.');
    }

    /**
     * Log the client out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('public.index');
    }
}
