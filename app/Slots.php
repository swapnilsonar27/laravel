<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slots extends Model
{
    protected $table = 'Slots';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Slot_ID', 'Time_Start', 'Time_End', 'Day', 'Hair_Stylist_ID', 'Lunch_start_time', 'Lunch_End_time', 'Working_Day',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
