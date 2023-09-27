<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Referral Route Name
    |--------------------------------------------------------------------------
    |
    | The following configuration option contains your referral route where
    | you want the invited user to be redirected to. By default, the
    | invited user will be redirected to the register page with
    | referral token are URL query "?ref=referral_token".
    |
    */

    'referral_route' => env('REFERRAL_ROUTE', 'register'),

    /*
    |--------------------------------------------------------------------------
    | Referral Cookies Lifetime
    |--------------------------------------------------------------------------
    |
    | The following configuration option contains your referral token cookie
    | life-time. If you want to save the referral token to a cookie for
    | further usage in your application you can do that by adding the
    | 'ReferralLaravel' middleware to your project Kernel.php.
    | By default, the cookie life-time is 24 hours.
    |
    */

    'referral_token_cookie_lifetime' => env('REFERRAL_TOKEN_COOKIE_LIFETIME', 1500),

];