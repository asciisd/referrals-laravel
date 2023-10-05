<?php

namespace Asciisd\ReferaralsLaravel\app\Listeners;


use Asciisd\ReferaralsLaravel\app\Events\UpdateReferral;
use http\Cookie;

class UpdateReferralsListener
{
    /**
     * Create the event listener.
     */
    public function __construct() { }

    /**
     * Handle the event.
     */
    public function handle(UpdateReferral $event): void
    {
        $event->user->referrals()->create(['referrer_id' => $event->user->getReferrerIdFromReferralToken()]);
    }
}