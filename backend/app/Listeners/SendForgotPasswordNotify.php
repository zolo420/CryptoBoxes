<?php

namespace App\Listeners;

use Throwable;
use Illuminate\Support\Str;
use App\Events\ForgotPassword;
use App\Models\Auth\PasswordReset;
use Illuminate\Support\Facades\DB;
use App\Notifications\ForgotPassword as Notify;

class SendForgotPasswordNotify
{
    /**
     * Handle the event.
     *
     * @param ForgotPassword $event
     *
     * @throws Throwable
     *
     * @return void
     */
    public function handle(ForgotPassword $event): void
    {
        DB::transaction(function () use ($event) {
            $reset = PasswordReset::create([
                'email' => $event->user->email,
                'token' => Str::uuid()->toString(),
            ]);

            $event->user->notify(new Notify($reset->token));
        });
    }
}
