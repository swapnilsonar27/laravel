<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'Hair_Stylist';
    protected $primaryKey = 'Hair_Stylist_ID';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Hair_Stylist_ID', 'First_Name', 'Email', 'password', 'Surname', 'Mobile_Number', 
        'Salon_or_Mobile', 'First_Line_Address', 'Post_Code', 'County', 'birthday', 
        'address_notes', 'activated','activation_token', 'device_id', 'device_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_token', 'device_id', 'device_type',
    ];
}
