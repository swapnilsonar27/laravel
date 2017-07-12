<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hair_Style extends Model
{
    protected $table = 'Hair_Style';
    protected $primaryKey = 'Hair_Style_ID';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Hair_Style_ID', 'Style', 'Price', 'Duration', 'Hair_Style_Description', 'Type_Of_Style',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
