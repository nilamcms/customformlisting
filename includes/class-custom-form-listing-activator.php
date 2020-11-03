<?php
/**
 * Fired during plugin activation
 *
 * @link       https://github.com/nilamcms/customformlisting.git
 * @since      1.0.0
 *
 * @package    Custom_Form_Listing
 * @subpackage Custom_Form_Listing/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Custom_Form_Listing
 * @subpackage Custom_Form_Listing/includes
 * @author     Nilam Nainvani <nilam@cmsminds.com>
 */
class Custom_Form_Listing_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::add_custom_page();

	}
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function add_custom_page() {
		$body                 = array();
		$body['post_title']   = 'Contact';
		$body['post_status']  = 'publish';
		$body['post_content'] = '[customform]';
		$body['post_type']    = 'page';
		wp_insert_post( $body );
	}
}
