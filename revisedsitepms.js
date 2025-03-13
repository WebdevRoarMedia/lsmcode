jQuery.urlParam = function(name) {
    return new URLSearchParams(window.location.search).get(name);
};
function getsize(URL, sliderwrap, callback) {
    var image = new Image();
    image.src = URL;
    image.onload = function() {
        if (image.height < 1200) {
            sliderwrap.append('<div><img src="' + URL + '" alt="Property Image"></div>');
        }
        callback(sliderwrap);
    };
}
function storeSelectedCheckboxes() {
    const selectedCheckboxes = [...document.querySelectorAll('input[type="checkbox"]:checked')].map(checkbox => checkbox.value);
    sessionStorage.setItem('selectedCheckboxes', JSON.stringify(selectedCheckboxes));
}
function checkSelectedCheckboxes() {
    const selectedCheckboxes = JSON.parse(sessionStorage.getItem('selectedCheckboxes') || '[]');
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = selectedCheckboxes.includes(checkbox.value);
    });
}
function convertCurrency( amount ) {
	var nioExchangeRate = 36.6243;
	return amount * nioExchangeRate;
}
function decodeHTML(text) {
    var parser = new DOMParser();
    var decodedString = parser.parseFromString(text, 'text/html').documentElement.textContent;
    return decodedString;
}
function datediff(first, second) {
	return Math.round((second - first) / (1000 * 60 * 60 * 24));
}
function convertDateFormat(dateString) {
    const [year, month, day] = dateString.split("-");
    return `${month}/${day}/${year}`;
}
// Converts from mm/dd/yyyy to yyyy-mm-dd
function parseDate(str) {
    if (str.includes("/")) {
        const [month, day, year] = str.split('/');
        return formatDate(new Date(year, month - 1, day));
    }
    return new Date(str);
}
function formatDate(date) {
    const d = new Date(date);
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    const year = d.getFullYear();
    return `${year}-${month}-${day}`;
}

function checkAvailabilityAndPricing(result, extrapersonfee) {
    const bookingdates = result.data[0].data.days;
    const totalnights = sessionStorage.getItem('totalnights');
    let isAvailable = 1;
    let totalprice = 0.00;
    let detailsblock = '<div class="toprow"> Booking Summary </div>';
    
    sessionStorage.removeItem('totalpricing');
    sessionStorage.removeItem('availability');
    sessionStorage.removeItem('pricingdetails');
    
    for (let d = 0; d < totalnights; d++) {
        const calendardate = bookingdates[d];
        if (calendardate.status !== "available") {
            isAvailable = 0;
        }
        const dayprice = parseFloat(calendardate.price);
        totalprice += dayprice;
        detailsblock += `<div class="row"><span>${calendardate.date}</span><span>${dayprice.toFixed(2)} USD</span></div>`;
    }
    
    if (extrapersonfee) {
        totalprice += parseFloat(extrapersonfee);
        detailsblock += `<div class="row"><span>Extra Person Fee: </span><span>${parseFloat(extrapersonfee).toFixed(2)} USD</span></div>`;
    }
    
    const bookingfee = totalprice * 0.17;
    totalprice += bookingfee;
    detailsblock += `<div class="row"><span>Taxes: </span><span>${bookingfee.toFixed(2)} USD</span></div>`;
    detailsblock += `<div class="row"><span>Total: </span><span>${totalprice.toFixed(2)} USD</span></div>`;
    
    sessionStorage.setItem('pricingdetails', detailsblock);
    sessionStorage.setItem('totalpricing', totalprice.toFixed(2));
    sessionStorage.setItem('availability', isAvailable);
    
    return { availability: isAvailable, totalprice: totalprice.toFixed(2) };
}

/*
* This function will populate the booking details on the thank you page
*/
function populateBookingDetails() {
	var confirmation = 1 + Math.floor(Math.random() * 999999);
	// Pull booking details from short term storage
	if (window.sessionStorage) {
		var details = sessionStorage.getItem("bookingdetails");
		jQuery("#bookingdetails #proppic img").attr("src", sessionStorage.getItem('propthumb'));
		jQuery("#bookingdetails #propname b").text(sessionStorage.getItem('propertyname'));
		jQuery('#bookingdetails #confirmation span').text( sessionStorage.getItem('current_reservation_id') );
		jQuery('#bookingdetails #guestname span').text(sessionStorage.getItem('guestfirstname')+" "+sessionStorage.getItem('guestlastname'));
		jQuery('#bookingdetails #arrivaldate span').text(sessionStorage.getItem('arrivaldate'));
		jQuery('#bookingdetails #departuredate span').text(sessionStorage.getItem('departuredate'));
		jQuery('#bookingdetails #nights span').text(sessionStorage.getItem('totalnights'));
		jQuery('#bookingdetails #guests span').text(sessionStorage.getItem('numberguests'));
		jQuery('#bookingdetails #rooms span').text(sessionStorage.getItem('numrooms'));
		jQuery('#bookingdetails #totalcost span').text( "$" + parseFloat(sessionStorage.getItem('totalamounttocharge')).toFixed(2) + "/nio" );
	}
	return false;
}
/*
* This function shows the property pricing
*/
function showPropertyPricing( propid, arrival, departure, extrapersonfee, passedtotal ) {
	jQuery.ajax({
		type: "GET",
		url: "/wp-admin/admin-ajax.php",
		dataType: "json",
		data: {
			action: 'get_room_rates',
			property_id: propid,
			start_date: arrival,
			end_date: departure,
		},
		success: function (output) {			
			var totalprice = output.data[0].data.totalRate;
			var isAvailable = output.data[0].data.roomsAvailable;
				sessionStorage.setItem('availability', isAvailable);
				sessionStorage.setItem('totalpricing', passedtotal);
				getPropertyTotalCostInitial( propid, arrival, departure, passedtotal);
		}
	});
}

/* This function will get the total cost of the property */
function getPropertyTotalCostInitial( propid, arrival, departure, totalcost ) {
	jQuery.ajax({
		type: "GET",
		url: "/wp-admin/admin-ajax.php",
		dataType: "json",
		data: {
			action: 'get_room_totalcost',
			// add your parameters here (bedrooms, arrival, departure, cost, rooms);
			property_id: propid,
			start_date: arrival,
			end_date: departure,
			total_cost: totalcost * sessionStorage.getItem('numrooms'),
			rooms_count: sessionStorage.getItem('numrooms'),
		},
		success: function (output) {
			jQuery('.rentaldetails .totalprice').text("$" + parseFloat(output.data[0].data.roomsTotalWithoutTaxes).toFixed(2) + "/usd");
			jQuery('.rentaldetails .taxes').text("$" + parseFloat(output.data[0].data.totalTaxes).toFixed(2) + "/usd");
			jQuery('.rentaldetails .paynow').text("$" +  parseFloat(output.data[0].data.grandTotal).toFixed(2) + "/usd");
			jQuery('.rentaldetails .chargeamount').text("$" +  convertCurrency(parseFloat(output.data[0].data.grandTotal)).toFixed(2) + "/nio");

            // Store these for later
			sessionStorage.setItem('totalbookingamount', parseFloat(output.data[0].data.grandTotal).toFixed(2) );
			sessionStorage.setItem('totalamounttocharge', convertCurrency(parseFloat(output.data[0].data.grandTotal)).toFixed(2) ); // This will need to be in USD
		}
	});
}


function getPropertyTotalCost( propid, arrival, departure, totalcost ) {

	jQuery.ajax({
		type: "GET",
		url: "/wp-admin/admin-ajax.php",
		dataType: "json",
		data: {
			action: 'get_room_totalcost',
			// add your parameters here (bedrooms, arrival, departure);
			property_id: propid,
			start_date: arrival,
			end_date: departure,
			total_cost: totalcost * sessionStorage.getItem('numrooms'),
			rooms_count: sessionStorage.getItem('numrooms'),
		}
		,
		success: function (output) {
			jQuery('#steptwosummary .totalcost').text("$" + parseFloat(output.data[0].data.roomsTotalWithoutTaxes).toFixed(2) + "/usd");
			jQuery('#steptwosummary .taxes').text("$" + parseFloat(output.data[0].data.totalTaxes).toFixed(2) + "/usd");
			jQuery('#steptwosummary .totalcostwithtax').text("$" +  parseFloat(output.data[0].data.grandTotal).toFixed(2) + "/usd" );
			jQuery('#steptwosummary .amounttocharge').text("$" +  convertCurrency(parseFloat(output.data[0].data.grandTotal)).toFixed(2) + "/nio");
		}
	});
}

/* This function will get the property availability */
function showPropertyAvailability( propid, arrival, departure, property, listlength ) {
	jQuery.ajax({
		type: "GET",
		url: "/wp-admin/admin-ajax.php",
		dataType: "json",
		data: {
			action: 'check_property_availability',
			// add your parameters here (bedrooms, arrival, departure);
			property_id: propid,
			start_date: arrival,
			end_date: departure
		},
		success: function (output) {
			var days = output.data[0].data.days;
			var booked = 0;
			for(d=0;d<days.length;d++) {
				if (days[d].status == 'booked' || days[d].status == 'unavailable') {
					booked++;
				}
			}
			if (booked == 0) {
				jQuery('#propertysearchresults').append(property);
			}
			properties++;
		},
		complete: function (data) {
			var numberprops = jQuery('#propertysearchresults .prop-list-get-outside').length;
			jQuery('.numberresults span').html( numberprops );
			if (properties > 1) {
				jQuery('#propertysearchresults .loading').hide();
				jQuery('#propertysearchresults .loadingresults').hide();
			}
			if (properties >= listlength) {
				if (numberprops < 1) {
					var output = '<p> Some of the properties may not be available for at least one of the days chosen. Please update your dates selection. </p>';
					jQuery('#propertysearchresults').append(output);
				}
				// Run our bed sort now that we have all available properties
				jQuery("#propertysearchresults > div").sort(sort_bybed).appendTo('#propertysearchresults');
				function sort_bybed(a, b) {
					return (jQuery(b).data('maxguests')) < (jQuery(a).data('maxguests')) ? 1 : -1;
				}
				// Now run our checkSelectedCheckboxes code
				setTimeout(function() {
					checkSelectedCheckboxes();
					var filters = 0;
					jQuery('#propertysearchresults .prop-list-get-outside').hide();
					jQuery('.filterby input').each(function() {
						var isChecked = jQuery(this).is(':checked');
						if (isChecked && jQuery(this).hasClass('numberofguests')) {
							var guestfilter = jQuery(this).val();
							jQuery('#propertysearchresults .prop-list-get-outside').each(function() {
								var maxguests = jQuery(this).data('maxguests');
								if (maxguests == guestfilter) {
									jQuery(this).show();
								}
							}
																						);
							filters++;
						}
					});
					if (filters==0) { jQuery('#propertysearchresults .prop-list-get-outside').show() }
				}, 2000);
			}
		}
	});
}

function capturePayment() {
	var tid = sessionStorage.getItem('transid');
	
	jQuery.ajax({
		type: "GET",
		url: "/wp-admin/admin-ajax.php",
		dataType: "json",
		data: {
			action: 'capture_payment',
			amount: sessionStorage.getItem('totalamounttocharge'),
			transid: tid.replace(/\"/g, ""),
		}
		,
		success: function (output) {
			postPayment();
			sendPaymentNotification();
		},
		complete: function (data) {
			sessionStorage.clear();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			var errormessage = '<div class="errormessage"> There was an error in booking your reservation. <br>';
			errormessage += '<p>' + thrownError + '</p></div>';
		},
	});
}

function postPayment() {

	var currentReservationID = sessionStorage.getItem('current_reservation_id');

	jQuery.ajax({
		type: "GET",
		url: "/wp-admin/admin-ajax.php",
		dataType: "json",
		data: {							
			action: 'post_payment',
			reservation_id: currentReservationID,
			amount: sessionStorage.getItem('totalbookingamount'),
			property_id: sessionStorage.getItem('propertyid'),
		},
		success: function (output) {	
			// Posting Payment
		},
		complete: function (data) {
			// Posting completed
		},
		error: function (xhr, ajaxOptions, thrownError) {
			var errormessage = '<div class="errormessage"> There was an error in booking your reservation. <br>';
			errormessage += '<p>' + thrownError + '</p></div>';
		},
	});	
}

function sendPaymentNotification() {

	var currentReservationID = sessionStorage.getItem('current_reservation_id');
	
	jQuery.ajax({
		type: "GET",
		url: "/wp-admin/admin-ajax.php",
		dataType: "json",
		data: {							
			action: 'send_notification',
			reservation_id: currentReservationID,
			amount: sessionStorage.getItem('totalamounttocharge'),
			guest_name: sessionStorage.getItem('guestfirstname') + " " + sessionStorage.getItem('guestlastname'),
		},
		success: function (output) {		
			// Sending payment notification
		},
		complete: function (data) {
			// Notification complete
		},
		error: function (xhr, ajaxOptions, thrownError) {
			var errormessage = '<div class="errormessage"> There was an error in booking your reservation. <br>';
			errormessage += '<p>' + thrownError + '</p></div>';
		},
	});	
}

function createReservation( ) {
	jQuery.ajax({
		type: "GET",
		url: "/wp-admin/admin-ajax.php",
		dataType: "json",
		data: {
			action: 'create_reservation',
			// add your parameters here (bedrooms, arrival, departure);
			property_id: sessionStorage.getItem('propertyid'),
			room_id: sessionStorage.getItem('roomid'),
			start_date: sessionStorage.getItem('arrivaldate'),
			end_date: sessionStorage.getItem('departuredate'),
			total: sessionStorage.getItem('totalamounttocharge'),
			firstname: sessionStorage.getItem('guestfirstname'),
			lastname: sessionStorage.getItem('guestlastname'),
			cellphone: sessionStorage.getItem('guestcell'),
			country: sessionStorage.getItem('guestcountry'),
			email: sessionStorage.getItem('guestemail'),
			zip: sessionStorage.getItem('guestzip'),
			number_adults: sessionStorage.getItem('numberguests'),
			paymentMethod: "ebanking",
			promo_code: sessionStorage.getItem('rateID')
		},
		success: function (output) {
			if (output.data[0].success) {
				window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({ 
                    'event': 'purchase', 
                    'boton_id': 'Confirm Booking',
                    ecommerce: {
                        items: [{
                            item_name:  sessionStorage.getItem('propertyname'),
                                item_id: sessionStorage.getItem('propertyid'),
                                price: sessionStorage.getItem('totalamounttocharge'),
                                item_brand: 'lsm',
                                item_category: 'short-term',
                                quantity: '1'
                        }]
                    }
                });
				
				sessionStorage.setItem('current_reservation_id', output.data[0].reservationID);
				sessionStorage.setItem('reservation_details', JSON.stringify(output.data[0]));
				window.location.href = "/thank-you";
			}
		},
		complete: function(output) {
		},
		error: function (xhr, ajaxOptions, thrownError) {
			// Add some sort of tracking for failed reservation.
			var errormessage = '<div class="errormessage"> There was an error in booking your reservation. <br>';
			errormessage += '<p>' + thrownError + '</p></div>';
		}
	});
}

function getPropertyDetails( propid, arrival, departure, totalnights, extrapersonfee, startingprice ) {
	// Store these for later
	sessionStorage.setItem("arrivaldate", arrival);
	sessionStorage.setItem("departuredate", departure);
	
	if (!startingprice) {
		startingprice = sessionStorage.getItem('propertyrate');
	}
	
	// Get Property Details and display
	jQuery.ajax({
		type: "GET",
		url: "/wp-admin/admin-ajax.php",
		dataType: "json",
		data: {
			action: 'get_property_detail',
			property_id: propid,
			arrival: arrival,
			departure: departure
		},
		success: function (output) {
			showPropertyDetail(output, totalnights);
			showPropertyPricing(propid, arrival, departure, extrapersonfee, startingprice);
			slickSPropertyDetail(output);
		}
	});

	return;
}
function slickSPropertyDetail(details ) {
	var proppicturesSlick = details.data[0].roomTypePhotos;
    var newDivSlick = document.createElement('div');
	var propertyImagesElement = document.getElementById('propertyimages');
	    propertyImagesElement.parentNode.insertBefore(newDivSlick, propertyImagesElement.nextSibling);

	    // Add an ID to the Slick slider
	    newDivSlick.id = 'single-reserv-slider';

        // Initialize Slick slider with the specified ID
        jQuery('#single-reserv-slider').slick({
            slidesToShow: 1,
            autoplay: true,
            arrows:true,
            prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button"><i class="fa-thin fa-angle-left" aria-hidden="true"></i></button>',
            nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button"><i class="fa-thin fa-angle-right" aria-hidden="true"></i></button>',
        });
        proppicturesSlick.forEach(function (picture) {
            jQuery('#single-reserv-slider').slick('slickAdd', '<div><img src="' + picture + '"></div>');
        });
}
							 
	function showPropertyDetail( apidata, totalnights) {
		// Make sure to store values to display in summary
		var details = apidata.data[0];
		var title = details.data[0].roomTypeName;
		var proppictures = details.data[0].roomTypePhotos;
		var baseprice = details.data[0].roomRate;
		var bathrooms = details.data[0].bathrooms;
		var capacity = details.data[0].maxGuests;
		var amenities = details.data[0].roomTypeFeatures;
		var roomsAvailable = details.data[0].roomsAvailable;
		var roomDescription = details.data[0].roomTypeDescription;
		var checkIn = "3:00";
		var checkOut = "11:00";
		var terms = details.data[0].terms;
		jQuery('#checkintime').text(checkIn + 'pm');
		jQuery('.featurebar .guests').text(capacity);
		jQuery('#checkouttime').text(checkOut + 'am');
		jQuery('#propertyimages').html('');
		// Store these for later
		sessionStorage.setItem("propertyname", title);
		sessionStorage.setItem("totalnights", totalnights);
		sessionStorage.setItem("capacity", capacity);
		sessionStorage.setItem('propthumb', proppictures[0]);
		for (var x=0; x<proppictures.length; x++) {
			var gridimage = proppictures[x];
			if (x<4) {
				if (x==3) {
					var griditem = '<div class="griditem"><div class="gridimage" index="0" data-bg="'+gridimage+'" style="background-image: url('+gridimage+');"></div><span class="photocount">+'+proppictures.length+'</span></div>';
				}
				else {
					var griditem = '<div class="griditem"><div class="gridimage" index="0" data-bg="'+gridimage+'" style="background-image: url('+gridimage+');"></div></div>';
				}
				jQuery('#propertyimages').append(griditem);
				jQuery('#hiddenimages').append(griditem);
			}
			else {
				var griditem = '<div class="griditem"><div class="gridimage" index="0" data-bg="'+gridimage+'" style="background-image: url('+gridimage+');"></div></div>';
				jQuery('#hiddenimages').append(griditem);
			}
		}
		jQuery('#propertyimages').addClass('displayed');
		// Create the slick slider
		var slickContainer = jQuery('<div class="slick-container"></div>');
		jQuery('#propertyimages').append(slickContainer);
		for (var x = 0; x < proppictures.length; x++) {
			var imageUrl = proppictures[x].original;
			var slickImage = '<div><img src="' + imageUrl + '" alt="Property Image"></div>';
			slickContainer.append(slickImage);
		}
		slickContainer.slick({
			infinite: true,
			slidesToShow: 1, 
			slidesToScroll: 1,
			prevArrow: '<button type="button" class="slick-prev">Previous</button>',
			nextArrow: '<button type="button" class="slick-next">Next</button>'
		}
							);
		//Amenities
		var amenitylist = "<ul>";
		var newDiv = document.createElement('div');
		var newDivsecond = document.createElement('div');
		var newh5 = document.createElement('h5');
		var newh5second = document.createElement('h5');
		var newspan= document.createElement('span')
		var newspansecond= document.createElement('span')
		var newI = document.createElement('i');
		var newIsecond = document.createElement('i');
		
		jQuery('#singlepropertydescription').html(roomDescription);
		
		newh5.textContent = 'LEARN MORE';
		newh5second.textContent = 'LEARN LESS';
		var size = Object.keys(amenities).length;
		for (var i = 0; i < size; i++) {
			amenitylist += "<li>" + amenities[i] + "</li>";
		}
		amenitylist += "</ul>";
		jQuery('.details').append(amenitylist);
		newDiv.className = 'single-prop-amen-learnM';
		newDivsecond.className = 'single-prop-amen-learnL';
		newh5.className = 'single-prop-amen-learnM-h5';
		newh5second.className = 'single-prop-amen-learnL-h5';
		newspan.className = 'single-prop-amen-learnM-span';
		newspansecond.className = 'single-prop-amen-learnL-span';
		newI.className = 'fa-regular fa-angle-down';
		newIsecond.className = 'fa-regular fa-angle-up';
		var detailsDiv = document.querySelector('.details');
		detailsDiv.parentNode.insertBefore(newDiv, detailsDiv.nextSibling);
		var detailsDiv2 = document.querySelector('.details');
		detailsDiv.parentNode.insertBefore(newDivsecond, detailsDiv2.nextSibling);
		document.querySelector('.single-prop-amen-learnM').appendChild(newh5)
		document.querySelector('.single-prop-amen-learnM').appendChild(newspan)
		document.querySelector('.single-prop-amen-learnM-span').appendChild(newI)
		document.querySelector('.single-prop-amen-learnL').appendChild(newh5second)
		document.querySelector('.single-prop-amen-learnL').appendChild(newspansecond)
		document.querySelector('.single-prop-amen-learnL-span').appendChild(newIsecond)
		var h5Element = document.querySelector('.single-prop-amen-learnM');
		var learnLElement = document.querySelector('.single-prop-amen-learnL');
		h5Element.addEventListener('click', function () {
			document.querySelectorAll('.propertydetails .details ul li:nth-child(n+9)').forEach(function (element) {
				element.style.display = 'block';
			}
																							   );
			h5Element.style.display = 'none';
			learnLElement.style.display = 'flex';
		}
								  );
		learnLElement.addEventListener('click', function () {
			learnLElement.style.display = 'none';
			h5Element.style.display = 'flex';
			document.querySelectorAll('.propertydetails .details ul li:nth-child(n+9)').forEach(function (element) {
				element.style.display = 'none';
			}
																							   );
		}
									  );
	}
	function generateLongTermGrid() {
		var output = "";
		let props = [
			{
				id:1,
				title:"Ocean-View 4 Bedroom Villa with Plunge Pool and Maids Quarters",
				price:4914,
				images:["https://lsmresort.com/wp-content/uploads/2024/06/LSM18_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM17_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM16_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM15_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM14_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM13_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM12_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM11_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM10_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM9_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM8_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM7_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM6_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM5_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM4_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM3_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM2_4bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM1_4bvillawplungepool.jpeg",
					   ]
			},{
				id:2,
				title:"Ocean-View 3 Bedroom Apartment with Balcony",
				price:3391,
				images:["https://lsmresort.com/wp-content/uploads/2024/06/LSM5_3bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM4_3bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM3_3bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM2_3bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM1_3bvillawplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/DSC04284-Enhanced-NR-scaled.jpg",
						"https://lsmresort.com/wp-content/uploads/2024/06/DSC04245-Enhanced-NR-scaled.jpg",
						"https://lsmresort.com/wp-content/uploads/2024/06/DSC01865-Enhanced-NR.jpg",
					   ]
			},{
				id:3,
				title:"Ocean-View 3 Bedroom Apartment with Plunge Pool",
				price:3978,
				images:["https://lsmresort.com/wp-content/uploads/2024/06/LSM8_3baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM7_3baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM6_3baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM5_3baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM2_3baptwplungepool.jpeg",
					   ]
			},{
				id:4,
				title:"Ocean-View 3 Bedroom Villa with Plunge Pool and Maids Quarters",
				price:4680,
				images:["https://lsmresort.com/wp-content/uploads/2024/06/LSM14_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM13_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM12_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM11_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM10_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM9_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM8_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM7_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM6_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM4_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM3_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM2_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM1_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM17_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM16_2baptwplungepool.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM15_2baptwplungepool.jpeg",
					   ]
			},{
				id:5,
				title:"Ocean-View 2 Bedroom Apartment with Balcony",
				price:2801,
				images:["https://lsmresort.com/wp-content/uploads/2024/06/LSM11_3baptwbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM10_3baptwbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM9_3baptwbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM5_3baptwbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM4_3baptwbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM3_3baptwbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM2_3baptwbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM1_3baptwbalcony.jpeg",
					   ]
			},{
				id:6,
				title:"Ocean-View 2 Bedroom Apartment with Plunge Pool",
				price:3627,
				images:["https://lsmresort.com/wp-content/uploads/2024/06/LSM10_2bwithbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM9_2bwithbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM8_2bwithbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM7_2bwbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM6_2bwithbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM5_2bwithbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM4_2bwithbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM3_2bwithbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM2_2bwithbalcony.jpeg",
						"https://lsmresort.com/wp-content/uploads/2024/06/LSM1_2bwithBalcony.jpeg",
					   ]
			},
		];

		props.forEach(function (prop) {
			var property = '<div class="prop-list-get-outside" data-type="' + prop.title + '" data-price="' + prop.price + '">';
			property += '<h3>' + prop.title + '</h3>';
			property += '<div class="slick-container">';
			prop.images.forEach(function (imageUrl) {
				var slickImage = '<div><img src="' + imageUrl + '" alt="Property Image"></div>';
				property += slickImage;
			}
							   );
			property += '</div>';
			// Close .slick-container
			property += '<div class="meta">';
			property += '<div class="prop-title-info-get">';
			property += '<p>To make a long-term reservation fill out this form.  Our team will be in touch with you shortly.</p>';
			property += '</div>';
			// Close .prop-title-info-get
			property += '<div class="learnmore"><p>Monthly price starting at $<span class="totalprice">' + prop.price + '</span></p><br><a class="booknow" href="#bookingform">BOOK MY STAY</a></div>';
			property += '</div>';
			// Close .meta
			property += '</div>';
			// Close .prop-list-get-outside
			output += property;
		}
					 );
		jQuery('#propertysearchresults').append(output);
		console.log("Sort the results by price");
		jQuery("#propertysearchresults > div").sort(sort_byprice).appendTo('#propertysearchresults');
		function sort_byprice(a, b) {
			return (jQuery(b).data('price')) < (jQuery(a).data('price')) ? 1 : -1;
		}
		jQuery('.slick-container').slick({
			arrows: true,
			dots: false,
			infinite: true,
			speed: 300,
			slidesToShow: 1,
			slidesToScroll: 1,
			prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-thin fa-angle-left' aria-hidden='true'></i></button>",
			nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa-thin fa-angle-right' aria-hidden='true'></i></button>",
			cssEase: 'ease-out',
			autoplay: true,
			autoplaySpeed: 5000,
			adaptiveHeight: true
		}
										);
	}

	var listsize = 0;
	var properties = 0;
	function generateListingGrid( proplist, arrivalDate, departureDate, type, people, isboutique=0 ) {
		
		if (!proplist.data[0].success || proplist.data[0].roomCount == 0) {
			var output = '<p> No listings were found. Please check your search selections including dates and number of people.</p>';
			jQuery('#loadingproperties').hide();
			jQuery('#propertysearchresults .loadingresults').hide();
			jQuery('#propertysearchresults').append(output);
			return false;
		}
						
		var rooms = proplist.data[0].data[0].propertyRooms;
		var propertyid = proplist.data[0].data[0].propertyID;
		var list = rooms;
        var proplink, totalprice, oldtotalprice, promoprice;
						
		for(p=0; p < list.length; p++) {
									
				totalprice = parseFloat(list[p].roomRate);
				oldtotalprice = parseFloat(list[p].roomRate);
				promoprice = parseFloat(list[p].promoRoomRate);
			
			var thumbnail = list[p].roomTypePhotos[0].image;
			var title = list[p].roomTypeName;
			var guests = list[p].maxGuests;
			var roomtype = list[p].roomTypeNameShort;
			var roomID = list[p].roomTypeID;
			var extraPersonFee = 0;
			var rateID = 0;
						
			if (list[p].rateID) {
				rateID = list[p].rateID;
			}
			
				// Extra people charge needs to be applied.			
				if (people > 6) {
					if (list[p].adultsExtraCharge) {
						extraPersonFee = list[p].adultsExtraCharge[people];
						totalprice = totalprice + extraPersonFee;
					}
				}
		
			if (promoprice) { totalprice = promoprice;  }
			if (isboutique == 1) { guests = 2; }
			
			if ( parseInt(people) <= parseInt(guests) ) {				
				if (arrivalDate) {
					proplink = '/single-property?pid=' + propertyid + '&rid=' + roomID + '&a=' + arrivalDate + '&d=' + departureDate + '&starting=' + totalprice + '&type=' + type + "&rateID=" + rateID;
				} else {
					proplink = '/single-property?pid=' + propertyid + '&rid=' + roomID + '&starting=' + totalprice + '&type=' + type + "&rateID=" + rateID;
				}
				
				var property = '<div class="prop-list-get-outside" data-type="'+roomtype+'" data-maxguests="'+guests+'" data-totalprice="'+totalprice+'">';
				property += '<div class="thumbnail"><img src="'+thumbnail+'" border="0" /></div>';
				property += '<div class="meta">';
				property += '<div class="prop-title-info-get">';
				property += '<h3>' + title + '</h3>';
				property += '<div class="infobar"><img src="/wp-content/uploads/2023/11/icono-personas-list.svg" data-toggle="tooltip" title="2 people" class="icono"> <span class="info-prop-get"> ' + guests + ' Guests</span> ' + '</div>';
				property += '</div>';
					if (promoprice) {
						property += '<div class="learnmore"><p>Promotional pricing of $<span class="promoprice">' + promoprice.toFixed(2) + ' $<span class="totalprice promopricing">'+oldtotalprice.toFixed(2) +'</span> </p> <br> <a href="' + proplink + '"> LEARN MORE </a></div>';
					} else {
						property += '<div class="learnmore"><p>Starting at $<span class="totalprice">'+totalprice+' USD </span> </p>';
						property += 'or <strong style="color:maroon">' + convertCurrency(totalprice).toFixed(2) + ' NIO</strong><br>';
						property += ' <br> <a href="' + proplink + '"> LEARN MORE </a></div>';
					}				
				property += '</div>';
				property += '</div>';
				property += '</div>';
												
				jQuery('#loadingproperties').hide();
				jQuery('#propertysearchresults').append(property);
			} else {
				// Number of guests checked did not pass
			}
		}
		jQuery('.prop-list-get-outside').click(function () {
			// Get the proplink associated with the clicked property
			var proplink = jQuery(this).find('.learnmore a').attr('href');
			// Navigate to the proplink
			window.location.href = proplink;
		});
	}

	var bhlistsize = 0;
	var bhproperties = 0;

	function generateListingGridBoutique( proplist, arrivalDate, departureDate, type, people ) {
		if (proplist.data[0].roomCount == 0) {
			var output = '<p> No listings were found. Please check your search selections including dates and number of people.</p>';
			jQuery('#propertysearchresults .loading').hide();
			jQuery('#propertysearchresults .loadingresults').hide();
			jQuery('#propertysearchresults').append(output);
			return false;
		}
		var rooms = proplist.data[0].data[0].propertyRooms;
		var propertyid = proplist.data[0].data[0].propertyID;
		var proplink;
		var list = rooms;

		for(p=0; p<list.length; p++) {
			var totalprice = parseFloat(list[p].roomRate);
			var thumbnail = list[p].roomTypePhotos[0].image;
			var title = list[p].roomTypeName;
			var guests = list[p].maxGuests;
			var roomtype = list[p].roomTypeNameShort;
			var roomID = list[p].roomTypeID;
			
			if (guests > 2) { continue; }
			
			if ( people <= guests ) {
				if (arrivalDate) {
					proplink = '/single-property?pid=' + propertyid + '&rid=' + roomID + '&a=' + arrivalDate + '&d=' + departureDate + '&starting=' + totalprice + '&type=' + type;
				}
				else {
					proplink = '/single-property?pid=' + propertyid + '&rid=' + roomID + '&starting=' + totalprice + '&type=' + type;
				}
				
				var property = '<div class="prop-list-get-outside" data-type="'+roomtype+'" data-maxguests="'+guests+'" data-totalprice="'+totalprice+'">';
				property += '<div class="thumbnail"><img src="'+thumbnail+'" border="0" /></div>';
				property += '<div class="meta">';
				property += '<div class="prop-title-info-get">';
				property += '<h3>' + title + '</h3>';
				property += '<div class="infobar"><img src="/wp-content/uploads/2023/11/icono-personas-list.svg" data-toggle="tooltip" title="2 people" class="icono"> <span class="info-prop-get"> ' + guests + ' Guests</span> ' + '</div>';
				property += '</div>';
						property += '<div class="learnmore"><p>Starting at $<span class="totalprice">'+totalprice+' USD </span> </p>';
						property += 'or <strong style="color:maroon">' + convertCurrency(totalprice).toFixed(2) + ' NIO</strong><br>';
						property += ' <br> <a href="' + proplink + '"> LEARN MORE </a></div>';
				property += '</div>';
				property += '</div>';
				property += '</div>';
				jQuery('#propertysearchresults').append(property);
			}
		}
		jQuery('.prop-list-get-outside').click(function () {
			// Get the proplink associated with the clicked property
			var proplink = jQuery(this).find('.learnmore a').attr('href');
			// Navigate to the proplink
			window.location.href = proplink;
		});
	}
