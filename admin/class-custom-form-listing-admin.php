<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/nilamcms/customformlisting.git
 * @since      1.0.0
 *
 * @package    Custom_Form_Listing
 * @subpackage Custom_Form_Listing/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Custom_Form_Listing
 * @subpackage Custom_Form_Listing/admin
 * @author     Nilam Nainvani <nilam@cmsminds.com>
 */
class Custom_Form_Listing_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}
	/**
	 * Register the JavaScript and styles for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_Form_Listing_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Form_Listing_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-form-listing-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-form-listing-admin.css', array(), $this->version, 'all' );
	}
	/**
	 * Create a Custom table in database
	 *
	 * @since    1.0.0
	 */
	public function create_custom_table() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nn_Custom_Form_Listing_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nn_Custom_Form_Listing_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		global $wpdb;
		$table_name = $wpdb->prefix . 'formdata';
		$sql        = 'CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
		        id  int(9) NOT NULL AUTO_INCREMENT,
		        full_name varchar(55) NOT NULL,
		        email varchar(55) NOT NULL,
		        phone_number varchar(55) NOT NULL,
		        PRIMARY KEY(id)
		        );';
		$wpdb->query( $sql );

	}
	/**
	 * Register Menus.
	 */
	public function custom_register_menu() {
		add_menu_page(
			'Contact Lists',
			'Contact Lists',
			'manage_options',
			'contact_form',
			array( $this, 'custom_render_menu_page' )
		);

	}

	/**
	 * Render Page For Contact DB Menu.
	 */
	public function custom_render_menu_page() {
		$data = new Contactdata();
		$page = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
		echo '<div class="wrap"><h2>Contact Lists</h2>';
		echo '<form id="contact_form" action="" method="get">';
		echo '<input type="hidden" name="page" value="' . esc_attr( $page ) . '" />';
		$data->prepare_items();
		$data->display();
		echo '</form>';
		echo '</div>';
	}

}
