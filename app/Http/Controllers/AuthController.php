<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('animals.index'); 
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('animals.index'));
        }

        return back()->withErrors(['email' => 'The provided credentials are incorrect.']);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('animals.index');
    }

public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


public function handleGoogleCallback()
{
    try {
        $guzzleClient = new \GuzzleHttp\Client([
            'verify' => false,
            'timeout' => 20.0,
        ]);

        $driver = \Laravel\Socialite\Facades\Socialite::driver('google');
        $driver->setHttpClient($guzzleClient);

        $googleUser = $driver->user();
        
        $user = \App\Models\User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = \App\Models\User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(\Illuminate\Support\Str::random(24)),
            ]);
        }

        auth()->login($user, true); 

        return redirect()->route('animals.index');

    } catch (\Exception $e) {
        return response('Google Authentication Handshake Failure: ' . $e->getMessage(), 500);
    }
}
}
