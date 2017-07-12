<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Salon_Address;
use App\Slots;
use App\holiday_booked;
use App\Hair_Style;
use App\Hair_Service;
use App\Hair_Stylist_Preferences;

class BusinessController extends Controller
{
    /**
     * Save the Business data of user.
     *
     * @param  Business data
     * @return Response
     */
    public function setupLocation (Request $request) 
    {
    	$id = $request->input('id');
    	if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {
            
            if($request->input('type') == "Mobile" || $request->input('type') == "mobile") {
                User::where('Hair_Stylist_ID', $id) -> update(["Salon_or_Mobile" => $request->input('type'), 
                    "First_Line_Address" => $request->input('address1'),
                    "Secound_Line_Address" => $request->input('address2'), 
                    "Post_Code" => $request->input('postcode'), 
                    "County" => $request->input('country'),
                    "address_notes" => $request->input('address_notes')]);

            }else if($request->input('type') == "Salon" || $request->input('type') == "salon") {
                User::where('Hair_Stylist_ID', $id) -> update(["Salon_or_Mobile" => $request->input('type'), 
                    "First_Line_Address" => $request->input('address1'), 
                    "Secound_Line_Address" => $request->input('address2'), 
                    "Post_Code" => $request->input('postcode'), 
                    "County" => $request->input('county'),
                    "address_notes" => $request->input('address_notes')]);

                if($request->input('business_from') == "Salon"){
                    Salon_Address::updateOrCreate(["Hair_Stylist_ID" => $id ],
                        [ "business_name" => $request->input('venue_name'),
                        "First_Line_Address" => $request->input('salon_address1'),
                        "Secound_Line_Address" => $request->input('salon_address2'),
                        "Post_Code" => $request->input('salon_postcode'),
                        "address_notes" => $request->input('salon_address_notes')
                         ]);
                }
            }
            //return $this->getLocation($id);
	    	return response()->json(['status' => 200, 'msg' => 'Success'], 200);
    	}else {
    		return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
    	}
    }

    /**
     * Save the Availability data of user.
     *
     * @param  Availability data
     * @return Response
     */
    public function setupAvailability (Request $request) 
    {
        $id = $request->input('id');
        if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {
            if(Slots::where('Hair_Stylist_ID', $id) -> exists()){
                Slots::where('Hair_Stylist_ID', $id)->delete();
            }

            $availability = $request->input('available');
            foreach ($availability as $key => $value) {
                Slots::create([
                    "Time_Start" => $value['time_start'],
                    "Time_End" =>  $value['time_end'],
                    "Day" =>  $value['day'],
                    "Hair_Stylist_ID" =>  $id,
                    "Lunch_start_time" =>  isset($value['break_start'])?$value['break_start']:null,
                    "Lunch_End_time" =>  isset($value['break_end'])?$value['break_end']:null,
                    "Working_Day" => true
                    ]);
            }
            
            return response()->json(['status' => 200, 'msg' => 'Success'], 200);
        }else {
            return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
        }

    }

    /**
     * Save the Unavailability data of user.
     *
     * @param  Unavailability data
     * @return Response
     */
    public function setupUnavailability (Request $request) 
    {
        $id = $request->input('id');
        if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {
            if(holiday_booked::where('hair_stylist_id', $id) -> exists()){
                holiday_booked::where('hair_stylist_id', $id)->delete();
            }
            $unavailability = $request->input('unavailable');
            foreach ($unavailability as $key => $value) {
                holiday_booked::create([
                    'hair_stylist_id' => $id, 
                    'start_date' => $value['start_date'], 
                    'end_date' => $value['end_date'], 
                    'end_time' => $value['end_time'], 
                    'start_time' => $value['start_time']
                ]);
            }
            return response()->json(['status' => 200, 'msg' => 'Success'], 200);
        }else {
            return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
        }
    }

    /**
     * Save the Service data of user.
     *
     * @param  Service data
     * @return Response
     */
    public function setupService (Request $request) 
    {
        $id = $request->input('id');
        if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {
            if(Hair_Service::where('Hair_Stylist_ID', $id) -> exists()){
                Hair_Service::where('Hair_Stylist_ID', $id)->delete();
            }
            $services = $request->input('service');
            foreach ($services as $key => $value) {
                Hair_Service::create([
                    'Service_Price' => $value['service_price'], 
                    'Service_Duration' => $value['service_duration'], 
                    'Hair_Stylist_ID' => $id, 
                    'Hair_Style_ID' => $value['hair_style_id']
                ]);
            }
            return response()->json(['status' => 200, 'msg' => 'Success'], 200);
        }else {
            return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
        }
    }

    /**
     * Save the Preference data of user.
     *
     * @param  Service data
     * @return Response
     */
    public function setupPreference (Request $request) 
    {
        $id = $request->input('id');
        if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {
            Hair_Stylist_Preferences::updateOrCreate(["Hair_Stylist_ID" => $id ], [
                'Sms_notification' => $request->input('sms_notification'),
                'Sms_announcement' => $request->input('sms_announcement') 
                ]);
            return response()->json(['status' => 200, 'msg' => 'Success'], 200);
        }else {
            return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
        }
    }

    /**
     * Get location data of user.
     *
     * @param  Location data
     * @return Response
     */
    public function getLocation ($id) 
    {
        if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {
            $response = array();
            $user = User::where('Hair_Stylist_ID', $id) -> first();
            $response['id'] = $id;
            $response['type'] = $user -> Salon_Or_Mobile;
            $salon_address = Salon_Address::where('Hair_Stylist_ID', $id) -> first();
            if(isset($salon_address)) {
                $response['business_from'] = 'Salon';
                $response['venue_name'] = $salon_address -> business_name;
                $response['salon_address1'] = $salon_address -> First_Line_Address;
                $response['salon_address2'] = $salon_address -> Secound_Line_Address;
                $response['salon_postcode'] = $salon_address -> Post_Code;
                $response['salon_address_notes'] = $salon_address -> address_notes;
            }else {
                $response['business_from'] = 'Home';
            }
            $response['address1'] = $user -> First_Line_Address;
            $response['address2'] = $user -> Secound_Line_Address;
            $response['postcode'] = $user -> Post_Code;
            $response['county'] = $user -> County;
            $response['address_notes'] = $user -> address_notes;
            return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $response], 200);

        }else {
            return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
        }
    }

    /**
     * Get availability data of user.
     *
     * @param  Availability data
     * @return Response
     */
    public function getAvailability ($id, Request $request) {
        
        $slots = Slots::where('Hair_Stylist_ID', $id)->select(
            'Hair_Stylist_ID as hair_stylist_id',
            'Slot_ID as slot_id', 
            'Time_Start as time_start',
            'Time_End as time_end',
            'Day as day',
            'Lunch_start_time as break_start',
            'Lunch_End_time as break_end')->get();
        return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $slots], 200);
    }

    /**
     * Get unavailability data of user.
     *
     * @param  Unavailability data
     * @return Response
     */
    public function getUnavailability ($id, Request $request) {
        $holiday_booked = holiday_booked::where('Hair_Stylist_ID', $id)->get();
        return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $holiday_booked], 200);
    }

    /**
     * Get Service data of user.
     *
     * @param  Service data
     * @return Response
     */
    public function getService ($id, Request $request) {
        $Hair_Service = Hair_Service::where('Hair_Stylist_ID', $id)->get();
        return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $Hair_Service], 200);
    }

    /**
     * Get the Preference data of user.
     *
     * @param  Preference data
     * @return Response
     */
    public function getPreference ($id, Request $request) 
    {
        if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {
            $data = Hair_Stylist_Preferences::leftJoin('Hair_Stylist', 'Hair_Stylist_Preferences.Hair_Stylist_ID', '=', 'Hair_Stylist.Hair_Stylist_ID')
            ->where('Hair_Stylist.Hair_Stylist_ID', $id)
            ->select('Hair_Stylist.Hair_Stylist_ID', 'Mobile_Number', 'Sms_notification', 
                'Sms_announcement')->get();
            return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $data], 200);
        }else {
            return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
        }
    }

}
