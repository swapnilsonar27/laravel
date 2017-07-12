<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Input;

class NotificationController extends Controller
{
	/**
     * Save Device id.
     *
     * @return resopnse
     */
    public function saveDeviceId() {
    	$id = Input::get('id');
    	$deviceId = Input::get('deviceId');
        $deviceType = Input::get('deviceType');

        User::where('Hair_Stylist_ID', $id)->update(["device_id" => $deviceId],["device_type" => $deviceType ]);
        return response()->json(['status' => 200, 'msg' => 'Success'], 200);
    }

    /**
     * Send Android Notification.
     *
     * @return null
     */
    public function sendAndroidNotification($device_id, $message)
    {
        
       // Replace with real BROWSER API key from Google APIs
        $apiKey = "AIzaSyD0WLyJEeiZpAof0WwxbLaQJB0Dzp7ToHg";

        // Replace with real client registration IDs 
        $registrationIDs = array("" . $device_id);

        // Message to be sent
        //$message = "This is testing messsage";

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
                        'registration_ids'  => $registrationIDs,
                        'data'              => array( "message" => $message ),
                        );

        $headers = array( 
                            'Authorization: key=' . $apiKey,
                            'Content-Type: application/json'
                        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt( $ch, CURLOPT_URL, $url );

        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        //echo $result;
    }

    /**
     * Send Apple Notification.
     *
     * @return null
     */
    public function sendAppleNotification($device_id, $message){
        // Put your device token; here (without spaces):
        $deviceToken = $device_id;
        // Put your private key's passphrase here:
        $passphrase = '';
        // Put your alert message here:
        //$message = 'A push notification has been sent!';
        ////////////////////////////////////////////////////////////////////////////////
        $ctx = stream_context_create();
        
        stream_context_set_option($ctx, 'ssl', 'local_cert', dirname(__FILE__) . '/' . 'push_notif_cert.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        // Open a connection to the APNS server
        $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', 
            $err, $errstr, 60, 
            STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        echo 'Connected to APNS' . PHP_EOL;
        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'body' => $message,
                'action-loc-key' => 'Bango App',
            ),
            'badge' => 2,
            'sound' => 'oven.caf',
            );
        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));
        /*if (!$result)
            echo 'Message not delivered' . PHP_EOL;
        else
            echo 'Message successfully delivered' . PHP_EOL;*/
        // Close the connection to the server
        fclose($fp);
    }
}
