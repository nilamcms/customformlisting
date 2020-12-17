/**
 * The js-specific functionality of the plugin.
 *
 * @link       https://github.com/nilamcms/customformlisting.git
 * @since      1.0.0
 *
 * @package    Custom_Form_Listing
 * @subpackage Custom_Form_Listing/public/js
 */

jQuery( document ).ready( function( $ ) {
	'use strict';

	// Localized variables.
	var ajaxurl = CFL_Public_JS_Vars.ajaxurl;
	
	/**
	 * Submit the form.
	 */
	$( document ).on( 'click', '#butsave', function() {
		var this_button = $( this );
		var full_name   = $( '#full_name' ).val();
		var email       = $( '#email' ).val();
		var phone       = $( '#phone' ).val();
		var email_regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		$( '#error' ).html( '' ).hide();

		// Check if the full name and email are valid strings.
		if ( -1 === is_valid_string( full_name ) || -1 === is_valid_string( email ) ) {
			$( '#error' ).html( 'Please fill all the field!' ).show();
			return false;
		}

		// Check the email for a valid format.
		if ( ! email_regex.test( email ) ) {
			$( '#error' ).html( 'Email format is improper.' ).show();
			return false;
		}

		// Block the button.
		this_button.attr( 'disabled', 'disabled' );

		// Process the ajax now.
		$.ajax( {
			url: ajaxurl,
			type: "POST",
			dataType   : 'json',
			data: {
				action: "create_custom_form",
				full_name: full_name,
				email: email,
				phone: phone
			},
			success: function(response){
				if (response == true) {

					$( "#success" ).show();
					$( '#success' ).html( 'Registration successful !' );
				} else if (response == false) {

					$( "#error" ).show();
					$( '#error' ).html( 'Email ID already exists !' );
				}
			}
		} );
	} );

	/**
	 * Check if a string is valid.
	 * 
	 * @param {string} data 
	 */
	function is_valid_string( data ) {
		if ( '' === data || undefined === data || ! isNaN( data ) || 0 === data ) {
			return -1;
		} else {
			return 1;
		}
	}
} );
