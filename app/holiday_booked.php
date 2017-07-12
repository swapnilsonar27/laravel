<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class holiday_booked extends Model
{
    protected $table = 'holiday_booked';
    protected $primaryKey = 'holiday_booked_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'holiday_booked_id', 'hair_stylist_id', 'start_date', 'end_date', 'end_time', 'start_time',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
