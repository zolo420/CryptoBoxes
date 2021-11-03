<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\StringHelpers;
use App\Models\Logs;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Socialite;
use Auth;
use App\Models\User;

class GoogleSocialiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback(): JsonResponse
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser) {

                if (!$token = auth('api')->setTTL(30)->login($finduser)) {
                    return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
                }

                Logs::create([
                    'ip' => \Request::ip(),
                    'location' => StringHelpers::geoLocation(\Request::ip()),
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
                    'user_id' => $user->id,
                    'action' => Logs::ACTION_LOGIN
                ]);

                return $this->createNewToken($token);

            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'password' => encrypt(Str::uuid()->toString())
                ]);

                $newUser->email_verified_at = Carbon::now();
                $newUser->save();

                Logs::create([
                    'ip' => \Request::ip(),
                    'location' => StringHelpers::geoLocation(\Request::ip()),
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
                    'user_id' => $newUser->id,
                    'action' => Logs::ACTION_REGISTRATION
                ]);

                $token = auth('api')->setTTL(30)->login($newUser);

                return $this->createNewToken($token);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    protected function createNewToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
