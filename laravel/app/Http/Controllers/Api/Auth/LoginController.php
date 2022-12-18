<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function createOrGetUser($providerUser)
    {
        $user = User::where('email', $providerUser->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $providerUser->name,
                'email' => $providerUser->email,
                'password' => '',
            ]);
        }

        return $user;
    }

    public function callback($provider)
    {
        if (!request()->has('code') || request()->has('denied')) {
            return redirect()->to('/api/v1/auth/' . $provider);
        }
        $providerUser = Socialite::driver($provider)->user();
        $user = $this->createOrGetUser($providerUser);

        Auth::login($user, true);

        return redirect()->to('/')->withCookie('token', $user->createToken('token')->plainTextToken, 60 * 24);
    }

    public function withGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['email', 'profile'])
            ->redirect();
    }
}
