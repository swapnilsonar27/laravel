<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stylist_Slide_images;
use App\User;

class PortfolioController extends Controller
{
    /**
     * Save the portfolio image of user.
     *
     * @param  int  $id
     * @readdir()turn Response
     */
    public function store(Request $request) 
    {
    	if (User::where('Hair_Stylist_ID', '=', $request->input('id'))->exists()) {
	    	$path = config('constants.image_path');
	    	$filename = md5($request->photo->getClientOriginalName() . microtime()) . '.' . $request->photo->extension();
	        $image_path = $path . "/" . $request->input('id') . "/portfolio/";

	    	if( $request->hasFile('photo') ) {
		        $photo = $request->file('photo');
		        $photo->move($image_path, $filename);

		        $user = Stylist_Slide_images::where('Hair_Stylist_ID', $request->input('id')) -> get();
		        $portfolio = Stylist_Slide_images::create([
		        	'Hair_Stylist_ID' => $request->input('id'),
		        	'Image_link' => $image_path . "" . $filename
		        ]);
		    	return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $user], 200);
		    }else {
		    	return response()->json(['status' => 400, 'msg' => 'Missing', 'data' => "File is missing / inproper in request"], 200);
		    }
		} else{
			return response()->json(['status' => 404, 'msg' => 'Unavailable', 'data' => "Requested id not found"], 200);
		}	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $ids = $request->input('id');
        $deleted_ids = array();
        $undeleted_ids = array();

        foreach ($ids as $key => $value) {
        	$item = Stylist_Slide_images::where('Images_ID', $value)->where('Hair_Stylist_ID', $id) -> first();
		    if(isset($item)){
		    	\File::delete($item->Image_link);
		    	$item->delete();	
		    	array_push($deleted_ids, $value);
		    }else{
		    	array_push($undeleted_ids, $value);
		    }
        }
        $data = array('deleted_ids' => $deleted_ids, 'undeleted_ids' => $undeleted_ids);
		return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $data], 200);
    }

    /**
     * Get the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
    	$data = Stylist_Slide_images::where('Hair_Stylist_ID', $id) -> get();
    	return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $data], 200);
    }
}
