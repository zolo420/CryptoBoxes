<?php

namespace App\Providers;

use App\Events\{ForgotPassword,UserRegistered,EmailInvitation};
use App\Listeners\{SendForgotPasswordNotify,SendConfirmationRegistrationNotify,SendInvitationNotify};
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegistered::class => [
            SendConfirmationRegistrationNotify::class,
        ],
        ForgotPassword::class => [
            SendForgotPasswordNotify::class,
        ],
        EmailInvitation::class => [
            SendInvitationNotify::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
    }
}
