<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Events\ForgotPassword;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;

/**
 * @group Авторизация/Регистрация (authentication/registration).
 */
class ForgotPasswordController extends Controller
{

    /**
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function __invoke(ForgotPasswordRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        event(new ForgotPassword($user));

        return response()->json(['success' => true]);
    }
}
