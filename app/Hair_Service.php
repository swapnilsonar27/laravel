<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hair_Service extends Model
{
    protected $table = 'Hair_Service';
    protected $primaryKey = 'Hair_service_ID';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Hair_service_ID', 'Service_Price', 'Service_Duration', 'Hair_Stylist_ID', 'Hair_Style_ID',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
