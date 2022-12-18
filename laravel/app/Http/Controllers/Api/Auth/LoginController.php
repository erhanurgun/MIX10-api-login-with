<?php

namespace App\Http\Controllers\Api\Auth;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

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
        // open new tab
        $providerUser = Socialite::driver($provider)->user();
        $user = $this->createOrGetUser($providerUser);
        $token = $user->createToken()->accessToken;
        $response = 'Bearer ' . $token;
        Auth::login($user, true);

        return response()->json([
            'token' => $token,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/auth/{provider}",
     *     tags={"Auth"},
     *     summary="Login with Google",
     *     description="Login with Google",
     *     operationId="withGoogle",
     *     @OA\Parameter(
     *     name="provider",
     *     in="path",
     *     description="Provider name",
     *     required=true,
     *     @OA\Schema( type="string", enum={"google", "apple"}, default="google")
     *     ),
     *     @OA\Response(
     *     response=302,
     *     description="Redirect to Google login page"
     *     ),
     *     @OA\Response(
     *     response=400,
     *     description="Bad request"
     *     ),
     *     @OA\Response(
     *     response=404,
     *     description="Not found"
     *     ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal server error"
     *     ),
     * )
     */
    public function withGoogle()
    {
        return response()->json([
            'url' => Socialite::driver('google')->redirect()->getTargetUrl(),
        ], 200);
    }
}
