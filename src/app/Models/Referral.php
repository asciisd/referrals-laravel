<?php

namespace Asciisd\ReferralsLaravel\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
        'referral_token', 'referrer_id'];


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
     * @return MorphTo
     */
    public function referrable(): MorphTo
    {
        return $this->morphTo();
    }

}