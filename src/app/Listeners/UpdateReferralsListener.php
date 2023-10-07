<?php

namespace Asciisd\ReferralsLaravel\app\Listeners;

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
    public function handle($event): void
    {
        $event->user->referral()->create(['referrer_id' => $event->user->getReferrerIdFromReferralToken()]);
    }
}
