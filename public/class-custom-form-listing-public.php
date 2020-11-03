<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/nilamcms/customformlisting.git
 * @since      1.0.0
 *
 * @package    Custom_Form_Listing
 * @subpackage Custom_Form_Listing/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Custom_Form_Listing
 * @subpackage Custom_Form_Listing/public
 * @author     Nilam Nainvani <nilam@cmsminds.com>
 */
class Custom_Form_Listing_Public {

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
	 * @param    string $plugin_name The name of the plugin.
	 * @param    string $version   The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-form-listing-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-form-listing-public.css', array(), $this->version, 'all' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-form-listing-public.js', array( 'jquery' ), $this->version, false );
		wp_register_script( 'call-ajax-script', plugin_dir_url( __FILE__ ) . 'js/custom-form-listing-public.js', array( 'jquery' ) );
		wp_localize_script( 'call-ajax-script', 'adminajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( 'call-ajax-script' );

	}
	public function create_custom_form() {

		global $wpdb;

		$full_name = $_POST['full_name'];
		$email     = $_POST['email'];
		$phone     = $_POST['phone'];

		$sql = "SELECT * FROM `{$wpdb->prefix}formdata` WHERE email='" . $email . "'";

		$resultsr = $wpdb->get_results( $sql, OBJECT );

		if ( count( $resultsr ) > 0 ) {

			$response = false;

		} else {

			$wpdb->query( "INSERT INTO {$wpdb->prefix}formdata set full_name ='" . $full_name . "', email ='" . $email . "',phone_number ='" . $phone . "' " );

			$response = true;
		}

		echo json_encode( $response, true );
		wp_die();

	}

	public function create_shortcode( $attr = array(), $content = null ) {  ?>
			
	<div class="alert alert-success alert-dismissible" id="success" style="display:none;"></div>
	<div class="alert alert-danger alert-dismissible" id="error" style="display:none;"></div>
	<form id="register_form" name="form1" method="post">
	<div class="form-group">
		<label for="email">Full Name</label>
		<input type="text" class="form-control" id="full_name" placeholder="FullName" name="full_name">
	</div>
	<div class="form-group">
		<label for="pwd">Email</label>
		<input type="email" class="form-control" id="email" placeholder="Email" name="email">
	</div>
	<div class="form-group">
		<label for="pwd">Phone</label>
		<input type="text" class="form-control" id="phone" placeholder="Phone" name="phone">
	</div>
	<input type="button" name="save" class="btn btn-primary" value="Submit" id="butsave">
   </form>
		<?php
	}
}
