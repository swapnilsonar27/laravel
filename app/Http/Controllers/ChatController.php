<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Messages;
use App\Messaage_recipient;

class ChatController extends Controller
{
    /**
     * Get Upcoming Booking data of user.
     *
     * @param  id
     * @return Response
     */
    public function getMessages (Request $request) {
        $sender = $request->input('sender');
        $type = $request->input('type');
        $recipient = $request->input('recipient');
        $booking_id = $request->input('booking_id');
        $data = Messages::where('booking_id', $booking_id)->get();
        return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $data], 200);

    }

    /**
     * Get Upcoming Booking data of user.
     *
     * @param  id
     * @return Response
     */
    public function store (Request $request) {
    	$message =  $request->input('message');
        $sender = $request->input('sender');
        $type = $request->input('type');
        $recipient = $request->input('recipient');
        $booking_id = $request->input('booking_id');

        $msg_id = Messages::create(['message' => $message, 
            'sender_id' => $sender, 'type' => $type, 'recipient_id' => $recipient,
            'booking_id' => $booking]);
        
    	return response()->json(['status' => 200, 'msg' => 'Success'], 200);

    }
}
