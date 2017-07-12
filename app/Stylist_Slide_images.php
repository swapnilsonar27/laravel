<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stylist_Slide_images extends Model
{
    protected $table = 'Stylist_Slide_images';
    protected $primaryKey = "Images_ID";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Images_ID', 'Image_link', 'Image_Date_Added', 'Hair_Stylist_ID',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
