function validate_cvv(cvv) {
    var isValid = /^[0-9]{3,4}$/.test(cvv);
    if (!isValid) {
        alert("Invalid CVV number");
        $('#cvv').val("");
        return false;
    }
    return true;
}

jQuery(document).ready(function($) {
   
   $('#confirmbooking').on('click', function() {
       
           var ccresult = JSON.parse(sessionStorage.getItem('ccresult'));       
           var buttonid = $(this).data('id');

           $.ajax({
                       type: "GET",
                       url: "/wp-admin/admin-ajax.php",
                       dataType: "json",
                       data: {							
                           action: 'process_payment',
                           spitoken: ccresult[0].token,
                       },
                       success: function (output) {							                           
                            if (!output.data[0].Approved) {
                                window.location.href = "/payment-error";
                                return false;
                            } else {
                               createReservation( );	
                               return false;
                            }
                       },
                       complete: function (data) {
                           window.dataLayer = window.dataLayer || [];
                           window.dataLayer.push({ 
                               'event': 'purchase', 
                               'boton_id': buttonid 
                           });
                       },
                       error: function (xhr, ajaxOptions, thrownError) {
                               var errormessage = '<div class="errormessage"> There was an error in booking your reservation. <br>';
                                   errormessage += '<p>' + thrownError + '</p></div>';
                       },
               });	
   });
   
   $('#guestypaymentform #card_number').on('change', function() {
               
       if ( $(this).val().length < 14 ) { return false; }
       
           var result = $('#card_number').validateCreditCard({ accept: ['visa', 'mastercard','discover'] });
           
           if (!result.valid) {
               alert(" Card is not valid ");
               $('#card_number').val("").addClass('invalid');
           } else {
               $('#card_number').removeClass('invalid');
           }
   });
   
   $('#cvv').on('change', function() {
       if ( $(this).val().length > 2 ) {
           validate_cvv($(this).val());
       }
   });
   
   $('#cart-expyear').on('change', function() {
       if ( $(this).val().length >= 2 ) {
           var today = new Date();
           var expDate = new Date(20 + $("#cart-expyear").val(),($("#cart-expmonth").val()-1)); // JS Date Month is 0-11 not 1-12 grrr
           
           if(today.getTime() > expDate.getTime()) {
               $('#cart-expyear').val("");
               $('#cart-expmonth').val("");
               alert("Your Card is expired. Please check expiry date.");
           }
       }
   });
   
   $('body').on('click', '.booknow', function() {
       $.magnificPopup.open({
         items: {
           src: '#bookingform', 
           type: 'inline',
           showCloseBtn: true,
           closeBtnInside: true
         },
       });
   });

   $('#close').click( function() { $.magnificPopup.close(); });
   
   if ( $('#searchform') ) {
       var numppl = sessionStorage.getItem('numberpeople');
       $('#numberpeople').val(numppl);
   };
   
   if ( $('body').hasClass('home') ) {
       $('#numberpeople').val(2);
   };
   
   $('#steptwosummary .double u').on('click', function() {
       $('#detailblock').slideToggle();
   });
   
   $('#numberpeople').on('click', function() {
       var numguests = $(this).val();
       $('#propertysearchresults .prop-list-get-outside').each(function() {

           var numberofguests = $(this).data('maxguests');
           sessionStorage.setItem('numberpeople', numguests);

           if (numguests <= numberofguests) {
               $(this).show();
           } else {
               $(this).hide();
           }
       });	
       
       var propcnt = 0;
        $('#propertysearchresults .prop-list-get-outside').each(function() {
               if ( $(this).css('display') != 'none' )	 {
                   propcnt++;
               }
        });
       
       jQuery('.numberresults span').html( propcnt );

   });

   $('.filterby input').on('click', function() {
           filters=0;
       
           // Store selections in session storage
           storeSelectedCheckboxes();					
       
           $('#propertysearchresults .prop-list-get-outside').hide();

           $('.filterby input').each(function() {
               var isChecked = $(this).is(':checked');
               
               if (isChecked && $(this).hasClass('numberpeople')) {
                   var numguests = $(this).val();
                   $('#propertysearchresults .prop-list-get-outside').each(function() {
                       
                       var numberofguests = $(this).data('maxguests');                       
                       if (numberofguests == numguests) {
                           $(this).show();
                       }
                   });	
                   filters++;
               }
           });
           if (filters==0) { $('#propertysearchresults .prop-list-get-outside').show() }
   });
   
   var sortorder = "highest";
       $('#searchtoolbar .sortbyprice .fa-sort-down').show();
       $('#searchtoolbar .sortbyprice .fa-sort-up').hide();

   $('#searchtoolbar .sortbyprice').on('click', function() {
   
       if (sortorder == "highest") {
           $("#propertysearchresults > div").sort(sort_low).appendTo('#propertysearchresults');
             function sort_low(a, b) {
               return ($(b).data('totalprice')) < ($(a).data('totalprice')) ? 1 : -1;
             }
           sortorder="lowest";
               $('#searchtoolbar .sortbyprice .fa-sort-down').hide();
               $('#searchtoolbar .sortbyprice .fa-sort-up').show();

       } else {
           $("#propertysearchresults > div").sort(sort_high).appendTo('#propertysearchresults');

           function sort_high(a, b) {
               return ($(b).data('totalprice')) > ($(a).data('totalprice')) ? 1 : -1;
             }
           sortorder="highest";
           $('#searchtoolbar .sortbyprice .fa-sort-down').show();
           $('#searchtoolbar .sortbyprice .fa-sort-up').hide();
       }
       
       return;
   });
   
    /***************************************************/
    /*  Booking Flow specific pages                    */
    /***************************************************/   
    /* We only want to trigger calls on specific pages */
    /* Booking page                                    */
    /***************************************************/
   $('#guestform').on('submit', function(e) {
       e.preventDefault();
       
       var inputValues = [];
       
       // Get all of the input values
       $('#guestform input').each(function() {
           var fieldid = $(this).attr('id');
           var value = $(this).val();
           inputValues[fieldid] = value;
       });		
       
       var myJSON = JSON.stringify(inputValues);
       
       $('#guestform select').each(function() {
           var fieldid = $(this).attr('id');
           var value = $('option:selected', this).val();
           inputValues[fieldid] = value;
       });		
       
           $.ajax({
                       type: "GET",
                       url: "/wp-admin/admin-ajax.php",
                       dataType: "json",
                       data: {
                           action: 'handle_guest',
                           // pass guest form values as array
                           first_name: inputValues['name'],
                           last_name: inputValues['family_name'],
                           zip: inputValues['postal_code'],
                           email: inputValues['email_address'],
                           phone: inputValues['cellphone'],
                           country: inputValues['country'].toLowerCase(),
                           roomTypeID: sessionStorage.getItem("propertyid"),
                           number_adults: sessionStorage.getItem('numberguests'),
                       },
                       success: function (output) {	
                           if (output.success) {
                               sessionStorage.setItem('guestfirstname', inputValues['name']);
                               sessionStorage.setItem('guestlastname', inputValues['family_name']);
                               sessionStorage.setItem('guestzip', inputValues['postal_code']);
                               sessionStorage.setItem('guestemail', inputValues['email_address']);
                               sessionStorage.setItem('guestcity', inputValues['City']);
                               sessionStorage.setItem('guestcell', inputValues['cellphone']);
                               sessionStorage.setItem('guestcountry', inputValues['country']);
                               sessionStorage.setItem('address_line_1', inputValues['address']);
                           }
                       },
                       complete: function (data) {
                           $('#bookingwrapper #steptwo').hide();
                           $('#bookingwrapper #stepthree').show();
                           
                            $('html, body').animate({
                               scrollTop: $("#av_section_1").offset().top
                           }, 2000);
                           
                       },
                       error: function (xhr, ajaxOptions, thrownError) {
                               var errormessage = '<div class="errormessage"> There was an error in booking your reservation. <br>';
                                   errormessage += '<p>' + thrownError + '</p></div>';
                       }                               
               });	
   });
   
   // Cloudbeds version of payment form
   $('#submitpayment').on('click', function() {
       
       var inputValues = [];
       var buttonid = $(this).data('id');
       
       // Get all of the input values
       $('#ccform input').each(function() {
           var fieldid = $(this).attr('id');
           var value = $(this).val();
           inputValues[fieldid] = value;
       });		
                       
       var totalchargeamount = sessionStorage.getItem('totalamounttocharge');

            //      This is for when I need to test.
            //      totalchargeamount = 1.00;
            //	    sessionStorage.setItem('totalamounttocharge', 1.00);
            //      Remember to use this for LIVE:  sessionStorage.getItem('totalpricing');

           $.ajax({
                       type: "GET",
                       url: "/wp-admin/admin-ajax.php",
                       dataType: "json",
                       data: {							
                           action: 'create_payment_token',
                           card_name: inputValues['name_on_card'],
                           card_number: inputValues['card_number'],
                           exp_date: inputValues['cart-expmonth'] + "/" + inputValues['cart-expyear'],
                           ccv: inputValues['cvv'],
                           totalamt: totalchargeamount,
                           first_name: sessionStorage.getItem('guestfirstname'),
                           last_name:  sessionStorage.getItem('guestlastname'),
                           zip:  sessionStorage.getItem('guestzip'),
                           email:  sessionStorage.getItem('guestemail'),
                           phone:  sessionStorage.getItem('guestcell'),
                           address_line_1:  sessionStorage.getItem('address_line_1'),
                           city: sessionStorage.getItem('guestcity'),
                       },
                       success: function (output) {							
                           sessionStorage.setItem("ccresult", JSON.stringify(output.data));
                           sessionStorage.setItem("transid", JSON.stringify(output.data[0].response.TransactionIdentifier));
                       },
                       complete: function (data) {
                           window.dataLayer = window.dataLayer || [];
                            window.dataLayer.push({ 
                               'event': 'begin_checkout', 
                               'boton_id': buttonid 
                           });
                           
                           var isocode = data.responseJSON.data[0].response.IsoResponseCode;
                               window.location.href = '/confirm-payment/';
                           return false;
                       },
                       error: function (xhr, ajaxOptions, thrownError) {
                               var errormessage = '<div class="errormessage"> There was an error in booking your reservation. <br>';
                                   errormessage += '<p>' + thrownError + '</p></div>';
                       },
               });	

           return false;
   });

   
   if ( $('body').hasClass('page-id-1289') ) {
        // If this is the thank you page, capture payment
       capturePayment();
   }
   
   // Finalize booking page
   if ( $('body').hasClass('page-id-1289') || $('body').hasClass('page-id-1871')) {
        // use #bookingdetails
       populateBookingDetails(); 
   }
   
    if ( $('body').hasClass('page-id-1869')) {
        var ccresult = JSON.parse(sessionStorage.getItem('ccresult'));
        var redirectdata = ccresult[0].RedirectData;
        var iframe = document.getElementById('finalizepayment');
            iframe.srcdoc = redirectdata;
    }
   
   // Booking Page
   if ( $('body').hasClass('page-id-1252')) {
       var propertyid = $.urlParam('pid');
           sessionStorage.setItem('propertyid', propertyid);
       var startDate = $.urlParam('start_date');
       var endDate = $.urlParam('end_date');
       var rateID = $.urlParam('rateID');

       if (propertyid) {
                   
           $('#bookingwrapper > div').hide();
           $('#rightsidesummary > div').hide();

           // Depending on the availability, show or hide calendar (0 - some days not available, 1 = no issues)
           if (sessionStorage.getItem('availability') > 0) {
               $('#bookingwrapper #steptwo').show();
               $('#rightsidesummary #steptwosummary').show();					
               
               // Populate the fields
               $('.propertyname').text( sessionStorage.getItem('propertyname'));
               $('.upperbox .arrivaldate').text( sessionStorage.getItem('arrivaldate'));
               $('.upperbox .departuredate').text( sessionStorage.getItem('departuredate'));
               $('.upperbox .numberofnights').text( sessionStorage.getItem('totalnights'));
               $('.upperbox .numberofguests').text( sessionStorage.getItem('numberguests'));
               $('.upperbox .numberofrooms').text( sessionStorage.getItem('numrooms'));

               $('#pid').val(propertyid);
               
               // Need to get room and tax rates
                   var totalprice = sessionStorage.getItem('totalpricing');
               
                   $('#numberadults').val( sessionStorage.getItem('numberguests') );
               
               // Google Tag Manager - Add to Cart
                window.dataLayer = window.dataLayer || [];
                   window.dataLayer.push({
                     event: 'add_to_cart',
                     ecommerce: {
                       items: [{
                          item_name:  sessionStorage.getItem('propertyname'),
                         item_id: propertyid,
                         price: sessionStorage.getItem('totalamounttocharge'),
                         item_brand: 'lsm',
                         item_category: 'short-term',
                         quantity: '1'
                       }]
                     }
                   });
           } else {				
                // Not available so we show the calendar
                $('#bookingwrapper #stepone').show();
                $('#rightsidesummary #steponesummary').show();
                $('.previewimage').css("background-image", "url(" + sessionStorage.getItem('propthumb') + ")");
                $('.lowerbox .propertyname').text( sessionStorage.getItem('propertyname'));
                $('#bookArrivalDate').datepicker({
                    minDate: convertDateFormat(startDate),
                    altField: "#bookingstart",
                    altFormat: "yy-mm-dd"
                });
                $('#bookDepartureDate').datepicker({
                    minDate: convertDateFormat(endDate),
                    altField: "#bookingend",
                    altFormat: "yy-mm-dd"
                });
                $('#pid').val(propertyid);
           }			
                       
       } else {
           // @todo - redirect to short-term page
       }
   }
   
   // Single Property View page
   if ( $('body').hasClass('page-id-1166')) {
       
       sessionStorage.setItem('availability', 1);

       var propertyid = $.urlParam('pid');
       var roomid = $.urlParam('rid');
       var arrival = $.urlParam('a');
       var departure = $.urlParam('d');
       var referer = document.referrer;
       var startingprice = $.urlParam('starting');
       var itemtype = $.urlParam('type');
       var extraPersonFee = $.urlParam('extrapersonfee');
       var numberPeopleForm = $.urlParam('numberPeople');
       var rateID = $.urlParam('rateID');
       
           $('.backtolink').attr("href", referer);
       
       // Make sure we don't have any HTML encoded strings
       var decodeArrival = decodeURIComponent(arrival);
       var decodeDeparture = decodeURIComponent(departure);
       
       if (!decodeArrival.includes("/")) {
           var convertedarrival = convertDateFormat(decodeArrival);
           var converteddeparture = convertDateFormat(decodeDeparture);
           var formattedarrival = decodeArrival;
           var formatteddeparture = decodeDeparture;
       } else {
           var convertedarrival = decodeArrival;
           var converteddeparture = decodeDeparture;
           var formattedarrival = parseDate(decodeArrival);
           var formatteddeparture = parseDate(decodeDeparture);
       }
       
           $('#bookingarrivaldate').val(convertedarrival);
           $('#bookingdeparturedate').val(converteddeparture);       
           $('.rentaldetails .arrival').text(formattedarrival);
           $('.rentaldetails .departure').text(formatteddeparture);
           $('#startdate').val(formattedarrival);
           $('#enddate').val(formatteddeparture);
       
       var numdays = datediff(parseDate(formattedarrival), parseDate(formatteddeparture));
           sessionStorage.setItem('propertyid', propertyid);
       getPropertyDetails(roomid, formattedarrival, formatteddeparture, numdays, extraPersonFee, startingprice);  // Populate property details
           sessionStorage.setItem('roomid', roomid);
       var numrooms = sessionStorage.getItem('numrooms');
           if (!numrooms) { 
               numrooms = 1; 
               sessionStorage.setItem('numrooms', 1);
           }
           sessionStorage.setItem('rateid', rateID);

       var numberpeople;
       
       if (sessionStorage.getItem("isBoutique")) {
           $('#numberpeople').hide();
           numberpeople = 2;
       } else {
           numberpeople = $('#numberpeople').val();
       }
           $('.rentaldetails .numbernights').text(numdays + ' nights');
           $('.rentaldetails .numberrooms').text(numrooms + ' units(s)');

       var capacity  = sessionStorage.getItem('capacity');
                       sessionStorage.setItem('propertyrate', startingprice);

           if (numberPeopleForm) { 
               if (numberPeopleForm <= capacity) { 
                   $('.rentaldetails .guests').text(numberPeopleForm);
                   sessionStorage.setItem('numberguests', numberPeopleForm);
                   $('#numberpeople').val(numberPeopleForm);
               } else {
                   alert("The number of people selected exceeds the property capacity.  Please make a new selection.");
                   var numppl = sessionStorage.getItem('numberpeople');
                   $('#numberpeople').val(numppl);
               }
           } else {
       
               $('.rentaldetails .guests').text(numberpeople);
               sessionStorage.setItem('numberguests', numberpeople);
           }

       
         window.dataLayer = window.dataLayer || [];
           window.dataLayer.push({
             event: 'view_item',
             ecommerce: {
               items: [{
                          item_name:  sessionStorage.getItem('propertyname'),
                         item_id: propertyid,
                         price: sessionStorage.getItem('totalpricing'),
                         item_brand: 'lsm',
                         item_category: 'short-term',
                         quantity: '1'
                       }]
             }
           });
   }
   
   // Trigger if we hit the short or long term accomodations page
   if ( $('body').hasClass('page-id-1874') || $('body').hasClass('page-id-1924') || $('body').hasClass('page-id-1970') ) {
       
           var isBoutique = 0;
       
           if ($('body').hasClass('page-id-1924')) { 
               isBoutique = 1; 
               sessionStorage.setItem('isBoutique', 1);
           } else {
               sessionStorage.removeItem('isBoutique');
           }
       
           sessionStorage.setItem('availability', 1);
       
           // Set the default of 2 whenever they arrive to page.  It can be changed on this page or on individual page.
           if (!sessionStorage.getItem("numberpeople")) {
               sessionStorage.setItem('numberpeople', 2);
           }

       // Check if arrival date was passed
       if ($.urlParam('arrivalDate')) {
           
           var arrivalParam = decodeURIComponent($.urlParam('arrivalDate'));
           var departureParam = decodeURIComponent($.urlParam('departureDate'));		
               arrival = parseDate(arrivalParam);
               departure = parseDate(departureParam);
           var people = $.urlParam('numberPeople');
           var numbeds = Math.ceil(people/2);
           var numrooms = 1;
               sessionStorage.setItem('numrooms', numrooms);

           // Need to update the search box
           $('#numberpeople').val(people);
               sessionStorage.setItem('numberpeople', people);

           var $datepicker = $('#arrivaldate');
               $datepicker.datepicker();
               $datepicker.datepicker('setDate', arrivalParam);
           var $datepickerD = $('#departuredate');
               $datepickerD.datepicker();
               $datepickerD.datepicker('setDate', departureParam);
                      
           jQuery.ajax({
                   type: "GET",
                   url: "/wp-admin/admin-ajax.php",
                   dataType: "json",
                   data: {
                       action: 'get_property_listings',
                       // add your parameters here (bedrooms, arrival, departure);
                       number_people: people,
                       arrival_date: arrival,
                       departure_date: departure,
                       num_rooms: numrooms,
                   },
                   success: function (output) {
                       // Parse results 
                       if (isBoutique == 1) {
                           generateListingGridBoutique(output, arrival, departure, 'short-term', 2);		
                       } else {
                           generateListingGrid(output, arrival, departure, 'short-term', people);		
                       }
                       jQuery('#loadingproperties').hide();

                   },
                   complete: function (data) {
                        var numberprops = jQuery('#propertysearchresults .prop-list-get-outside').length;
                        jQuery('.numberresults span').html( numberprops );
                        jQuery('#loadingproperties').hide();
                        if (numberprops > 0) {
                            jQuery('#loadingproperties').hide();
                            jQuery('#propertysearchresults .loadingresults').hide();
                        
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
                                        });	
                                        filters++;
                                    }
                                });
                                if (filters==0) { jQuery('#propertysearchresults .prop-list-get-outside').show() }
                            }, 2000);
                        }
                    },  // End of complete
                   error: function (xhr, ajaxOptions, thrownError) {
                       var errormessage = '<div class="errormessage"> There was an error in retrieving properties.  No dates were selected. <br>';
                           errormessage += '<p>' + thrownError + '</p></div>';
                       $('#errormessage').html(errormessage);
                   }
           });	
       } else {
           sessionStorage.setItem('availability', 1);
           
           var today = new Date();
           var tomorrow = new Date();
           var people = sessionStorage.getItem('numberpeople');
           
               if (isBoutique == 1) { people = 2; }

               today.setDate(today.getDate() + 1);
               tomorrow.setDate(tomorrow.getDate() + 2);
           
               if (today.getMonth()+1 < 10) {
                    arrival = today.getFullYear() + "-0" + (today.getMonth()+1) + "-" + ('0' + today.getDate()).slice(-2);
                    departure = tomorrow.getFullYear() + "-0" + (tomorrow.getMonth()+1) + "-" + ('0' + tomorrow.getDate()).slice(-2);
               } else {
                    arrival = today.getFullYear() + "-" + (today.getMonth()+1) + "-" + ('0' + today.getDate()).slice(-2);
                    departure = tomorrow.getFullYear() + "-" + (tomorrow.getMonth()+1) + "-" + ('0' + tomorrow.getDate()).slice(-2);
               }
           
           // Set the form defaults
           $('#arrivaldate').val(convertDateFormat(arrival));
           $('#departuredate').val(convertDateFormat(departure));
           $('#numberpeople').val(people);
           
           jQuery.ajax({
                   type: "GET",
                   url: "/wp-admin/admin-ajax.php",
                   dataType: "json",
                   data: {
                       action: 'get_property_listings',
                       // add your parameters here (bedrooms, arrival, departure);
                       number_people: 1,
                       arrival_date: arrival,
                       departure_date: departure,
                       num_people: people,
                       num_rooms: 1
                   },
                   success: function (output) {
                       // Parse results 
                       if (isBoutique == 1) {
                           generateListingGridBoutique(output, arrival, departure, 'short-term', 2);		
                       } else {
                           generateListingGrid(output, arrival, departure, 'short-term', people, 0);		
                       }
                   },
               complete: function (data) {                   
                   var numberprops = jQuery('#propertysearchresults .prop-list-get-outside').length;
                       jQuery('.numberresults span').html( numberprops );

                   if (numberprops > 0) {
                       jQuery('#propertysearchresults .loading').hide();
                       jQuery('#propertysearchresults .loadingresults').hide();
                   
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
                                   });	
                                   filters++;
                               }
                           });
                           if (filters==0) { jQuery('#propertysearchresults .prop-list-get-outside').show() }
                       }, 2000);
                       
                   }
                } // End of complete
           });	
       }
       
       // Search button click
       $('#searchlistings, #searchboutique').on('click', function() {
           
           var arrival = $('#arrivaldate').val();
           var departure = $('#departuredate').val();
           var people = $('#numberpeople').val();
           var numrooms = $('#numberrooms').val();
               if (!numrooms) { numrooms = 1; }

               sessionStorage.setItem('numberpeople', people);
               sessionStorage.setItem('numrooms', numrooms);

           var promocode = $('#promocode').val();
               console.log(promocode);
               sessionStorage.setItem('promocode', promocode);
           var actionname = "get_property_listings";
               $('#propertysearchresults').html('');

           if (arrival && departure) { 

               listsize = 0;
               arrival = parseDate(arrival);
               departure = parseDate(departure);

           var numbeds = Math.ceil(people/2);
       
               jQuery.ajax({
                   type: "GET",
                   url: "/wp-admin/admin-ajax.php",
                   dataType: "json",
                   data: {
                       action: actionname,
                       // add your parameters here (bedrooms, arrival, departure);
                       number_people: 1,
                       arrival_date: arrival,
                       departure_date: departure,
                       num_people: people,
                       promo_code: promocode, // We pass this even if blank
                       num_rooms: numrooms,
                   },
                   success: function (output) {
                       // Parse results 
                       if (isBoutique == 1) {
                           generateListingGridBoutique(output, arrival, departure, 'short-term', 2);		
                       } else {
                           generateListingGrid(output, arrival, departure, 'short-term', people, 0);		
                       }					
                   },
               complete: function (data) {
                   
                   console.log(" Completed ");
                   
                   var numberprops = jQuery('#propertysearchresults .prop-list-get-outside').length;
                       jQuery('.numberresults span').html( numberprops );

                   if (numberprops > 0) {
                       jQuery('#propertysearchresults .loading').hide();
                       jQuery('#propertysearchresults .loadingresults').hide();
                   
                       // Run our bed sort now that we have all available properties
                       jQuery("#propertysearchresults > div").sort(sort_bybed).appendTo('#propertysearchresults');
                       function sort_bybed(a, b) {
                           return (jQuery(b).data('maxguests')) < (jQuery(a).data('maxguests')) ? 1 : -1;
                       }
                   }
                       
                } // End of complete
           });	
           
       
           } else {
               $('#propertysearchresults').html('<h3> No dates were selected in the search box.</h3>');
           }
       });
   }

   // Long Term Accomodations page

   if (  $('body').hasClass('page-id-393') ) {
       
       // Check if params were passed
       var arrival = $.urlParam('arrivalDate');
       var depature = $.urlParam('departureDate');
       var people = $.urlParam('numberPeople');
       var numbeds = people/2;
                               
       if (arrival) {
           console.log("Submitted from form");
           
           jQuery.ajax({
               type: "GET",
               url: "/wp-admin/admin-ajax.php",
               dataType: "json",
               data: {
                   action: 'get_property_listings',
                   // add your parameters here (bedrooms, arrival, departure);
                   number_bedrooms: numbeds,
                   arrival_date: arrival,
                   departure_date: departure,
               },
               success: function (output) {	
                   jQuery('#propertysearchresults .loading').hide();
                   jQuery('#propertysearchresults .loadingresults').hide();
                   // Parse and display results 
                   //generateLongTermGrid(output, arrival, departure, 'long-term', numbeds);
                   generateLongTermGrid();
                       
               }
           });	
           
       } else {
           jQuery('#propertysearchresults .loading').hide();
                   jQuery('#propertysearchresults .loadingresults').hide();
           generateLongTermGrid();
       }
   }
});



