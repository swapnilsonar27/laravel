<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Hair_Stylist_Payout;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
     /**
     * Update the profile info of user.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
    	if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {
	    	User::where('Hair_Stylist_ID', $id) -> update(["Tags" => $request->input('profile_info')]);
	    	//$user = User::where('Hair_Stylist_ID', $id) -> first();
	    	return response()->json(['status' => 200, 'msg' => 'Success'], 200);
    	}else {
    		return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
    	}
    }

    /**
     * Save the profile image of user.
     *
     * @param  int  $id
     * @return Response
     */
    public function store (Request $request) 
    {
    	$path = config('constants.image_path');
    	$filename = $request->input('id') . '.' . $request->photo->extension();
        $image_path = $path . "/" . $request->input('id') . "/profile/";

    	if( $request->hasFile('photo') ) {
	        $photo = $request->file('photo');
	        $photo->move($image_path, $filename);

	        User::where('Hair_Stylist_ID', $request->input('id')) -> update(["Profile_Image" => $image_path ."". $filename]);
	    	$user = User::where('Hair_Stylist_ID', $request->input('id')) -> first();
	    	return response()->json(['status' => 200, 'msg' => 'Success', 'data' => array('Profile_Image' => $user->Profile_Image)], 200);
	    }else {
	    	return response()->json(['status' => 400, 'msg' => 'Missing', 'data' => "File is missing / inproper in request"], 200);
	    }	
    }

    /**
     * Show the setup status of user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show ($id, Request $request) 
    {
    	$account = false;
    	$profile = false;
    	$business = false;
    	if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {

		   $user = User::where('Hair_Stylist_ID', $id) -> where('activated', true) -> first();
		   if(isset($user)) {
                $account = true;
    		   if(isset($user->Profile_Image) || isset($user->Tags))
    		   	$profile = true;

    		   if($users = User::where('Hair_Stylist_ID', '=', $id)
    		   	->whereNotNull('Salon_or_Mobile')->exists()) {
    		   		$business = true;
    		   }
            }
		}else {
			return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);	
		}

		$data = array(
			"account" => $account, "profile" => $profile, "business" => $business
		);
		return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $data], 200);
        
    }

    /**
     * Update the account info of user.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateAccount($id, Request $request) 
    {
        if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {
            User::where('Hair_Stylist_ID', $id) -> update(["First_Name" => $request->input('first_name'), 
                        "Surname" => $request->input('last_name'),
                        "Email" => $request->input('email'), 
                        "Mobile_Number" => $request->input('mobile'),
                        "birthday" => $request->input('birthday')
                        ]);
            return response()->json(['status' => 200, 'msg' => 'Success'], 200);
        } else {
            return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
        }
    }

    /**
     * Update the Payout info of user.
     *
     * @param  data
     * @return Response
     */
    public function updatePayoutDetails(Request $request) 
    {
        $id = $request->input('id');
        $full_name = $request->input('full_name');
        $bank_name = $request->input('bank_name');
        $account_no = $request->input('account_no');
        $sort_code = $request->input('sort_code');
        if (User::where('Hair_Stylist_ID', '=', $id)->exists()) {
            Hair_Stylist_Payout::updateOrCreate(["hair_stylist_id" => $id ],
                ["full_name" => $full_name,
                "bank_name" => $bank_name,
                "account_no" => $account_no,
                "sort_code" => $sort_code
                ]);
            return response()->json(['status' => 200, 'msg' => 'Success'], 200);
        } else {
            return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
        }
    }

    /**
     * Update the Payout info of user.
     *
     * @param  id
     * @return Response
     */
    public function getPayoutDetails($id, Request $request) 
    {
        $data = Hair_Stylist_Payout::where('hair_stylist_id', $id) -> get();
        return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $data], 200);
    }
}
