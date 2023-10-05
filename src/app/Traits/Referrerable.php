<?php

namespace Asciisd\ReferralsLaravel\app\Traits;

use App\Models\User;
use Asciisd\ReferaralsLaravel\app\Models\Referral;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

trait Referrerable
{

    public function referral(): MorphOne
    {
        return $this->morphMany(Referral::class, 'referrable');
    }

    /**
     * Check if user is registered with referral token or not.
     *
     * @return bool
     */
    public function isReferred(): bool
    {
        return isset($this->referrer_id);
    }


    /**
     * Check if user has referral token.
     *
     * @return bool
     */
    public function hasReferralToken(): bool
    {
        return isset($this->referral_token);
    }

    /**
     * Generate referral token if not exist.
     *
     * @return bool
     */
    public function generateReferralToken(): bool
    {
        if (!$this->hasReferralToken()) {
            return $this->update(['referral_token' => random_int(1000000, 9999999)]);

        }

        return false;
    }

    public function referralLink(): Attribute
    {
        return Attribute::make(function () {
            return route(config('referrals.referral_route'), ['ref' => $this->referral_token]);
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
        return $this->id;
    }

    public function getReferrerIdFromReferralToken()
    {
        // Get referral token from query.
        $referral_token = request()->hasCookie('referral_token') ? request()->cookie('referral_token') : null;
        $user = $referral_token != null ? User::where('referral_token', $referral_token)->first('id') : null;

        return $user?->referrerId();
    }

}
