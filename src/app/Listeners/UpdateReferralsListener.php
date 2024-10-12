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
        // Check first if getReferrerIdFromReferralToken not empty
        if ($event->user->getReferrerIdFromReferralToken()) {
            $event->user->referral()->create(['referrer_id' => $event->user->getReferrerIdFromReferralToken()]);
        }
    }
}
