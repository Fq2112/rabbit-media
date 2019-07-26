<?php

namespace App\Providers;

use App\Events\Auth\UserActivationEmail;
use App\Events\Clients\PaymentDetails;
use App\Listeners\Auth\SendActivationEmail;
use App\Listeners\Clients\SendPaymentDetails;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserActivationEmail::class => [
            SendActivationEmail::class,
        ],
        PaymentDetails::class => [
            SendPaymentDetails::class,
        ],
        SocialiteWasCalled::class => [
            'SocialiteProviders\\Instagram\\InstagramExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
