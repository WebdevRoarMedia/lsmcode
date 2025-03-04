<?php

/* Main Functions File */
add_shortcode('footer_year', 'showFooterYear');
function showFooterYear() {
    return date("Y");
}

add_shortcode('cc_form', 'displayCreditCardFormJquery');
function displayCreditCardFormJquery() {
	
	$form = "";
	$form .= '
          <h4>Payment details</h4>
                    <ul>
                        <li>
                            <label for="card_number">Card number</label>
                            <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456">
                            <small class="help">We accept Visa, MasterCard and American Express.</small>
                        </li>
                        <li class="vertical">
                            <ul>
                                <li>
                                    <label for="expiry_date">Expiry date</label>
                                    <input type="text" name="cart-expmonth" id="cart-expmonth" maxlength="2" placeholder="mm"> <input type="text" name="cart-expyear" id="cart-expyear" maxlength="2" placeholder="yy"> 
                                </li>
                                <li>
                                    <label for="cvv">CVV</label>
                                    <input type="text" name="cvv" id="cvv" maxlength="4" placeholder="123">
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label for="name_on_card">Name on card</label>
                            <input type="text" name="name_on_card" id="name_on_card" placeholder="Cardholder name">
                        </li>
                    </ul>
					<button id="submitpayment" class="button"> Submit Payment </button>';
	return $form;
}

function displayCreditCardForm() {
	
	$form = "";
		$form .= '
		 <div class="ccform payment">
        	<h1>Payment Information</h1>
    	</div>
        <div class="container preload">
        <div class="creditcard">
            <div class="front">
				<form id="creditcardform">
                <div id="ccsingle"></div>
				<div class="form-container">
					<div class="field-container">
						<label for="name">Name</label>
						<input id="cardname" maxlength="20" type="text">
					</div>
					<div class="field-container">
						<label for="cardnumber">Card Number</label>
						<input id="cardnumber" type="text" pattern="[0-9]*" inputmode="numeric">
					</div>
					<div class="field-container">
						<label for="expirationdate">Expiration (mm/yy)</label>
						<input id="expirationdate" type="text" pattern="[0-9]*" inputmode="numeric">
					</div>
					<div class="field-container">
						<label for="securitycode">Security Code</label>
						<input id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric">
					</div>
					<div class="field-container">
						<button name="processpayment" id="handle_payment">Submit Payment</button>
					</div>
				</div>
				</form>
        </div>
    </div>';
	
	return $form;
}

/**********************************************************/
/* Create a guest form to fill out and submit on step two */
/**********************************************************/
add_shortcode('guest_form','displayGuestForm');

function displayGuestForm() {
	
	$form = "";
		$form .= '
			<form id="guestform">
				<input type="hidden" value="" id="pid" name="pid" />
				<div> <label>Email address*</label> <input type="text" value="" id="email_address" required /></div>
				<div> <label>Email verification*</label> <input type="text" value="" id="email_verify" required /></div>
				<div> <label>Name*</label> <input type="text" value="" id="name" required /></div>
				<div> <label>Family name*</label> <input type="text" value="" id="family_name" required /></div>
				<div> <label>Cellphone number*</label> <input type="text" value="" id="cellphone" pattern="[0-9]{5}[-][0-9]{7}[-][0-9]{1}" required /></div>
				<div> <label>Address</label> <input type="text" value="" id="address" /></div>
				<div> <label>Postal Code*</label> <input type="text" value="" id="postal_code"  pattern="(?=.*[A-Za-z]).{6,}|[0-9]{5}" required /></div>
				<div> <label>City</label> <input type="text" value="" id="City"  /></div>
				<div> <label>Country</label> 
					<select id="country">
	<option value=""></option>
	<option value="AF">Afghanistan</option>
	<option value="AX">Aland Islands</option>
	<option value="AL">Albania</option>
	<option value="DZ">Algeria</option>
	<option value="AS">American Samoa</option>
	<option value="AD">Andorra</option>
	<option value="AO">Angola</option>
	<option value="AI">Anguilla</option>
	<option value="AQ">Antarctica</option>
	<option value="AG">Antigua and Barbuda</option>
	<option value="AR">Argentina</option>
	<option value="AM">Armenia</option>
	<option value="AW">Aruba</option>
	<option value="AC">Ascension Island</option>
	<option value="AU">Australia</option>
	<option value="AT">Austria</option>
	<option value="AZ">Azerbaijan</option>
	<option value="BS">Bahamas</option>
	<option value="BH">Bahrain</option>
	<option value="BD">Bangladesh</option>
	<option value="BB">Barbados</option>
	<option value="BY">Belarus</option>
	<option value="BE">Belgium</option>
	<option value="BZ">Belize</option>
	<option value="BJ">Benin</option>
	<option value="BM">Bermuda</option>
	<option value="BT">Bhutan</option>
	<option value="BO">Bolivia</option>
	<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
	<option value="BA">Bosna and Hercegovina</option>
	<option value="BW">Botswana</option>
	<option value="BV">Bouvet Island</option>
	<option value="BR">Brasil</option>
	<option value="IO">British Indian Ocean Territory</option>
	<option value="BN">Brunei Darussalam</option>
	<option value="BG">Bulgaria</option>
	<option value="BF">Burkina Faso</option>
	<option value="BI">Burundi</option>
	<option value="KH">Cambodia</option>
	<option value="CM">Cameroon</option>
	<option value="CA">Canada</option>
	<option value="IC">Canary Islands</option>
	<option value="CV">Cape Verde</option>
	<option value="CT">Catalonia</option>
	<option value="KY">Cayman Islands</option>
	<option value="CF">Central African Republic</option>
	<option value="EA">Ceuta y Melilla</option>
	<option value="TD">Chad</option>
	<option value="CL">Chile</option>
	<option value="CN">China</option>
	<option value="CX">Christmas Island</option>
	<option value="CP">Clipperton Island</option>
	<option value="CC">Cocos Keeling islands</option>
	<option value="CO">Colombia</option>
	<option value="KM">Comoros islands</option>
	<option value="CG">Congo</option>
	<option value="CK">Cook islands</option>
	<option value="CR">Costa Rica</option>
	<option value="HR">Croatia</option>
	<option value="CU">Cuba</option>
	<option value="CW">Curaçao</option>
	<option value="CY">Cyprus</option>
	<option value="CZ">Czech Republic</option>
	<option value="DK">Denmark</option>
	<option value="DG">Diego Garcia</option>
	<option value="DJ">Djibouti</option>
	<option value="DM">Dominica</option>
	<option value="DO">Dominican Republic</option>
	<option value="TL">East Timor</option>
	<option value="EC">Ecuador</option>
	<option value="EG">Egypt</option>
	<option value="SV">El Salvador</option>
	<option value="GQ">Equatorial Guinea</option>
	<option value="ER">Eritrea</option>
	<option value="EE">Estonia</option>
	<option value="ET">Ethiopia</option>
	<option value="EU">Euskadi</option>
	<option value="FK">Falkland Islands</option>
	<option value="FO">Faroe islands</option>
	<option value="FJ">Fiji</option>
	<option value="FI">Finland</option>
	<option value="FR">France</option>
	<option value="GF">French Guiana</option>
	<option value="PF">French Polynesia</option>
	<option value="TF">French Southern Territories</option>
	<option value="GA">Gabon</option>
	<option value="GM">Gambia</option>
	<option value="GE">Georgia</option>
	<option value="DE">Germany</option>
	<option value="GH">Ghana</option>
	<option value="GI">Gibraltar</option>
	<option value="GR">Greece</option>
	<option value="GL">Greenland</option>
	<option value="GD">Grenada</option>
	<option value="GP">Guadeloupe</option>
	<option value="GU">Guam</option>
	<option value="GT">Guatemala</option>
	<option value="GG">Guernsey</option>
	<option value="GN">Guinea</option>
	<option value="GW">Guinea Bissau</option>
	<option value="GY">Guyana</option>
	<option value="HT">Haiti</option>
	<option value="HM">Heard island and Mcdonald islands</option>
	<option value="HN">Honduras</option>
	<option value="HK">Hong Kong</option>
	<option value="HU">Hungary</option>
	<option value="IS">Iceland</option>
	<option value="IN">India</option>
	<option value="ID">Indonesia</option>
	<option value="IR">Iran</option>
	<option value="IQ">Iraq</option>
	<option value="IE">Ireland</option>
	<option value="IM">Isle of Man</option>
	<option value="IL">Israel</option>
	<option value="IT">Italy</option>
	<option value="CI">Ivory Coast</option>
	<option value="JM">Jamaica</option>
	<option value="JP">Japan</option>
	<option value="JE">Jersey</option>
	<option value="JO">Jordan</option>
	<option value="KZ">Kazakhstan</option>
	<option value="KE">Kenya</option>
	<option value="KI">Kiribati</option>
	<option value="XK">Kosovo</option>
	<option value="KW">Kuwait</option>
	<option value="KG">Kyrgyzstan</option>
	<option value="LA">Laos</option>
	<option value="LV">Latvia</option>
	<option value="LB">Lebanon</option>
	<option value="LS">Lesotho</option>
	<option value="LR">Liberia</option>
	<option value="LY">Libya</option>
	<option value="LI">Liechtenstein</option>
	<option value="LT">Lithuania</option>
	<option value="LU">Luxembourg</option>
	<option value="MO">Macau</option>
	<option value="MG">Madagascar</option>
	<option value="MW">Malawi</option>
	<option value="MY">Malaysia</option>
	<option value="MV">Maldives</option>
	<option value="ML">Mali</option>
	<option value="MT">Malta</option>
	<option value="MH">Marshall islands</option>
	<option value="MQ">Martinique</option>
	<option value="MR">Mauritania</option>
	<option value="MU">Mauritius</option>
	<option value="YT">Mayotte</option>
	<option value="MX">Mexico</option>
	<option value="FM">Micronesia</option>
	<option value="MD">Moldova</option>
	<option value="MC">Monaco</option>
	<option value="MN">Mongolia</option>
	<option value="ME">Montenegro</option>
	<option value="MS">Montserrat</option>
	<option value="MA">Morocco</option>
	<option value="MZ">Mozambique</option>
	<option value="MM">Myanmar</option>
	<option value="NA">Namibia</option>
	<option value="NR">Nauru</option>
	<option value="NP">Nepal</option>
	<option value="NL">Netherlands</option>
	<option value="AN">Netherlands Antilles</option>
	<option value="NC">New Caledonia</option>
	<option value="NZ">New Zealand</option>
	<option value="NI">Nicaragua</option>
	<option value="NE">Niger</option>
	<option value="NG">Nigeria</option>
	<option value="NU">Niue</option>
	<option value="NF">Norfolf Island</option>
	<option value="KP">North Korea</option>
	<option value="MP">Northern Mariana islands</option>
	<option value="NO">Norway</option>
	<option value="OM">Oman</option>
	<option value="PK">Pakistan</option>
	<option value="PW">Palau</option>
	<option value="PS">Palestina</option>
	<option value="PA">Panama</option>
	<option value="PG">Papua New Guinea</option>
	<option value="PY">Paraguay</option>
	<option value="PE">Peru</option>
	<option value="PH">Philippines</option>
	<option value="PN">Pitcairn</option>
	<option value="PL">Poland</option>
	<option value="PT">Portugal</option>
	<option value="PR">Puerto Rico</option>
	<option value="QA">Qatar</option>
	<option value="MK">Republic of Macedonia</option>
	<option value="CD">Republic of the Congo</option>
	<option value="RE">Reunion islands</option>
	<option value="RO">Romania</option>
	<option value="RU">Russia</option>
	<option value="RW">Rwanda</option>
	<option value="SH">Saint Helena</option>
	<option value="KN">Saint Kitts and Nevis</option>
	<option value="LC">Saint Lucia</option>
	<option value="PM">Saint Pierre and Miquelon</option>
	<option value="VC">Saint Vincent and the Grenadines</option>
	<option value="WS">Samos</option>
	<option value="SM">San Marino</option>
	<option value="ST">Sao Tome and Principe</option>
	<option value="SA">Saudi Arabia</option>
	<option value="SN">Senegal</option>
	<option value="RS">Serbia</option>
	<option value="CS">Serbia and Montenegro</option>
	<option value="SC">Seychelles</option>
	<option value="SL">Sierra Leone</option>
	<option value="SG">Singapore</option>
	<option value="SX">Sint Maarten</option>
	<option value="SK">Slovakia</option>
	<option value="SI">Slovenia</option>
	<option value="SB">Solomon islands</option>
	<option value="SO">Somalia</option>
	<option value="ZA">South Africa</option>
	<option value="GS">South Georgia and the South Sandwich Islands</option>
	<option value="KR">South Korea</option>
	<option value="SS">South Sudan</option>
	<option value="ES">Spain</option>
	<option value="LK">Sri Lanka</option>
	<option value="SD">Sudan</option>
	<option value="SR">Suriname</option>
	<option value="SZ">Swaziland</option>
	<option value="SE">Sweden</option>
	<option value="CH">Switzerland</option>
	<option value="SY">Syria</option>
	<option value="TW">Taiwan</option>
	<option value="TJ">Tajikistan</option>
	<option value="TZ">Tanzania</option>
	<option value="TH">Thailand</option>
	<option value="TG">Togo</option>
	<option value="TK">Tokelau</option>
	<option value="TO">Tonga</option>
	<option value="TT">Trinidad and Tobago</option>
	<option value="TA">Tristan da Cunha</option>
	<option value="TN">Tunisia</option>
	<option value="TR">Turkey</option>
	<option value="TM">Turkmenistan</option>
	<option value="TC">Turks and Caicos islands</option>
	<option value="TV">Tuvalu</option>
	<option value="UG">Uganda</option>
	<option value="UA">Ukraine</option>
	<option value="AE">United Arab Emirates</option>
	<option value="GB">United Kingdom</option>
	<option value="UM">United States minor outlying islands</option>
	<option value="US">United States of America</option>
	<option value="UY">Uruguay</option>
	<option value="UZ">Uzbekistan</option>
	<option value="VU">Vanuatu</option>
	<option value="VA">Vatican</option>
	<option value="VE">Venezuela</option>
	<option value="VN">Viet Nam</option>
	<option value="VG">Virgin islands, British</option>
	<option value="VI">Virgin islands, US</option>
	<option value="WF">Wallis and Futuna</option>
	<option value="YE">Yemen</option>
	<option value="ZM">Zambia</option>
	<option value="ZW">Zimbabwe</option>
					</select>
				</div>

		<h3> Details of the trip </h3>
		<div><label>Adults</label><input type="number" value="" min="1" id="numberadults" max="12" /></div>
			<div><label>Children</label><input type="number" value="" id="children" min="0" max="10" /></div>
			<div><label>Baby</label><input type="number" value="" id="infants" min="0" /></div>
						<div><label>Arrival time</label><input type="text" value="" id="flight_arrival" /></div>
						<div><label>Flight number </label><input type="text" value="" id="flight_number" /></div>
			<h3> Additional Information </h3>
			<div><label>Remarks</label> <br> <textarea id="remarks"></textarea></div>
			<div><label>Reason for your trip </label>
				<select id="tripreason">
					<option value="0"></option>
					<option value="1">Family trip</option>
					<option value="2">Travel as Couple</option>
					<option value="3">Trip with friends</option>
					<option value="4">Single travel</option>
					<option value="5">Business trip</option>
					<option value="6">Study trip</option>
				</select></div>
			<div><input type="checkbox" value="1" id="acceptterms" required /> 
				<button type="button" class="btn btn-link p-0 text-start modallink"> I have read and I accept general terms and conditions </button>
			</div>
			<input type="submit" name="Reserve" value="Continue" id="ContinueBooking" class="btn btn-success">
		</form>';
	
	return $form;
}

function displaySearchBar2( ) {
	
	$today = date('m/d/Y');
	$tomorrow = date("m/d/Y", strtotime('tomorrow'));

	$searchbar = "";
		$searchbar .= '<form action="/la-santa-maria-properties/" method="get">';
		$searchbar .= '<div id="propsearchbar">';
			$searchbar .= '<div>';
				$searchbar .= '<h3>Arrival</h3>';
				$searchbar .= '<input type="text" value="'.$today.'" name="arrivalDate" class="rounded" id="homearrival" />';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
				$searchbar .= '<h3>Departure</h3>';
				$searchbar .= '<input type="text" value="'.$tomorrow.'" name="departureDate" class="rounded" id="homedeparture" />';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
				$searchbar .= '<h3>People</h3>';
					$searchbar .= '<select name="numberPeople" id="numberpeople" class="form-select rounded">
						<option value="1">1 people</option>
						<option selected="selected" value="2">2 people</option>
						<option value="3">3 people</option>
						<option value="4">4 people</option>
						<option value="5">5 people</option>
						<option value="6">6 people</option>
						<option value="7">7 people</option>
						<option value="8">8 people</option>
						<option value="9">9 people</option>
						<option value="10">10 people</option>
						<option value="11">11 people</option>
						<option value="12">12 people</option>
					</select>';
			$searchbar .= '</div>';
			$searchbar .= '<div class="search-one">';
				$searchbar .= '<input type="submit" class="button" value="Search" />';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
				$searchbar .= '<p><strong>Please note: All transactions will be processed in Nicaraguan Cordobas (NIO), as mandated by the Central Bank of Nicaragua.</strong></p>';
			$searchbar .= '</div>';
		$searchbar .= '</div>';
		$searchbar .= '</form>';

	return $searchbar;
}

add_shortcode('reservation_searchbar','displaySearchBar2');

function displaySearchBarWithButton( ) {
	$searchbar = '<div id="propsearchbar">';
    $searchbar .= '<a href="https://hotels.cloudbeds.com/en/reservation/HPJOwq/?currency=usd&checkin=2024-05-23&checkout=2024-05-25" target="_blank"><button>BOOK NOW</button></a>';
    $searchbar .= '</div>';
    return $searchbar;
}

add_shortcode('reservation_searchbar2','displaySearchBarWithButton');

function displayLargeSearch( ) {
	
	$tomorrow = date('m/d/Y');
	$dayafter = date("m/d/Y", strtotime('+1 days'));

	$searchbar = "";
		$searchbar .= '<div id="propertysearchbox">';
		$searchbar .= '<div class="calendar">';
		$searchbar .= '<h4>SEARCH AVAILABILITY</h4>';
			$searchbar .= '<div class="datefields">';
				$searchbar .= '<input type="text" value="" name="arrivalDate" id="arrivaldate" />';
				$searchbar .= '<input type="text" value="" name="departureDate" id="departuredate" />';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
					$searchbar .= '<select name="numberPeople" id="numberpeople" class="form-select rounded">
						<option value="1">1 person</option>
						<option selected="selected" value="2">2 people</option>
						<option value="3">3 people</option>
						<option value="4">4 people</option>
						<option value="5">5 people</option>
						<option value="6">6 people</option>
						<option value="7">7 people</option>
						<option value="8">8 people</option>
						<option value="9">9 people</option>
						<option value="10">10 people</option>
						<option value="11">11 people</option>
						<option value="12">12 people</option>
					</select>';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
					$searchbar .= '<h4 class="hastooltip">QUANTITY OF UNITS <i class="fa-regular fa-circle-info"><div class="tooltip">Book multiple units of the same type in a single reservation. Currently only available for Ocean View Suites and 1-Bedroom Studio Apartments.</div></i></h4>';
					$searchbar .= '<select name="numberRooms" id="numberrooms" class="form-select rounded">
						<option value="1" selected="selected">1 unit</option>
						<option value="2">2 units</option>
						<option value="3">3 units</option>
					</select>';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
					$searchbar .= '<h4>PROMO CODE</h4>';
					$searchbar .= '<input type="text" value="" name="promocode" id="promocode" />';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
				$searchbar .= '<input type="submit" class="button" value="Search" id="searchlistings" />';
			$searchbar .= '</div>';
					$searchbar .= '<p><strong><small>Please note: All transactions will be processed in Nicaraguan Cordobas (NIO), as mandated by the Central Bank of Nicaragua.</small></strong></p>';
		    $searchbar .= '</div>';
		$searchbar .= '</div>';

	return $searchbar;
}

add_shortcode('reservation_box_large','displayLargeSearch');

function displaySmallSearch( ) {
	
	$tomorrow = date('m/d/Y');
	$dayafter = date("m/d/Y", strtotime('+1 days'));

	$searchbar = "";
	$searchbar .= '<div id="propertysearchbox">';
		$searchbar .= '<div class="calendar">';
		$searchbar .= '<h4>SEARCH AVAILABILITY</h4>';
			$searchbar .= '<div class="datefields">';
				$searchbar .= '<input type="text" value="" name="arrivalDate" id="arrivaldate" />';
				$searchbar .= '<input type="text" value="" name="departureDate" id="departuredate" />';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
					$searchbar .= '<h4 class="hastooltip">QUANTITY OF UNITS <i class="fa-regular fa-circle-info"><div class="tooltip">Book multiple units of the same type in a single reservation. Currently only available for Ocean View Suites and 1-Bedroom Studio Apartments.</div></i></h4>';
					$searchbar .= '<select name="numberRooms" id="numberrooms" class="form-select rounded">
						<option value="1" selected="selected">1 unit</option>
						<option value="2">2 units</option>
						<option value="3">3 units</option>
					</select>';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
					$searchbar .= '<h4>PROMO CODE</h4>';
					$searchbar .= '<input type="text" value="" name="promocode" id="promocode" />';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
				$searchbar .= '<input type="submit" class="button" value="Search" id="searchlistings" />';
			$searchbar .= '</div>';
		$searchbar .= '</div>';
	$searchbar .= '</div>';

	return $searchbar;
}

add_shortcode('reservation_box_boutique','displaySmallSearch');

function displayBookNow( $pid ) {
	
	$tomorrow = date('m/d/Y');
	$dayafter = date("m/d/Y", strtotime('+2 days'));
	$pid = $_GET['pid'];
	$rid = $_GET['rid'];
	$start = ""; $end = "";
	
	if (!empty($_GET['arrivalDate'])) {
		$start = $_GET['arrivalDate'];
	}
	if (!empty($_GET['departureDate'])) {
		$end = $_GET['departureDate'];
	}

	$searchbar = "";
		$searchbar .= '<div id="propertysearchbox">';
		$searchbar .= '<h4>SEARCH AVAILABILITY</h4>';
			$searchbar .= '<form method="GET" action="" id="searchform">';
				$searchbar .= '<input type="hidden" value="'.$pid.'" name="pid">';
				$searchbar .= '<input type="hidden" value="'.$rid.'" name="rid">';

			$searchbar .= '<div class="fourgrid">';
			$searchbar .= '<div>';
				$searchbar .= '<input type="text" value="" name="a" id="bookingarrivaldate" />';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
				$searchbar .= '<input type="text" value="" name="d" id="bookingdeparturedate" />';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
					$searchbar .= '<select name="numberPeople" id="numberpeople" class="form-select rounded">
						<option value="1">1 person</option>
						<option selected="selected" value="2">2 people</option>
						<option value="3">3 people</option>
						<option value="4">4 people</option>
						<option value="5">5 people</option>
						<option value="6">6 people</option>
						<option value="7">7 people</option>
						<option value="8">8 people</option>
						<option value="9">9 people</option>
						<option value="10">10 people</option>
						<option value="11">11 people</option>
						<option value="12">12 people</option>
					</select>';
			$searchbar .= '</div>';
			$searchbar .= '<div>';
				$searchbar .= '<input type="submit" class="button" value="Update Search" />';
			$searchbar .= '</div>';
			$searchbar .= '</div>';
			$searchbar .= '</form>';
	
			$searchbar .= '<form method="GET" action="/booking">';
					$searchbar .= '<input type="hidden" value="'.$pid.'" name="pid">';
					$searchbar .= '<input type="hidden" value="'.$rid.'" name="rid">';
					$searchbar .= '<input type="hidden" value="" name="start_date" id="startdate">';
					$searchbar .= '<input type="hidden" value="" name="end_date" id="enddate">';

			$searchbar .= '<div class="rentaldetails">';
				$searchbar .= '<div>Arrival</div>';
				$searchbar .= '<div class="arrival"></div>';
				$searchbar .= '<div>Departure</div>';
				$searchbar .= '<div class="departure"></div>';
				$searchbar .= '<div>Number of nights: </div><div class="numbernights"></div>';
				$searchbar .= '<div>Quantity of units: </div><div class="numberrooms"></div>';
				$searchbar .= '<div>Guests</div>';
				$searchbar .= '<div class="guests"></div>';
				$searchbar .= '<div class="totalpricelabel">Total price</div>';
				$searchbar .= '<div class="totalprice"></div>';
				$searchbar .= '<div class="taxeslabel">Taxes</div>';
				$searchbar .= '<div class="taxes"></div>';
				$searchbar .= '<div><strong>Balance due</strong></div>';
				$searchbar .= '<div class="paynow"></div>';
				$searchbar .= '<div><strong>Amount to charge</strong></div>';
				$searchbar .= '<div class="chargeamount"></div>';
			$searchbar .= '</div>';
				$searchbar .= '<div><small>Check-in time is at 15:00.</small></div>';
				$searchbar .= '<div><small>A deposit of $300/usd is required for all rooms and is collected at check-in.</small></div>';
			$searchbar .= '<div>';
				$searchbar .= '<button type="submit" class="button dark" id="booknow">Book now </button>';
			$searchbar .= '</div>';
			$searchbar .= '</form>';
			
		$searchbar .= '</div>';

	return $searchbar;
}

add_shortcode('book_now','displayBookNow');


function displayPhotoSlider($atts) {
    $atts = shortcode_atts(array(
        'name' => ''
    ), $atts, 'photo_slider');
    
    $output = "";
    
    // Check if rows exist.
    if (have_rows('slider_sections')) {
        // Loop through rows.
        while (have_rows('slider_sections')) {
            the_row();
            $sectionname = get_sub_field('section_name');
            
            if ($sectionname != $atts['name']) {
                continue;
            }
            
            $images = get_sub_field('image_slides');
            
            if ($images) {
                $output .= '<div class="photoslider">';
                foreach ($images as $image) {
                    $output .= '<div>';
                    $output .= '<img src="' . $image . '" border="0" />';
                    $output .= '</div>';
                }
                $output .= '</div>';
            }
        }
    }
    
    return $output;
}

add_shortcode('photo_slider','displayPhotoSlider');

function displayMoveinProperties($atts) {
	
	$atts = shortcode_atts( array(
		'name' => 'none'
    ), $atts, 'movein_ready' );
	
	$output = "";
	
		if( have_rows('property_blocks') ):
			
			$output .= '<div class="moveinready">';

			while( have_rows('property_blocks') ) : the_row();

					$propertypic = get_sub_field('property_pic');
					$name = get_sub_field('property_name');
					$area = get_sub_field('area');
					$propdetails = get_sub_field('icontext');
					$link = get_sub_field('property_link');
								
					$output .= '<div class="block">';
						$output .= '<div class="propimage"><a href="'.$link.'"><img src="'.$propertypic.'" border="0"></a></div>';
						$output .= '<div class="meta">';
							$output .= '<h3>' . $name . '</h3>';
							$output .= $propdetails;
							$output .= '<p align="center"><a class="avia-button avia-icon_select-no avia-size-small avia-position-center" href="'.$link.'">LEARN MORE</a></p>';
						$output .= '</div>';
					$output .= '</div>';
																		
			endwhile;
	
			$output .= '</div>';
	
		endif;
		
	return $output;
}

add_shortcode('movein_ready','displayMoveinProperties');

function displayPropertyPortfolios($atts) {
	
	$atts = shortcode_atts( array(
		'name' => 'none'
    ), $atts, 'property_block' );
	
	$output = "";
	$propertyfeatures = "";
	
		if( have_rows('prop_portfolios') ):
			while( have_rows('prop_portfolios') ) : the_row();
	
				$portfoliolabel = get_sub_field('portfolio_label');
				$portfoliotype = get_sub_field('portfolio_type');
				$subtabnav = "";
		
				if ($portfoliotype != $atts['name']) { continue; }
	
				$output .= '<div class="propportfolio">';

				if( have_rows('sub_tabs') ):
					while( have_rows('sub_tabs') ) : the_row();

						$subtabname = get_sub_field('sub_tab_name'); 
						$videoblock = get_sub_field('video_block');
						
						$subtabnav .= '<span data-tabname="'.str_replace(" ", "", strtolower($subtabname)).'">' . $subtabname . '</span>';
						$output .= '<div class="subtabcontent" id="'.str_replace(" ", "", strtolower($subtabname)).'">';
				
							$output .= '<div class="media">';
								$output .= '<div class="videocontainer">';
									$output .= $videoblock;
								$output .= '</div>';
							$output .= '</div>';
							$output .= '<div class="metainfo">';
											
								$overviewtab = ""; $overviewcontent = "";
								if( have_rows('property_overviews') ):
									while( have_rows('property_overviews') ) : the_row();
										$overviewname = get_sub_field('overview_name');		
										$overviewtab .= '<span data-tabname="'.str_replace(" ", "", strtolower($overviewname)).'">' .$overviewname . '</span>';
	
											$brochureimage = get_sub_field('brochure_image');
											$overviewdesc = get_sub_field('desc_title');
											$area = get_sub_field('area');
											$bedrooms = get_sub_field('bedrooms');
											$bathrooms = get_sub_field('bathrooms');
											$pdf = get_sub_field('download_link');
									        $link = get_sub_field('details_link');
											$turnkey=get_sub_field('description_key');
											$proplactiontitle=get_sub_field('property_location');
											$pid = url_to_postid($link);
											$specialrate = get_sub_field('specialrate');
											$actualrate = get_sub_field('actualprice');
											$oceanview = get_sub_field('ocean_view');
	
								// $specialrate = get_field('special_rate', $pid);
								// $actualrate = get_field('actual_rate', $pid);
								// 
								$featuresforcards= get_sub_field('desc_title');
								if ($featuresforcards) {
									$propertyfeatures = $featuresforcards;
								}
								$features = get_field('property_features', $pid);
								$images = get_field('property_gallery', $pid);
	
											$propgallery = "";
											$propgallery .= '<div id="salepropgallery">';
													if( $images ):
														$ctr=0; $added = 0;
														foreach( $images as $image ):
																if ($ctr<3) {
																	$propgallery .= '<div class="block'.$ctr.'">';
																		$propgallery .= '<div class="imagecontainer" style="background: url('.$image.')" border="0" /></div>';
																	$propgallery .= '</div>';
																}
															$ctr++;
														endforeach;
													endif;
											$propgallery .= '</div>';
											$overviewinfo = "";
											$overviewinfo = '<div class="outercontent" id="'.str_replace(" ", "", strtolower($overviewname)).'">';
												$overviewinfo .= '<div class="leftcolumn">';
													//$overviewinfo .= '<img src="'.$brochureimage.'" border="0"/>';		
													$overviewinfo .= $propgallery;					
												$overviewinfo .= '</div><div class="rightcolumn">';

												if($portfoliotype === "villas"){
													$overviewinfo .= '<div class="for-sale-box-container">';
													$overviewinfo .= '<div class="for-sale-box-title">';
													
													$overviewinfo .= '<p class="proptitle">' . $proplactiontitle . '</p>';
													  $overviewinfo .= '<p class="proptitle">' . $overviewname . '</p>';
													$overviewinfo .= '<p class="proptitle">' . $turnkey . '</p>';
												   
													$overviewinfo .= '</div>';
													$overviewinfo .= '<div class="for-sale-special-rate-container">';
													$overviewinfo .= '<p class="for-sale-special-rate">' . "Special rate" . '</p>';
													$overviewinfo .= '<div class="specialrate">' . "$" . $specialrate . " <span>USD</span>" . ' / <del>' . "$" . $actualrate . " <span>USD</span>" . '</del></div>';
													$overviewinfo .= '<p class="for-sale-developers">' . "Close by March 31st to get an additional $50,000 USD discount" . '</p>';
													$overviewinfo .= '</div>';
													$overviewinfo .= '</div>';
												}else{
													$overviewinfo .= '<div class="for-sale-box-container-condos">';
													$overviewinfo .= '<div class="for-sale-box-title-condos">';
													
													$overviewinfo .= '<p class="proptitle-condos">' . $proplactiontitle . '</p>';
													$overviewinfo .= '<p class="proptitle-condos">' . $overviewname . '</p>';
													$overviewinfo .= '</div>';
													$overviewinfo .= '</div>';
												   
													
												}								

													  $overviewinfo .= '<div class="fourgrid">';

														if ($oceanview == "true") {
    														$overviewinfo .= '<div class="four-grid-inside-container"><img class="fourgrid-first-img" src="/wp-content/uploads/2023/12/IconWaves.png"/><div><p class="text"> Ocean View</p></div></div>';
														}

															$overviewinfo .= '<div class="four-grid-inside-container"><img src="/wp-content/uploads/2023/12/IconHouse.png"/><div><p class="text"> Area </p><p class="number">' . $area .'</p></div></div>';
															$overviewinfo .= '<div class="four-grid-inside-container"><img src="/wp-content/uploads/2023/12/IconBed.png"/><div><p class="number">'. $bedrooms . '</p><p class="text"> Bedrooms</p></div></div>';
															$overviewinfo .= '<div class="four-grid-inside-container"><img src="/wp-content/uploads/2023/12/IconBathR.png"/><div><p class="number">'. $bathrooms . '</p><p class="text"> Bathrooms</p></div></div>';
															$overviewinfo .= '</div>';
													
													if($portfoliotype === "villas") {
														$overviewinfo .= '<div class=for-sale-features-continer>';
														$overviewinfo .= '<div class=for-sale-features-continer-left>';
															$overviewinfo .= $propertyfeatures;
														$overviewinfo .= '</div>';
														$overviewinfo .= '<div class=for-sale-features-continer-right>';
															$overviewinfo .= '<button><a target="_new" href="'.$pdf.'"><i class="fa-regular fa-arrow-down-to-bracket"></i> Download material</a></button>';
															$overviewinfo .= '<button><a href="'.$link.'"><i class="fa-sharp fa-light fa-eye"></i> See details</a></button>';
														$overviewinfo .= '</div>';
													$overviewinfo .= '</div>';
													} else {
														$overviewinfo .= '<div class=for-sale-features-continer-condos>';
														$overviewinfo .= '<div class=for-sale-features-continer-right-condos>';
														$overviewinfo .= '<button><a href="'.$link.'"><i class="fa-sharp fa-light fa-eye"></i> See details</a></button>';
														$overviewinfo .= '</div>';
													    $overviewinfo .= '</div>';
													}
													
										        $overviewinfo .= '</div>';
											$overviewinfo .= '</div>';
										$overviewcontent .= $overviewinfo;
									endwhile;
								endif;
																				
								$output .= '<div class="overviewtabber">' . $overviewtab . '</div>';
								$output .= '<div class="overviewcontent">' . $overviewcontent . '</div>';
																				
							$output .= '</div>';													
						$output .= '</div>';
																				
					endwhile;
				endif;
		
					$output .= '<div class="subtabnav">';
						$output .= $subtabnav;
					$output .= '</div>';
				$output .= '</div>';
			endwhile;
		endif;

	return $output;
}

add_shortcode('property_block','displayPropertyPortfolios');

function displayPropertyDetails( ) {

	global $post;

	$pid = $post->ID;
	$title = get_the_title($pid);	
	$topsection = ""; $formsection = ""; $bottomsection = "";
	
		$lastlink = wp_get_referer();

	$squarefeet = get_field('square_footage');
	$guests = get_field('number_of_guests');
	$beds = get_field('number_of_beds');
	$bathrooms = get_field('number_of_bathrooms');
	$flyer = get_field('property_flyer');
	$shortdesc = get_field('short_desc');
	$features = get_field('property_features');
	$amenities = get_field('onsite_amenities');
	$services = get_field('available_services');
	$maplink = get_field('map_iframe_link');
	$proptype = get_field('property_type');
	$gallerytext = get_field('gallery_title');
	$propertytype= get_field('property_type');
	$pdf = get_field('property_pdf');

	$propnamearea=get_field('property_name_area');
	$turnkey=get_field('turn_key');
	
	$specialrate = get_field('special_rate_for_sale');
	$actualrate = get_field('actual_rate_for_sale');

    $propgallery = "";
	$propgallery .= '<h1>' . $gallerytext . '</h1>';
	$propgallery .= '<div id="propgallery">';
			$images = get_field('property_gallery');
			$imagegallery = '<div id="additionalimages" class="popup-gallery">';
			if( $images ):
				$ctr=0; $added = 0;
				foreach( $images as $image ):
						if ($ctr>3) {
								$imagegallery .= '<a href="'.$image.'"><img class="galleryimage" src="'.$image.'" border="0" /></a>';
								$added++;
						} else {
							$propgallery .= '<div class="block'.$ctr.'">';
								$propgallery .= '<div class="imagecontainer" style="background: url('.$image.')" border="0" /></div>';
							$propgallery .= '</div>';
						}
					$ctr++;
				endforeach;
			endif;
		$imagegallery .= '</div>';
        $slickgallery = "";
		$slickgallery .=	'<div class="slick-slide-for-sale-ind-mobile-container">';	
        $slickgallery.='<div id="slick-slide-for-sale-ind-mobile">';
            if ($images):
                foreach ($images as $image):
                    $slickgallery.= '<img class="imagecontainer" src="' . $image . '" alt="Image Description">';
                endforeach;
            endif;
        $slickgallery .= '</div>';
    $slickgallery .= '</div>';

	$propgallery .= '</div>';
	$output .= $propgallery . $imagegallery . $slickgallery;
		$output .= '<span id="numberimages" data-numimages="' .  $added . '"></span>';

	$output .= '<div id="propertydetail">';	
		$output .= '<div class="mainwrap">';
	
		// $topsection .= $infobar;
			$topsection .= '<div class="backto-for-sale"><i class="fa-solid fa-angle-left me-1"></i><a href="'.$lastlink.'">BACK TO PROPERTIES</a></div>';
			$topsection .= '<div class="mainblock">';
				$topsection .= '<h2>Property Details</h2>';
				
				// Add new section here
								$features = get_field('property_features', $pid);
								$images = get_field('property_gallery', $pid);
	
											$propgallery = "";
											$propgallery .= '<div id="salepropgallery">';
													if( $images ):
														$ctr=0; $added = 0;
														foreach( $images as $image ):
																if ($ctr<3) {
																	$propgallery .= '<div class="block'.$ctr.'">';
																		$propgallery .= '<div class="imagecontainer" style="background: url('.$image.')" border="0" /></div>';
																	$propgallery .= '</div>';
																}
															$ctr++;
														endforeach;
													endif;
											$propgallery .= '</div>';
											$overviewinfo = "";
											$overviewinfo = '<div class="outercontent" id="'.str_replace(" ", "", strtolower($overviewname)).'">';
												$overviewinfo .= '<div class="leftcolumn">';
												$overviewinfo .= '<div id="slick-slide-for-sale-ind">';
														if ($images):
   															 foreach ($images as $image):
        														$overviewinfo .= '<img class="imagecontainer" src="' . $image . '" alt="Image Description">';
   															 endforeach;
														endif;
												$overviewinfo .= '</div>';

													//$overviewinfo .= '<img src="'.$brochureimage.'" border="0"/>';		
													//$overviewinfo .= $propgallery;					
												$overviewinfo .= '</div><div class="rightcolumn">';
												if($propertytype === "Villas"){
													$overviewinfo .= '<div class="for-sale-box-container-ind">';
													$overviewinfo .= '<div class="for-sale-box-title">';
													$overviewinfo .= '<p class="proptitle">' . $propnamearea . '</p>';
													$overviewinfo .= '<p class="proptitle">' . $shortdesc . '</p>';
													  $overviewinfo .= '<p class="proptitle">' . $turnkey . '</p>';
													
													$overviewinfo .= '</div>';
													$overviewinfo .= '<div class="for-sale-special-rate-container-ind">';
													$overviewinfo .= '<p class="for-sale-special-rate">' . "Special rate" . '</p>';
													$overviewinfo .= '<div class="specialrate">' . "$" . $specialrate . " <span>USD</span>" . ' / <del>' . "$" . $actualrate . " <span>USD</span>" . '</del></div>';
													$overviewinfo .= '<p class="for-sale-developers">' . "Close by March 31st to get an additional $50,000 USD discount" . '</p>';
													$overviewinfo .= '</div>';
													$overviewinfo .= '</div>';
												}else{
													$overviewinfo .= '<div class="for-sale-box-container-condos-ind">';
													$overviewinfo .= '<div class="for-sale-box-title-condos">';
													
													$overviewinfo .= '<p class="proptitle-condos">' . $propnamearea . '</p>';
													$overviewinfo .= '<p class="proptitle-condos">' . $shortdesc . '</p>';
													$overviewinfo .= '</div>';
													$overviewinfo .= '</div>';
												   
													
												}
												if($propertytype === "Villas"){
													$overviewinfo .= '<div class="fourgrid-ind">';

													if ($oceanview == "true") {
														$overviewinfo .= '<div class="four-grid-inside-container-ind"><img class="fourgrid-first-img" src="/wp-content/uploads/2023/12/IconWaves.png"/><div><p class="text"> Ocean View</p></div></div>';
														}

														$overviewinfo .= '<div class="four-grid-inside-container-ind"><img src="/wp-content/uploads/2023/12/IconHouse.png"/><div><p class="text"> Area </p><p class="number">' . $squarefeet .'</p></div></div>';
														$overviewinfo .= '<div class="four-grid-inside-container-ind"><img class="fourgrid-second-img" src="/wp-content/uploads/2023/12/Guests.png"/><div><p class="number">'. $guests . '</p><p class="text"> Guests</p></div></div>';
														$overviewinfo .= '<div class="four-grid-inside-container-ind"><img src="/wp-content/uploads/2023/12/IconBed.png"/><div><p class="number">'. $beds . '</p><p class="text"> Bedrooms</p></div></div>';
														$overviewinfo .= '<div class="four-grid-inside-container-ind"><img src="/wp-content/uploads/2023/12/IconBathR.png"/><div><p class="number">'. $bathrooms . '</p><p class="text"> Bathrooms</p></div></div>';
														if ($propertytype == 'Villas') {
															$overviewinfo .= '<div class="four-grid-inside-container-ind"><img src="/wp-content/uploads/2023/12/Pool.png"/><div><p class="text"> Private Pool</p></div></div>';
														}
														$overviewinfo .= '</div>';
												}else{
													$overviewinfo .= '<div class="fourgrid-ind-condos">';

													if ($oceanview == "true") {
														$overviewinfo .= '<div class="four-grid-inside-container-ind"><img class="fourgrid-first-img" src="/wp-content/uploads/2023/12/IconWaves.png"/><div><p class="text"> Ocean View</p></div></div>';
														}

														$overviewinfo .= '<div class="four-grid-inside-container-ind"><img src="/wp-content/uploads/2023/12/IconHouse.png"/><div><p class="text"> Area </p><p class="number">' . $squarefeet .'</p></div></div>';
														$overviewinfo .= '<div class="four-grid-inside-container-ind"><img class="fourgrid-second-img" src="/wp-content/uploads/2023/12/Guests.png"/><div><p class="number">'. $guests . '</p><p class="text"> Guests</p></div></div>';
														$overviewinfo .= '<div class="four-grid-inside-container-ind"><img src="/wp-content/uploads/2023/12/IconBed.png"/><div><p class="number">'. $beds . '</p><p class="text"> Bedrooms</p></div></div>';
														$overviewinfo .= '<div class="four-grid-inside-container-ind"><img src="/wp-content/uploads/2023/12/IconBathR.png"/><div><p class="number">'. $bathrooms . '</p><p class="text"> Bathrooms</p></div></div>';
														if ($propertytype == 'Villas') {
															$overviewinfo .= '<div class="four-grid-inside-container-ind"><img src="/wp-content/uploads/2023/12/Pool.png"/><div><p class="text"> Private Pool</p></div></div>';
														}
														$overviewinfo .= '</div>';
												}
												     

											
													
													$overviewinfo .= '<div class=for-sale-features-continer-ind>';
														//$overviewinfo .= '<div class=for-sale-features-continer-left>';
														//	$overviewinfo .= $features;
														//$overviewinfo .= '</div>';
														if($propertytype === "Villas"){
															$overviewinfo .= '<div class=for-sale-features-continer-right>';
															$overviewinfo .= '<button><a target="_new" href="'.$pdf.'"><i class="fa-regular fa-arrow-down-to-bracket"></i> Download material</a></button>';
															$overviewinfo .= '<button><a target="_new" href="#features-for-sale"><i class="fa-solid fa-arrow-right"></i> Features</a></button>';
														$overviewinfo .= '</div>';
														}else{
															$overviewinfo .= '<div class=for-sale-features-continer-right-condos-ind>';
															$overviewinfo .= '<button><a target="_new" href="#amenities-for-sale"><i class="fa-solid fa-arrow-right"></i> Amenities</a></button>';
														    $overviewinfo .= '</div>';
														}
														
													$overviewinfo .= '</div>';
										        $overviewinfo .= '</div>';
											$overviewinfo .= '</div>';
	
			$topsection .= $overviewinfo;
			$topsection .= '</div>';	
	
		$formsection .= '<div class="formblock">';
			$formsection .= '<div class="leftcol">';
				$formsection .= '<h3> Want more information on '.$proptype.' for sale or to schedule a tour?</h3>';
				$formsection .= '<p><a href="https://api.whatsapp.com/send?phone=50588533330">Contact Us <i class="fa-brands fa-whatsapp fa-xl"></i></a></p>';
			$formsection .= '</div>';
			$formsection .= '<div class="rightcol">';
			if ($proptype == 'Villas') {
				// Villas Nutshell Form Code
				$formsection .= '<div class="formConstantC-prop-ind">' . do_shortcode('[formidable id=9]') . '</div>';
			} elseif ($proptype == 'Condos') {
				// Condos Nutshell Form Code
				$formsection .= '<div class="formConstantC-prop-ind">' . do_shortcode('[formidable id=10]') . '</div>';
			}
			$formsection .= '</div>';
		$formsection .= '</div>';

	$bottomsection .= '<div class="propertydetails">';
		if ($features) {
			$bottomsection .= '<div id="features-for-sale" class="features">';
				$bottomsection .= '<div class="iconbar"><div class="icon"><img src="/wp-content/uploads/2023/09/room-facilities.svg" border="0" /></div> Property Features </div>';
				$bottomsection .= $features;	
			$bottomsection .= '</div>';
		}
		if ($amenities) {
			$bottomsection .= '<div id="amenities-for-sale" class="amenities">';
				$bottomsection .= '<div class="iconbar"><div class="icon"><img src="/wp-content/uploads/2023/09/onsite-amenities.svg" border="0" /></div> On-Site Amenities </div>';
				$bottomsection .= $amenities;
				$bottomsection .= '<a class="learnmore button" href="/amenities">LEARN MORE</a>';
			$bottomsection .= '</div>';
		}
		if ($services) {
			$bottomsection .= '<div class="services">';
				$bottomsection .= '<div class="iconbar"><div class="icon"><img src="/wp-content/uploads/2023/09/available-services.svg" border="0" /></div> Available Services </div>';
				$bottomsection .= $services;	
				$bottomsection .= '<a class="learnmore button" href="/services">LEARN MORE</a>';
			$bottomsection .= '</div>';
		}
		if ($maplink) {
			$bottomsection .= '<div class="location">';
				$bottomsection .= '<div class="iconbar"><div class="icon"><i class="fa-thin fa-earth-americas"></i></div> Location </div>';
				$bottomsection .= '<iframe src="'.$maplink.'" " width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
			$bottomsection .= '</div>';
		}
	$bottomsection .= '</div>';

		$output .= $topsection;
		$output .= $formsection;
		$output .= $bottomsection;
	
		$output .= '</div>';
	$output .= '</div>';
	return $output;
}

add_shortcode('property_details','displayPropertyDetails');


function displayGallery($atts) {
	
	$atts = shortcode_atts( array(
		'numberofposts' => '0',
		'showlinks' => '0',
    ), $atts, 'blog_grid' );
	
	$output = "";
	
	$images = get_field('gallery_images');
	$size = 'full'; // (thumbnail, medium, large, full or custom size)
	if( $images ): 
		$output .= '<ul class="masonry">';
	
		$numimages = 1;
	
			foreach( $images as $image ):
	
				$desc = $image['description'];
				$blocktarget = $image['caption'];
	
					if ($atts['showlinks'] == 1) { 
						$output .= '<li data-tab="'.$blocktarget.'">';
					} else {
						$output .= '<li>';
					}
					$output .= '<div class="overlay"></div>';
					$output .= '<img src="'.$image['sizes']['large'].'" border="0" />';
					$output .= '<h4>' . $desc . '</h4>';
				$output .= '</li>';
	
			if ($atts['numberofposts'] > 0) {
				if ($numimages == $atts['numberofposts']) {
					$output .= '</ul><ul class="moreimages">';
				}
			}
	
				$numimages++;
	
			endforeach; 
		$output .= '</ul>';
	endif; 

	return $output;
}

add_shortcode('masonry_gallery','displayGallery');

function displayLargeSlider( ) {
	
	$output = '<div id="largesliderwrap">';
				$output .= '<h3> Vacation Can Last a Lifetime </h3>';

	$images = get_field('gallery_images');
	$size = 'full'; // (thumbnail, medium, large, full or custom size)
	if( $images ): 
		$output .= '<div class="largeslider">';
	
			foreach( $images as $image ):
				$output .= '<img src="'.$image['sizes']['2048x2048'].'" border="0" />';
			endforeach; 
	
		$output .= '</div>';
	endif; 

	$output .= '</div>';
	
	return $output;
}

add_shortcode('large_slider','displayLargeSlider');


function displayContentSlider() {
	
	$output = "";
	
		// Check rows existexists.
		if( have_rows('slider_blocks') ):
	
			$output .= '<div id="contentslider">';

			// Loop through rows.
			while( have_rows('slider_blocks') ) : the_row();

				// Load sub field value.
				$title = get_sub_field('title');
				$desc = get_sub_field('description');
				$featured_img_url = get_sub_field('block_image');
				$link = get_sub_field('button_link');
	
				$output .= '<div class="slide">';
					$output .= '<div class="blockimage">';
						$output .= '<div style="background-image: url('.$featured_img_url.'); ">';
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="centerblock">';
						$output .= '<h3>'. $title . '</h3>';
						$output .= '<p class="desc">'. $desc .'</p>';
						$output .= '<p class="readmore"><a class="button" href="'.$link.'">EXPLORE MORE</a></p>';
					$output .= '</div>';
				$output .= '</div>';
	
			// End loop.
			endwhile;

			$output .= '</div>';
		// No value.
		else :
			// Do something...
		endif;
	
	return $output;
	
}

add_shortcode('content_slider', 'displayContentSlider');


function displayBlockSlider( ) {
	
	$output = "";
	
		// Check rows existexists.
		if( have_rows('content_blocks') ):
	
			$output .= '<div id="block_slider">';

			// Loop through rows.
			while( have_rows('content_blocks') ) : the_row();

				// Load sub field value.
				$title = get_sub_field('title');
				$desc = get_sub_field('description');
				$featured_img_url = get_sub_field('block_image');
				$link = get_sub_field('block_link');
				$quotename = get_sub_field('quote_name');
	
				$output .= '<div class="slide">';
					$output .= '<div class="slidewrap">';
						$output .= '<div class="contentimage">';
							$output .= '<div style="background-image: url('.$featured_img_url.'); ">';
							$output .= '</div>';
						$output .= '</div>';
						$output .= '<div class="centerblock">';
							$output .= '<div>';
							$output .= '<h3>'. $title . '</h3>';
							$output .= '<p class="desc">'. $desc . '</p>';
							$output .= '<p class="desc">'. $quotename . '';
							$output .= '<span class="readmore"><a href="'.$link.'">READ MORE</a></span></p>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
	
			// End loop.
			endwhile;

			$output .= '</div>';
		// No value.
		else :
			// Do something...
		endif;
	
	return $output;
	
}

add_shortcode('block_slider', 'displayBlockSlider');


function displayTestimonialSplitSlider( $atts ) {

    $atts = shortcode_atts( array(
        'id' => 76,
    ), $atts, 'testimonial_split_slider' );

    $output = "";

    // Check rows exist.
    if( have_rows('testimonials', $atts['id']) ):

        $topslides = "";
        $bottomslides = "";

        // Loop through rows.
        while( have_rows('testimonials', $atts['id']) ) : the_row();

            // Load sub field value.
            $title = get_sub_field('review_title');
            $topreview = get_sub_field('top_review');
            $bottomreview = get_sub_field('bottom_review');
            $stars = get_sub_field('stars');
            $name = get_sub_field('review_name');

            $topslide = '<div class="slide">';
            $topslide .= '<div class="topblock">';
            $topslide .= '<div>';
            $topslide .= '<span class="shortline"></span>';
            $topslide .= '<h3>'. $title . '</h3>';
            $topslide .= '<p class="desc">'. $topreview . '</p>';
            $topslide .= '</div>';
            $topslide .= '</div>';
            $topslide .= '</div>';
            $topslides .= $topslide;

            $bottomslide = '<div class="slide">';
            $bottomslide .= '<div class="bottomblock">';
            $bottomslide .= '<h3>'. $name . '</h3>';
            $bottomslide .= '<span><i class="fa-solid fa-star fa-xs"></i><i class="fa-solid fa-star fa-xs"></i><i class="fa-solid fa-star fa-xs"></i><i class="fa-solid fa-star fa-xs"></i><i class="fa-solid fa-star fa-xs"></i></span>';
            $bottomslide .= '<p class="desc">'. $bottomreview . '</p>';
            $bottomslide .= '</div>';
            $bottomslide .= '</div>';
            $bottomslides .= $bottomslide;

        // End loop.
        endwhile;

        $output .= '<div id="testimonial_top_slider">';
        $output .= $topslides;
        $output .= '</div>';
        $output .= '<div id="testimonial_bottom_slider">';
        $output .= $bottomslides;
        $output .= '</div>';

    // No value.
    else :
        // Do something...
    endif;

    return $output;

}

add_shortcode('testimonial_split_slider', 'displayTestimonialSplitSlider');


function displayTestimonialSlider( $atts ) {
	
	$atts = shortcode_atts( array(
        'id' => 76,
    ), $atts, 'testimonial_column_slider' );
	
	$output = "";
	
		// Check rows existexists.
		if( have_rows('testimonials', $atts['id']) ):
	
			$output .= '<div id="testimonial_slider">';

			// Loop through rows.
			while( have_rows('testimonials', $atts['id']) ) : the_row();

				// Load sub field value.
				$title = get_sub_field('review_title');
				$topreview = get_sub_field('top_review');
				$bottomreview = get_sub_field('bottom_review');
				$stars = get_sub_field('stars');
				$name = get_sub_field('review_name');
	
				$output .= '<div class="slide">';
					$output .= '<div class="topblock">';
						$output .= '<div>';
							$output .= '<span class="shortline"></span>';
							$output .= '<h3>'. $title . '</h3>';
							$output .= '<p class="desc">'. $topreview . '</p>';
							$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="bottomblock">';
						$output .= '<h3>'. $name . '</h3>';
						$output .= '<span><i class="fa-solid fa-star fa-xs"></i><i class="fa-solid fa-star fa-xs"></i><i class="fa-solid fa-star fa-xs"></i><i class="fa-solid fa-star fa-xs"></i><i class="fa-solid fa-star fa-xs"></i></span>';
						$output .= '<p class="desc">'. $bottomreview . '</p>';
					$output .= '</div>';
				$output .= '</div>';
	
			// End loop.
			endwhile;

			$output .= '</div>';
		// No value.
		else :
			// Do something...
		endif;
	
	return $output;
	
}

add_shortcode('testimonial_column_slider', 'displayTestimonialSlider');


function displayBlogGrid( $atts ) {
	
	$atts = shortcode_atts( array(
        'title' => 'no title',
        'type' => 'regular',
		'numberofposts' => '5',
		'category' => '5'
    ), $atts, 'blog_grid' );
				
				$args = array( 'post_type' => 'post', 'posts_per_page' => $atts['numberofposts'], 'cat' => $atts['category'], 'order' => 'ASC');
				$the_query = new WP_Query( $args );

				if ( $the_query->have_posts() ) {

					$output = '<div class="blog_grid">';

                    $ctr = 0;

					while ( $the_query->have_posts() ) {
						$the_query->the_post();

						$id = get_the_ID();
						$name = get_the_title($id);
                        $date = get_the_date( $format = '', '', '', 0 );
						
						$link = get_permalink($id);
						$postsource = get_field('post_source', $id);
						$eventdate = get_field('event_date', $id);
						$featured_img_url = get_the_post_thumbnail_url($id,'full'); 
						$image = '<div class="thumbnail" style="background: url('.$featured_img_url.');"></div>';
							$externalsource = get_field('external_source');
							$externallink = get_field('external_link');

							 $output .= '<div class="article">';
								$output .= '<div class="overlay"></div>';
                                $output .= $image;
                                $output .= '<div class="metainfo">';
                                    $output .= '<h3>' . $name . '</h3>';
									if ($externalsource) {
						            	$output .= '<h5>' . $externalsource . '</h5>';
									}

									if ($externallink) {
										$output .= '<p class="readmore"><a target="_new" class="button" href="' . $externallink . '">Read More</a></p>';
									} else {
										$output .= '<p class="readmore"><a class="button" href="' . $link . '">Read More</a></p>';
									}
								$output .= '</div>';
                            $output .= '</div>';
						}
						$output .= '</div>';

            		}

		wp_reset_postdata();

	return $output;
}

add_shortcode('blog_grid', 'displayBlogGrid');

function displayPropertySlider($atts) {
	
	$atts = shortcode_atts( array(
		'type' => 'move-in'
    ), $atts, 'property_slider' );
	
	$output = "";
	
		// Check rows existexists.
		if( have_rows('properties') ):
	
			$output .= '<div id="propertyslider">';
	
			// Loop through rows.
			while( have_rows('properties') ) : the_row();

				// Load sub field value.
				$name = get_sub_field('name');
				$proptext = get_sub_field('prop_text');
				$propertypic = get_sub_field('prop_image');

				$output .= '<div class="slide">';
					$output .= '<div class="propertypic">';
						$output .= '<div style="background-image: url('.$propertypic.'); ">';
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="meta">';
						$output .= '<div class="text">'. $proptext . '</div>';
						$output .= '<p class="name"><a class="button" href="">'. $name . '</a></p>';
					$output .= '</div>';
				$output .= '</div>';
	
			// End loop.
			endwhile;

			$output .= '</div>';
		// No value.
		else :
			// Do something...
		endif;
	
	return $output;
	
}

add_shortcode('property_slider', 'displayPropertySlider');

function displayRepeaterBlocks($atts) {
	
	$atts = shortcode_atts( array(
		'type' => 'grid',
		'id' => 'gridblock'
    ), $atts, 'block_grid' );
	
	$output = "";
	
		// Check rows existexists.
		if( have_rows('blocks') ):
	
			$output .= '<div id="'.$atts['id'].'">';
	
			// Loop through rows.
			while( have_rows('blocks') ) : the_row();

				// Load sub field value.
				$label = get_sub_field('block_type');
				$name = get_sub_field('block_name');
				$text = get_sub_field('block_description');
				$image = get_sub_field('block_image');

				$output .= '<div class="block">';
						$output .= '<div class="label"><span>' . $label . '</span></div>';
						$output .= '<div class="blockpic">';
							$output .= '<div style="background-image: url('.$image.'); "></div>';
						$output .= '</div>';
								$output .= '<div class="footerborder"></div>';
						$output .= '<div class="meta">';
							$output .= '<h3>'. $name . '</h3>';
							$output .= '<p>'. $text . '</p>';
						$output .= '</div>';
				$output .= '</div>';
	
			// End loop.
			endwhile;

			$output .= '</div>';
		// No value.
		else :
			// Do something...
		endif;
	
	return $output;
	
}

add_shortcode('block_grid', 'displayRepeaterBlocks');

include_once('propertysearch.php');



