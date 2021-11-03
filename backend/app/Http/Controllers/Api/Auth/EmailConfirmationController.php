<?php

namespace App\Http\Controllers\Api\Auth;

use Throwable;
use App\Models\Auth\EmailConfirm;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\EmailConfirmRequest;
use Carbon\Carbon;

/**
 * @group Авторизация/Регистрация (authentication/registration).
 */
class EmailConfirmationController extends Controller
{
    /**
     * Потверждение email (email confirmation).
     *
     * @urlParam token string required токен подтверждения
     *
     * @response 204 {}
     *
     * @param EmailConfirm $confirm
     *
     * @throws Throwable
     *
     * @return JsonResponse
     */
    public function __invoke(EmailConfirmRequest $request): JsonResponse
    {
        $confirm = EmailConfirm::firstWhere('token', $request->token);
        $user = User::whereEmail($confirm->email)->firstOrFail();

        DB::transaction(function () use ($user, $confirm) {
            $user->email_verified_at = Carbon::now();
            $user->save();
            $confirm->delete();
        });

        return response()->json(['success' => true]);
    }
}
