<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hair_Stylist_Preferences extends Model
{
    protected $table = 'Hair_Stylist_Preferences';
    protected $primaryKey = 'Preference_ID';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Preference_ID', 'Sms_notification', 'Sms_announcement', 'Hair_Stylist_ID',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
