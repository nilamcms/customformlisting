<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/nilamcms/customformlisting.git
 * @since             1.0.0
 * @package           Custom_Form_Listing
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Form Listing
 * Plugin URI:        https://github.com/nilamcms/customformlisting.git
 * Description:       This plugin purpose is that it will provide a custom form and it is generate automatically create a page and its integrate with a shortcode in page  after you can check that page in frontend. When you form submit the value store in database and you can also see entry backend.
 * Version:           1.0.0
 * Author:            Nilam Nainvani
 * Author URI:        https://github.com/nilamcms/customformlisting.git
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-form-listing
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CUSTOM_FORM_LISTING_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom-form-listing-activator.php
 */
function activate_custom_form_listing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-form-listing-activator.php';
	Custom_Form_Listing_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom-form-listing-deactivator.php
 */
function deactivate_custom_form_listing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-form-listing-deactivator.php';
	Custom_Form_Listing_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_custom_form_listing' );
register_deactivation_hook( __FILE__, 'deactivate_custom_form_listing' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custom-form-listing.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
require plugin_dir_path( __FILE__ ) . 'admin/class-custom-form-listing-data.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_form_listing() {

	$plugin = new Custom_Form_Listing();
	$plugin->run();

}
run_custom_form_listing();
