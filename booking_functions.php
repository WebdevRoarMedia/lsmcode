<?php

// Include the Guzzle PHP client for API calls
use GuzzleHttp\Client;

/* API FUNCTIONS */
// register the ajax action for authenticated users
add_action('wp_ajax_get_room_rates', 'get_room_rates');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_get_room_rates', 'get_room_rates');

// register the ajax action for authenticated users
add_action('wp_ajax_get_room_totalcost', 'getRoomAndTaxes');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_get_room_totalcost', 'getRoomAndTaxes');

// register the ajax action for authenticated users
add_action('wp_ajax_get_property_listings', 'get_property_listings');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_get_property_listings', 'get_property_listings');

// register the ajax action for authenticated users
add_action('wp_ajax_get_property_listings_booking', 'get_property_listings_bookingengine');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_get_property_listings_booking', 'get_property_listings_bookingengine');

// register the ajax action for authenticated users
add_action('wp_ajax_check_property_availability', 'check_property_availability');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_check_property_availability', 'check_property_availability');

// register the ajax action for authenticated users
add_action('wp_ajax_get_property_detail', 'get_property_detail');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_get_property_detail', 'get_property_detail');

// register the ajax action for authenticated users
add_action('wp_ajax_get_payment_provider', 'get_payment_provider');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_get_payment_provider', 'get_payment_provider');

// register the ajax action for authenticated users
add_action('wp_ajax_handle_guest', 'handle_guest');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_handle_guest', 'handle_guest');

// register the ajax action for authenticated users
add_action('wp_ajax_create_reservation', 'create_reservation');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_create_reservation', 'create_reservation');

// register the ajax action for authenticated users
add_action('wp_ajax_create_payment_token', 'create_payment_token');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_create_payment_token', 'create_payment_token');

// register the ajax action for authenticated users
add_action('wp_ajax_process_payment', 'process_payment');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_process_payment', 'process_payment');

// register the ajax action for authenticated users
add_action('wp_ajax_post_payment', 'post_payment');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_post_payment', 'post_payment');

// register the ajax action for authenticated users
add_action('wp_ajax_capture_payment', 'capture_payment');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_capture_payment', 'capture_payment');


// register the ajax action for authenticated users
add_action('wp_ajax_finalize_reservation', 'finalize_reservation');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_finalize_reservation', 'finalize_reservation');

// register the ajax action for authenticated users
add_action('wp_ajax_check_token', 'check_token');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_check_token', 'check_token');

// register the ajax action for authenticated users
add_action('wp_ajax_check_ptranz', 'checkPtranzStatus');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_check_ptranz', 'checkPtranzStatus');

// register the ajax action for authenticated users
add_action('wp_ajax_send_notification', 'sendNotificationEmail');

// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_send_notification', 'sendNotificationEmail');

/*********************************************************************************/
/* Auth Status */
/*********************************************************************************/
// Y	Successful Authentication.	Yes
// A	Authentication Attempted.	Yes
// N	Failed Authentication; account not verified; transaction declined.	No
// U	Failed Authentication due to technical issues.	No
// R	Failed Authentication: issuer rejected the attempts.	No
// 
// AuthenticationStatus - this is the field I need to check.
/*********************************************************************************/

	$apiurl = 'https://api.cloudbeds.com/api/v1.2';
	$clientid = 'live1_25238_O14s5SrMQuGLqWTED9UFPbNf';
	$clientsecret = 'zJ6n1ZpSmVUfWAiY2HwNs0jEkvOdB9uh';
	$apikey = 'cbat_S4hL8j4GUgzfJQtDFQ4qzaF6lPUFtFVD';

	// Staging Credentials
	//$ptranzapi = 'https://staging.ptranz.com/api/spi/';
	//$ptranzID = '77700492';
	//$ptranzPassword = 'pz177qhDtGvz0AS5CrB4AJCk2dIRxKxwZj02fyuyD6KYNOy8S14p4M1';

	// Production Credentials
	$ptranzapi = 'https://gateway.ptranz.com/api/spi/';
	$ptranzID = '33103219';
	$ptranzPassword = 'ifbjsplL3vfjC3Kk8LGsTA6wuwAWJSGB22H0mxozbahs1ZhD9JmuW1';

/*********************************************************************************/

function checkPtranzStatus() {
	global $ptranzapi;
	
	$restURL = $ptranzapi . "/Alive";
	$client = new GuzzleHttp\Client(['headers' => ['Accept' => '*/*']]);
    $response = $client->get($restURL);
    $results = json_decode($response->getBody(), true);
	
	print_r($results);
}

function getApiKey() {
	global $apikey;
	return $apikey;
}

function get_property_detail( ) {
	
	global $apiurl;
	$token = getApiKey();
	
	// Request Params
	$propid = $_REQUEST['property_id'];
	$restURL = $apiurl . '/getRoomTypes/?roomTypeIDs='.$propid.'&detailedRates=true';
	$client = new GuzzleHttp\Client(['headers' => ['Accept' => 'application/json','Authorization' => "Bearer " . $token]]);
    $response = $client->get($restURL);
    $results = json_decode($response->getBody(), true);

    // in the end, returns success json data
    wp_send_json_success([$results]);
}

function getRoomAndTaxes() {
	global $apiurl;
	$token = getApiKey();
	
	// Request Params
	$roomid = $_REQUEST['property_id'];
	$arrival = $_REQUEST['start_date'];
	$departure = $_REQUEST['end_date'];
	$roomtotal = $_REQUEST['total_cost'];
	$roomscount = $_REQUEST['rooms_count'];

		$restURL = $apiurl . '/getRoomsFeesAndTaxes?roomTypeID='.$roomid.'&startDate='.$arrival.'&endDate='.$departure.'&roomsTotal='.$roomtotal.'&roomsCount='.$roomscount;
	
	$client = new GuzzleHttp\Client(['headers' => ['Accept' => 'application/json','Authorization' => "Bearer " . $token]]);
    $response = $client->get($restURL);
    $results = json_decode($response->getBody(), true);

    // in the end, returns success json data
    wp_send_json_success([$results]);
	
}

function get_room_rates() {
	
	global $apiurl;
	$token = getApiKey();
	
	// Request Params
	$roomid = $_REQUEST['property_id'];
	$arrival = $_REQUEST['start_date'];
	$departure = $_REQUEST['end_date'];

		$restURL = $apiurl . '/getRate?roomTypeID='.$roomid.'&startDate='.$arrival.'&endDate='.$departure;
		// May need to add adults and children
	
	$client = new GuzzleHttp\Client(['headers' => ['Accept' => 'application/json','Authorization' => "Bearer " . $token]]);
    $response = $client->get($restURL);
    $results = json_decode($response->getBody(), true);

    // in the end, returns success json data
    wp_send_json_success([$results]);
}

function check_property_availability( ) {
	global $apiurl;
	
	$token = checkBearerToken();
	
	// Request Params
	$propid = $_REQUEST['property_id'];
	$startDate = $_REQUEST['start_date'];
	$endDate = $_REQUEST['end_date'];

	$restURL = $apiurl . '/availability-pricing/api/calendar/listings/'.$propid.'?startDate='.$startDate.'&endDate='.$endDate.'&includeAllotment=true';	
	$client = new GuzzleHttp\Client(['headers' => ['Accept' => 'application/json','Authorization' => "Bearer " . $token]]);
    $response = $client->get($restURL);
	$results = json_decode($response->getBody(), true);
	
		$results['url'] = $restURL;
	
    // in the end, returns success json data
    wp_send_json_success([$results]);
}

// Create a guest record or update an existing one
function handle_guest() {
	
	global $apiurl;
	
	// Grab the passed REQUEST data
	$arrival = $_REQUEST['arrival'];
	$departure = $_REQUEST['departure'];
	$firstname = $_REQUEST['first_name'];
	$lastname = $_REQUEST['last_name'];
	$zip = $_REQUEST['zip'];
	$email = $_REQUEST['email'];
	$phone = $_REQUEST['phone'];
	$nationality = $_REQUEST['country'];
	$propertyID = $_REQUEST['property_id'];
	
		$roomtype = array();
		$roomtype['roomTypeID'] = $_REQUEST['roomTypeID'];
		$roomtype['quantity'] = 1;
	
		$adults = array();
		$adults['roomTypeID'] = $_REQUEST['roomTypeID'];
		$adults['quantity'] = $_REQUEST['number_adults'];

		$children = array();
		$children['roomTypeID'] = $_REQUEST['roomTypeID'];
		$children['quantity'] = 0;
	// Create the guest record (if no email found, new one is created)
	$token = getApiKey();
  	$restURL = $apiurl . '/postReservation';
  	$client = new GuzzleHttp\Client(['headers' => ['Content-type' => 'application/x-www-form-urlencoded','Accept' => 'application/json','Authorization' => "Bearer " . $token]]);

	$response = $client->post($restURL, [
		'form_params' => [
				'startDate' => $arrival,
				'endDate' => $departure,
                'guestFirstName' => $firstname,
                'guestLastName' => $lastname,
				'guestEmail' => $email, 
			    'guestPhone' => $phone, 
			    'guestCountry' => $nationality,
				'guestZip' => $zip,
				'guestPhone' => $phone,
				'reservationID' => $reservationID,
				'propertyID' => $propertyID,
				'roomTypeID' => $roomtype,
				'adults' => $adults,
				'paymentMethod' => 'credit',
            ]
	]);
	
	$results = json_decode($response->getBody(), true);
	$guest['id'] = $results['_id'];
	$guest['status'] = "good";
	
	return wp_send_json_success([$guest]);
}

// Returns reservation id
function create_reservation() {
	
	global $apiurl;
  
	$token = getApiKey();
	$propid = $_REQUEST['property_id'];
	$roomid = $_REQUEST['room_id'];

	$arrival = $_REQUEST['start_date'];
	$departure = $_REQUEST['end_date'];
	$total = $_REQUEST['total'];
	
	// Guest info is passed as an array
	$guestFirstName =  $_REQUEST['firstname'];
	$guestLastName =  $_REQUEST['lastname'];
	$guestZip =  $_REQUEST['zip'];
	$guestEmail =  $_REQUEST['email'];
	$guestPhone = $_REQUEST['cellphone'];
	$nationality = $_REQUEST['country'];
	
		$roomtype = array();
		$roomtype['roomTypeID'] = $roomid;
		$roomtype['quantity'] = 1;
	
		$adults = array();
		$adults['roomTypeID'] = $roomid;
		$adults['quantity'] = $_REQUEST['number_adults'];

		$children = array();
		$children['roomTypeID'] = $propid;
		$children['quantity'] = 0;
	
	$promocode = $_REQUEST['promo_code'];
		if ($promocode == 0) { $promocode = ""; }

  	$restURL = $apiurl . '/postReservation';
  	$client = new GuzzleHttp\Client(['headers' => ['Content-type' => 'application/x-www-form-urlencoded','Accept' => 'application/json','Authorization' => "Bearer " . $token]]);
	
	try {
		$response = $client->post($restURL, [
			'form_params' => [
					'startDate' => $arrival,
					'endDate' => $departure,
					'guestFirstName' => $guestFirstName,
					'guestLastName' => $guestLastName,
					'guestEmail' => $guestEmail, 
					'guestPhone' => $guestPhone, 
					'guestCountry' => $nationality,
					'guestZip' => $guestZip,
					'guestPhone' => $guestPhone,
					'propertyID' => $propid,
					'paymentMethod' => 'ebanking',
					'promoCode' => $promocode,
					'rooms' => [['roomTypeID' => $roomid, 'quantity' => 1]],
					'adults' => [['roomTypeID' => $roomid, 'quantity' => $_REQUEST['number_adults'] ]],
					'children' => [['roomTypeID' => $roomid, 'quantity' => 0]],
				]
		]);
			
    	$results = json_decode($response->getBody(), true);
	} catch (\GuzzleHttp\Exception\BadResponseException $e) {
    	$results = $e->getResponse()->getBody()->getContents();
	}
	
	wp_send_json_error([$results]);

}

/**********************************************************************************/
/* Payment Functions */
/**********************************************************************************/
function create_payment_token() {
	
	global $ptranzapi; 
	global $ptranzID;
	global $ptranzPassword;
	
	$token = getApiKey();
	$total = $_REQUEST['totalamt'];
	$cardname = $_REQUEST['first_name'] . " " . $_REQUEST['last_name'];
	$cardnumber = $_REQUEST['card_number'];
	$expiration = $_REQUEST['exp_date'];
	$line1 = $_REQUEST['address_line_1'];
	$city = $_REQUEST['city'];
	$zip = $_REQUEST['zip'];
	$expdate = explode("/", $expiration);
	$cvc = $_REQUEST['ccv'];
	
	$currencycode = "558";
	//$currencycode = "840";
	$datetime = date('Ymdhis');
	$orderid = "LSM_BOOKING-" . $_REQUEST['first_name'] . "_" . $_REQUEST['last_name'] . "_" . $datetime;
		
	$restURL = $ptranzapi . "auth";
	
	$client = new GuzzleHttp\Client(['headers' => ['Content-type' => 'application/json; charset=utf-8','Accept' => '*/*','PowerTranz-PowerTranzId' => $ptranzID, 'PowerTranz-PowerTranzPassword' => $ptranzPassword]]);
	$formdata = [
		"json" => [
				"TotalAmount" => $total,
				"CurrencyCode" => $currencycode,
				"ThreeDSecure" => true,
				"Source" => [
					"CardPan" => $cardnumber,
					"CardExpiration" => $expdate[1].$expdate[0],
					"CardCvv" => $cvc,
					"CardholderName" => $cardname
				],
				"OrderIdentifier" => $orderid,
				"AddressMatch" => false,
				"ExtendedData" => [
					"ThreeDSecure" => [
						"ChallengeWindowSize" => 4,
						"ChallengeIndicator" => "01",
						],
						"MerchantResponseUrl" => "https://lsmresort.com/payment-completed/",
				],
			]
	 ];
	
	$response = $client->post( $restURL, $formdata );
	
	$tokenresult = array();
    $results = json_decode($response->getBody(), true);
	
		$tokenresult['response'] = $results;
		$tokenresult['approved'] = $results['Approved'];
		$tokenresult['RedirectData'] = $results['RedirectData'];
		$tokenresult['apicall'] = json_encode($formdata);
		$tokenresult['token'] = $results['SpiToken'];
	
	wp_send_json_success([$tokenresult]);
}

function process_payment() {
	global $ptranzapi;
	global $ptranzID;
	global $ptranzPassword;
		
	$restURL = $ptranzapi . 'Payment';
	$spiToken = $_REQUEST['spitoken'];
			
	$client = new GuzzleHttp\Client(['headers' => ['Content-type' => 'application/json; charset=utf-8','Accept' => 'application/json','PowerTranz-PowerTranzId' => $ptranzID, 'PowerTranz-PowerTranzPassword' => $ptranzPassword]]);
	
	$formdata = [
		"body" => '"' . $spiToken . '"'
	];
	
	$response = $client->post( $restURL, $formdata );
    $results = json_decode($response->getBody(), true);
	wp_send_json_success([$results]);
}

function capture_payment() {

	global $ptranzID;
	global $ptranzPassword;
		
	$gateway = "https://gateway.ptranz.com/Api/Capture";
	$captureamt = $_REQUEST['amount'];
    $transactionIdentifier = $_REQUEST['transid'];
	$client = new GuzzleHttp\Client(['headers' => ['Content-type' => 'application/json; charset=utf-8','Accept' => 'application/json','PowerTranz-PowerTranzId' => $ptranzID, 'PowerTranz-PowerTranzPassword' => $ptranzPassword]]);

		$formdata = [
			"json" => [
					"TotalAmount" => $captureamt,
					"TransactionIdentifier" => $transactionIdentifier,
				]
		 ];
	
		$response = $client->post( $gateway, $formdata );
		$results = json_decode($response->getBody(), true);	

		wp_send_json_success([$results]);
}

function sendNotificationEmail() {
	
		$guestName =  $_REQUEST['guest_name'];
		$reservationID = $_REQUEST['reservation_id'];
		$amount = $_REQUEST['amount'];
	
	$to = "rpotratz@roarmedia.com, gderchi@roarmedia.com, stay@lsmresort.com";
	$message = "";
	$subject = "LSM Completed Payment Notification";
	$from = "noreply@lsmresort.com";
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$headers[] = 'Cc: experience@lsmresort.com';

		$message .= "A payment was captured for the following reservation: <br>";
		$message .= "Reservation ID: " . $reservationID . "<br>";
		$message .= "Guest Name: " . $guestName . "<br>";
		$message .= "Amount: " . $amount . "<br>";
		
	wp_mail( $to, $subject, $message, $headers );

}

function post_payment() {

	global $apiurl;
	$token = getApiKey();
		
	$restURL = $apiurl . '/postPayment';
	$amount = $_REQUEST['amount'];
	$propertyId = $_REQUEST['property_id'];
	$reservationID = $_REQUEST['reservation_id'];
	$description = "Payment for Booking through PTranz";
	
  		$client = new GuzzleHttp\Client(['headers' => ['Accept' => 'application/json','Authorization' => "Bearer " . $token]]);

		$formdata = [
			"form_params" => [
					"propertyID" => $propertyId,
					"reservationID" => $reservationID,
					"amount" => $amount,
					"type" => "credit",
					"cardType" => "visa",
					"description" => $description,
				]
		 ];	
	
		$response = $client->post( $restURL, $formdata );
		$results = json_decode($response->getBody(), true);	
		wp_send_json_success([$results]);
}

// handle the ajax request
function get_property_listings() {
	
	global $apiurl;
	
	$token = getApiKey();
	$arrival = $_REQUEST['arrival_date'];   
	$departure = $_REQUEST['departure_date'];  
	$numpeople = $_REQUEST['number_people'];
	$promocode = $_REQUEST['promo_code'];
	$numrooms = $_REQUEST['num_rooms'];

	// Short Term
	 if ($arrival) {
		$params = 'startDate='.$arrival.'&endDate='.$departure.'&adults='.$numpeople.'&children=0&rooms='.$numrooms;
     	$restURL = $apiurl . '/getAvailableRoomTypes?';	
		$restPROMO = $apiurl . '/getRatePlans?';
		 		 
  		$client = new GuzzleHttp\Client(['headers' => ['Accept' => 'application/json','Authorization' => "Bearer " . $token]]);
     	$response = $client->get($restURL . $params);
     	$properties = json_decode($response->getBody(), true);
		$results = $properties; 
		 
		if ($promocode) {
				
			$roomids = array();
			foreach ($properties['data'][0]['propertyRooms'] as $prop) { 
					array_push($roomids, $prop['roomTypeID']);	
			}
			
			$promoparams = $params . '&promoCode=' . $promocode  . '&roomTypeID=' . implode(",", $roomids);
			
			// If a promocode is passed, then we need to grab the rates for each property
			$client = new GuzzleHttp\Client(['headers' => ['Accept' => 'application/json','Authorization' => "Bearer " . $token]]);
			$response = $client->get($restPROMO . $promoparams);
			$rateplans = json_decode($response->getBody(), true);
			$promorates = array(); $updatedRooms = array();
				foreach ($rateplans['data'] as $promoplan) {
					$promorates[ $promoplan['roomTypeID'] ] = $promoplan['roomRate'];
					$promorates['rateID'] = $promoplan['rateID'];
				}
			
				foreach ($properties['data'][0]['propertyRooms'] as $prop) { 
					$prop['promoRoomRate'] = $promorates[ $prop['roomTypeID'] ];
					$prop['rateID'] = $promorates['rateID'];
					array_push($updatedRooms, $prop);
				}
				$properties['data'][0]['propertyRooms'] = $updatedRooms;
			
				$results = $properties; 
		}
		 
    	// in the end, returns success json data 
    	wp_send_json_success([$results]);
    			 
	 } else {
		$results['error'] = "No available dates passed.";
    	// or, on error, return error json data
    	wp_send_json_error([$results]);
    }
}

/* Single Property Shortcodes */
function singlePropertyDetails() {
	
	$bottomsection = "";
	$maplink = get_field('location_url');
	$amenities = get_field('onsite_amenities');
	$services = get_field('available_services');
	
	$generalconditions = get_field('general_conditions');

	$bottomsection .= '<div class="propertydetails">';
			$bottomsection .= '<div class="features">';
				$bottomsection .= '<div class="iconbar"><div class="icon"><img src="/wp-content/uploads/2023/09/room-facilities.svg" border="0" /></div> Property Features </div>';
				$bottomsection .= '<div class="details"></div>';	
			$bottomsection .= '</div>';
			$bottomsection .= '<div class="amenities">';
				$bottomsection .= '<div class="iconbar"><div class="icon"><img src="/wp-content/uploads/2023/09/onsite-amenities.svg" border="0" /></div> On-Site Amenities </div>';
				$bottomsection .= '<div class="details">' . $amenities . '</div>';
				$bottomsection .= '<a class="learnmore button" href="/amenities">LEARN MORE</a>';
			$bottomsection .= '</div>';
			$bottomsection .= '<div class="services">';
				$bottomsection .= '<div class="iconbar"><div class="icon"><img src="/wp-content/uploads/2023/09/available-services.svg" border="0" /></div> Available Services </div>';
				$bottomsection .= '<div class="details">' . $services . '</div>';	
				$bottomsection .= '<a class="learnmore button" href="/services">LEARN MORE</a>';
			$bottomsection .= '</div>';
			$bottomsection .= '<div class="generalConditions">';
				$bottomsection .= '<div class="iconbar"><div class="icon"></div> General Conditions </div>';
				$bottomsection .= '<div class="details">' . $generalconditions . '</div>';	
				$bottomsection .= '<h5 class="generalConditions-terms">*All pictures shown are for Illustration purpose only*</h5>';	
			$bottomsection .= '</div>';
			$bottomsection .= '<div class="location">';
				$bottomsection .= '<div class="iconbar"><div class="icon"><i class="fa-thin fa-earth-americas"></i></div> Location </div>';
				$bottomsection .= '<iframe src="'.$maplink.'" " width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
			$bottomsection .= '</div>';
	$bottomsection .= '</div>';
	return $bottomsection;
}

add_shortcode('property_amenities','singlePropertyDetails');
