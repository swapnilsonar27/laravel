<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salon_Address extends Model
{
    protected $table = 'Salon_Address';
    protected $primaryKey = 'Salon_Address_Id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Salon_Address_Id', 'business_name', 'First_Line_Address', 'Secound_Line_Address', 'Post_Code', 'Hair_Stylist_ID', 'address_notes',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];
}
