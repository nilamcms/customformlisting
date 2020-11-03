/**
 * The js-specific functionality of the plugin.
 *
 * @link       https://github.com/nilamcms/Custom-Form-Listing.git
 * @since      1.0.0
 *
 * @package    Custom_Form_Listing
 * @subpackage Custom_Form_Listing/js
 */

(function( $ ) {
	'use strict';
	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(
		function() {
			$( '#butsave' ).on(
				'click',
				function() {
					$( "#butsave" ).attr( "disabled", "disabled" );
					var full_name   = $( '#full_name' ).val();
					var email       = $( '#email' ).val();
					var phone       = $( '#phone' ).val();
					var phoneverify = /^[0-9]{10}$/;
					var emailverify = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					if (full_name != "" && email != "" && phone != "") {
						if (phoneverify.test( phone )) {
							if (emailverify.test( email )) {
								$.ajax(
									{
										url: adminajax.ajaxurl,
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
									}
								);
							} else {
								$( "#error" ).show();
								$( '#error' ).html( 'Please enter valid email!' );
							}
						} else {
							$( "#error" ).show();
							$( '#error' ).html( 'Please enter valid phone number!' );
						}
					} else {
						$( "#error" ).show();
						$( '#error' ).html( 'Please fill all the field!' );
					}

				}
			);

		}
	);

})( jQuery );
