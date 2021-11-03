<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use App\Events\UserRegistered;
use App\Models\Auth\EmailConfirm;
use App\Notifications\ConfirmationRegistration;

class SendConfirmationRegistrationNotify
{
    /**
     * Handle the event.
     *
     * @param UserRegistered $event
     *
     * @return void
     */
    public function handle(UserRegistered $event): void
    {
        $token = Str::uuid()->toString();

        EmailConfirm::create([
            'email' => $event->user->email,
            'token' => $token,
        ]);

        $event->user->notify(new ConfirmationRegistration($token));
    }
}
