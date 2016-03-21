<?php 
//Function to cancel the subscription
	$profile_id = 'I-NBP0UPXALVEE' ;
	$action = 'Cancel';
	$api_username  = 'accounting_api1.camassistant.com';
	$api_password = 'M2BTUK6X9Y3USB9E';
	$api_signature = 'AjE.ZewL5mG6AiztkysoRpX08PrkAPefU6ogzPSYce9zfd9.VuO8QUxN';
	$api_version = '67.0';
	$modify = '2';
	$amount = '0.02';
    $api_request = 'USER=' . $api_username
                .  '&PWD=' . $api_password
                .  '&SIGNATURE=' . $api_signature
                .  '&VERSION=' . $api_version
                .  '&METHOD=ManageRecurringPaymentsProfileStatus'
                .  '&PROFILEID=' . urlencode( $profile_id )
                .  '&ACTION=' . urlencode( $action )
                .  '&NOTE=' . urlencode( 'Profile modified at store' )
				.  '&MODIFY=' . $modify
				.  '&A3=' . $amount
				;
     $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'https://api-3t.paypal.com/nvp' ); // For live transactions, change to 'https://api-3t.paypal.com/nvp'
    curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
    // Uncomment these to turn off server and peer verification
    // curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
    // curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_POST, 1 );
     // Set the API parameters for this transaction
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $api_request );
     // Request response from PayPal
    $response = curl_exec( $ch );
     // If no response was received from PayPal there is no point parsing the response
    if( ! $response )
        die( 'Calling PayPal to change_subscription_status failed: ' . curl_error( $ch ) . '(' . curl_errno( $ch ) . ')' );
     curl_close( $ch );
     // An associative array is more usable than a parameter string
    parse_str( $response, $parsed_response );
	echo "<pre>"; print_r($parsed_response); exit;
?>