<?php

namespace Asciisd\ReferralsLaravel\app\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use function App\Traits\route;

trait Referrerable
{

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
     * Self many-to-one relationship.
     *
     * @return HasMany
     */
    public function getReferrals(): HasMany
    {
        return $this->hasMany($this, 'referred_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function getReferrer(): BelongsTo
    {
        return $this->belongsTo($this, 'referrer_id', 'id');
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
            return $this->update(['referral_token' => Str::random()]);

        }

        return false;
    }

    public function referralLink(): Attribute
    {
        return Attribute::make(function(){
            return route(config('referral_route'), ['ref' => $this->referral_token]);
        });
    }


}
