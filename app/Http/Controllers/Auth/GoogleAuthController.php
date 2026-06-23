<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    private function googleDriver()
    {
        $driver = Socialite::driver('google');

        $redirect = config('services.google.redirect');
        if (! str_starts_with($redirect, 'http')) {
            $redirect = url($redirect);
        }
        $driver->redirectUrl($redirect);

        if (config('app.env') === 'local') {
            $driver->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
        }

        return $driver;
    }

    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        try {
            return $this->googleDriver()->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'La connexion via Google est actuellement indisponible : ' . $e->getMessage()]);
        }
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = $this->googleDriver()->user();
            
            // Find or create the user
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Update Google info if not set
                $user->update([
                    'google_id'    => $googleUser->id,
                    'google_token' => $googleUser->token,
                ]);
            } else {
                // Create a new client user
                $user = User::create([
                    'name'         => $googleUser->name,
                    'email'         => $googleUser->email,
                    'google_id'    => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'role'         => 'client',
                    'status'       => 'active',
                    'password'     => null, // Password is null for social users
                ]);
            }

            if (!$user->isActive()) {
                return redirect()->route('login')->withErrors(['email' => 'Votre compte est suspendu.']);
            }

            Auth::login($user, true);

            return redirect()->route('public.index');

        } catch (Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Impossible de se connecter avec Google : ' . $e->getMessage()]);
        }
    }
}
