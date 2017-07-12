<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hair_Stylist_Payout extends Model
{
    protected $table = 'Hair_Stylist_Payout';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'hair_stylist_id', 'full_name', 'bank_name', 'account_no', 'sort_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
