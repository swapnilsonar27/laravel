<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Booking;

class BookingController extends Controller
{
    /**
     * Get Upcoming Booking data of user.
     *
     * @param  id
     * @return Response
     */
    public function getBookings (Request $request) {
        $type =  $request->input('type');
        $toay = $request->input('date');
        $id = $request->input('id');

        $today_obj = explode(' ', $toay);
        $today_date = $today_obj['0'];
        $today_time = $today_obj['1'];

        if($type == 'upcoming') {
            $booking = Booking::join('Client', 'Bookings.Client_ID', '=', 'Client.Client_ID')
            ->join('Hair_Stylist', 'Bookings.Hair_Stylist_ID', '=', 'Hair_Stylist.Hair_Stylist_ID')
            ->leftJoin('Salon_Address', 'Bookings.Hair_Stylist_ID', '=', 'Salon_Address.Hair_Stylist_ID')
            ->leftJoin('Review', 'Bookings.Booking_ID', '=', 'Review.booking_id')
            ->join('Hair_Service', 'Bookings.Hair_Service_ID', '=', 'Hair_Service.Hair_Service_ID')
            ->join('Hair_Style', 'Hair_Service.Hair_Style_ID', '=', 'Hair_Style.Hair_Style_ID')
            ->where('Bookings.Hair_Stylist_ID', $id)->whereDate('date_of_booking', '>', $today_date )
            ->whereTime('start_time', '>', $today_time )
            ->select('Bookings.Booking_ID', 'Client.Client_ID', 'Bookings.Booking_Status',
                'Client.First_Name as client_first_name', 
                'Client.Surname as client_last_name', 'Bookings.date_of_booking', 
                'Client.Profile_Image as client_profile_image', 'Bookings.start_time', 
                'Bookings.finish_time', 'Hair_Stylist.Salon_Or_Mobile as booking_type',
                'Hair_Stylist.First_Line_Address as hair_stylist_home_address1',
                'Hair_Stylist.Secound_Line_Address as hair_stylist_home_address2',
                'Hair_Stylist.Post_Code as hair_stylist_home_postcode',
                'Salon_Address.business_name as venue_name',
                'Salon_Address.First_Line_Address as salon_address1',
                'Salon_Address.Secound_Line_Address as salon_address2',
                'Salon_Address.Post_Code as salon_postcode',
                'Review.Rating_Number', 'Review.Comment as review_comment',
                'Hair_Service.Service_Price', 'Hair_Style.Style')->get();

            return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $booking], 200);
        }else if($type == 'past') {
            $booking = Booking::join('Client', 'Bookings.Client_ID', '=', 'Client.Client_ID')
            ->join('Hair_Stylist', 'Bookings.Hair_Stylist_ID', '=', 'Hair_Stylist.Hair_Stylist_ID')
            ->leftJoin('Salon_Address', 'Bookings.Hair_Stylist_ID', '=', 'Salon_Address.Hair_Stylist_ID')
            ->leftJoin('Review', 'Bookings.Booking_ID', '=', 'Review.booking_id')
            ->join('Hair_Service', 'Bookings.Hair_Service_ID', '=', 'Hair_Service.Hair_Service_ID')
            ->join('Hair_Style', 'Hair_Service.Hair_Style_ID', '=', 'Hair_Style.Hair_Style_ID')
            ->where('Bookings.Hair_Stylist_ID', $id)->whereDate('date_of_booking', '<=', $today_date )
            ->whereTime('start_time', '<=', $today_time )
            ->select('Bookings.Booking_ID', 'Client.Client_ID', 'Bookings.Booking_Status',
                'Client.First_Name as client_first_name', 
                'Client.Surname as client_last_name', 'Bookings.date_of_booking', 
                'Client.Profile_Image as client_profile_image', 'Bookings.start_time', 
                'Bookings.finish_time', 'Hair_Stylist.Salon_Or_Mobile as booking_type',
                'Hair_Stylist.First_Line_Address as hair_stylist_home_address1',
                'Hair_Stylist.Secound_Line_Address as hair_stylist_home_address2',
                'Hair_Stylist.Post_Code as hair_stylist_home_postcode',
                'Salon_Address.business_name as venue_name',
                'Salon_Address.First_Line_Address as salon_address1',
                'Salon_Address.Secound_Line_Address as salon_address2',
                'Salon_Address.Post_Code as salon_postcode',
                'Review.Rating_Number', 'Review.Comment as review_comment',
                'Hair_Service.Service_Price', 'Hair_Style.Style')->get();
            return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $booking], 200);
        }
    }

    /**
     * Confirm Booking
     *
     * @param  id
     * @return Response
     */
    public function confirmBooking (Request $request) {
        $booking_id = $request->input('bookingId');
        Booking::where('Booking_ID', $booking_id) -> update(["Booking_Status" => true]);
        return response()->json(['status' => 200, 'msg' => 'Success']);
    }
}
