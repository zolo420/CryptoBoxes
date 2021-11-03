<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use App\Events\EmailInvitation as Invitation;
use App\Models\EmailInvitation;
use App\Notifications\SendInvitation;

class SendInvitationNotify
{
    /**
     * Handle the event.
     *
     * @param Invitation $event
     *
     * @return void
     */
    public function handle(Invitation $event): void
    {
        $token = Str::uuid()->toString();

        EmailInvitation::create([
            'token' => $token,
            'email' => $event->email,
            'user_id' => $event->user->id,
        ]);

        $event->user->notify(new SendInvitation($token));
    }
}
