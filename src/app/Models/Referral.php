<?php

namespace Asciisd\ReferralsLaravel\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{

    /**
     * Targeted table
     *
     * @var string
     */
    protected $table = 'referrals';

    /**
     * Mass-assignment fields
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'referral_token', 'referrer_id'];


    /**
     * Guarded fields from mass assignment check
     *
     * @var array
     */
    protected $guarded = [
        'id', 'create_at', 'updated_at'];


    /**
     * Polymorphic relationship
     *
     * @return BelongsTo
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    /**
     * Get all invited users by each referral user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allReferrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id', 'user_id');
    }


    /**
     * This relationship to get the invited user details.
     *
     * @return void
     */
    public function details()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
