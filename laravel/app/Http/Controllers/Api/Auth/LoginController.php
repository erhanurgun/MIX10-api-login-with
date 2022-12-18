<?php

namespace App\Http\Controllers\Api\Auth;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\User;

class LoginController extends Controller
{
    public function createOrGetUser($providerUser)
    {
        try {
            $user = User::where('email', $providerUser->email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $providerUser->name,
                    'email' => $providerUser->email,
                    'password' => '',
                ]);
            }
            $user = User::where('email', $user->email)->first();
            return $user;
        } catch (\Exception $e) {
            return response()->json([
                'error' => "Kullanıcı sorgulaması esnasında bir hata oluştu. Hata: " . $e->getMessage()
            ], 500);
        }
    }

    public function callback($provider)
    {
        if (!request()->has('code') || request()->has('denied')) {
            return redirect()->to('/api/v1/auth/' . $provider);
        }
        $providerUser = Socialite::driver($provider)->user();
        $user = $this->createOrGetUser($providerUser);
        auth()->login($user, true);
        return response()->json([
            'success' => 'Kullanıcı kaydı başarıyla oluşturuldu.',
            'data' => new AuthResource($user)
        ], 200);
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
            'success' => 'Google ile giriş yapmak için bu google_auth_url adresine istek atabilirsiniz, eğer giriş yapamazsanız lütfen alternative_url adresine istek atınız.',
            'google_auth_url' => Socialite::driver('google')->redirect()->getTargetUrl(),
            'alternative_url' => env('GOOGLE_OAUTH_URL')
        ], 200);
    }
}
