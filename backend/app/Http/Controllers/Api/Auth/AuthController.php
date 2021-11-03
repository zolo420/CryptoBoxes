<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserRegistered;
use App\Http\Requests\Api\Auth\{
    RegistrationRequest,
    LoginRequest,
};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    User,
    Logs,
    EmailInvitation,
};
use App\Http\Controllers\Controller;
use App\Helpers\{StringHelpers};
use App\Jobs\{CreateBTCWallet, CreateETHWallet};


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {

        if ($request->has('remember') && $request->remember == 'on')
            $ttl = 60 * 24 * 365;
        else
            $ttl = 30;

        if (!$token = auth()->setTTL($ttl)->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        Logs::create([
            'ip' => $request->ip(),
            'location' => StringHelpers::geoLocation($request->ip()),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'user_id' => auth()->user()->id,
            'action' => Logs::ACTION_LOGIN
        ]);

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @param RegistrationRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function registration(RegistrationRequest $request): JsonResponse
    {
        $user = User::create(array_merge($request->all(), ['password' => app('hash')->make($request->password)]));

        if ($request->referrer) {
            $emailInvitation = EmailInvitation::where('token', $request->referrer)->first();
            if ($emailInvitation) {
                $emailInvitation->is_registered = 1;
                $emailInvitation->save();
            }
        }

        Logs::create([
            'ip' => $request->ip(),
            'location' => StringHelpers::geoLocation($request->ip()),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'user_id' => $user->id,
            'action' => Logs::ACTION_REGISTRATION
        ]);

        dispatch(new CreateBTCWallet($user));

        dispatch(new CreateETHWallet($user));

        event(new UserRegistered($user));

        return response()->json(['success' => true], Response::HTTP_CREATED);

    }

    /**
     * @return JsonResponse
     */
    public function info(): JsonResponse
    {
        $user = Auth::user('web');

        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
