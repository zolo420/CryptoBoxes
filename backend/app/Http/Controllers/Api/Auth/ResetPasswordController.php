<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\StringHelpers;
use App\Models\Logs;
use Throwable;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Models\Auth\PasswordReset;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;

/**
 * @group Авторизация/Регистрация (authentication/registration).
 */
class ResetPasswordController extends Controller
{
    /**
     * Сброс пароля (reset password).
     *
     * @response 204 {}
     *
     * @param ResetPasswordRequest $request
     *
     * @throws Throwable
     *
     * @return JsonResponse
     */
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        $reset = PasswordReset::firstWhere('token', $request->token);
        $user = User::whereEmail($reset->email)->firstOrFail();

        DB::transaction(function () use ($request, $user, $reset) {
            $user->update(['password' => bcrypt($request->password)]);
            $reset->delete();
        });

        Logs::create([
            'ip' => $request->ip(),
            'location' => StringHelpers::geoLocation($request->ip()),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'user_id' => $user->id,
            'action' => Logs::ACTION_PASSWORD_RESET
        ]);

        return response()->json(['success' => true]);
    }
}
