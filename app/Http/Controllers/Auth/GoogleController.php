<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'     => $googleUser->name,
                    'email'    => $googleUser->email,
                    'password' => bcrypt(uniqid()),
                    'role'     => 'user',
                ]);
            }

            Auth::login($user);
if ($user->role === 'admin') {
    return redirect('/myadmin');
}
return redirect('/');  // dashboard ki jagah home page
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google login failed. Please try again.');
        }
    }
}