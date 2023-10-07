<?php

namespace Asciisd\ReferralsLaravel\app\Traits;

use App\Models\User;
use Asciisd\ReferralsLaravel\app\Models\Referral;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\Uuid;

trait Referrerable
{

    /**
     * Get referrals.
     *
     * @return HasMany
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'referrer_id', 'id');
    }


    /**
     * Get referral detials from referrals table.
     *
     * @return HasMany
     */
    public function referral(): HasOne
    {
        return $this->hasOne(Referral::class, 'user_id', 'id');
    }


    /**
     * Check if user is registered with referral token or not.
     *
     * @return bool
     */
    public function isReferred(): bool
    {
        return isset($this->referral->referrer_id);
    }


    /**
     * Check if user has referral token.
     *
     * @return bool
     */
    public function hasReferralToken(): bool
    {
        return isset($this->referral->referral_token);
    }

    /**
     * Generate referral token if not exist.
     *
     * @return bool
     */
    public function generateReferralToken(): bool
    {
        if (!$this->hasReferralToken()) {
            return $this->referral()->update(['referral_token' => random_int(1000000, 9999999)]);

        }

        return false;
    }

    /**
     * Get referral link
     *
     * @return mixed
     */
    public function getReferralLink()
    {
        return route(config('referrals.referral_route'), ['ref' => $this->referral->referral_token]);
    }


    /**
     * Adding accessor to User model as referral_link
     *
     * @return Attribute
     */
    public function referralLink(): Attribute
    {
        return Attribute::make(function () {
            return $this->getReferralLink();
        });
    }


    /**
     * Get referral token
     *
     * @return mixed
     */
    public function getReferralToken()
    {
        return $this->referral->referral_token;
    }


    /**
     * Adding accessor to user attributes as referral_token
     *
     * @return Attribute
     */
    public function referralToken(): Attribute
    {
        return Attribute::make(function () {
            return $this->getReferralToken();
        });
    }

    /**
     * The referrer id will be the user id, you can override this
     * method to determine which will be used as user id in the
     * referrer_id column.
     *
     * @return mixed
     */
    public function referrerId()
    {
        return $this->id;   //TODO::Fix with nova to show data with choosen referrerId
    }

    /**
     * Get the referralId from the ref cookie by referral token.
     *
     * @return null
     */
    public function getReferrerIdFromReferralToken()
    {
        // Get referral token from query.
        $referral_token = request()->hasCookie('referral_token') ? request()->cookie('referral_token') : null;
        return $referral_token != null ? Referral::where('referral_token', $referral_token)->first()->referrer->referrerId() : null;
    }

}
