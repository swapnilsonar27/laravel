<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'Bookings';
    protected $primaryKey = 'Booking_ID';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Booking_ID', 'Notes', 'Payment_Status', 'Booking_Status', 'Date_Booked', 
        'Client_ID', 'Promo_Code_ID', 'Hair_service_ID', 'date_of_booking', 
        'start_time', 'finish_time', 'Hair_Stylist_ID', 'payment_type', 
        'booking_price', 'card_last_numbers', 'transact_id', 'reviewed',
        'client_first_line_address', 'client_city', 'client_post_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}