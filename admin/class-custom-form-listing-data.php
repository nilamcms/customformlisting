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
class Contactdata extends WP_List_Table {

	/**
	 * Data Array.
	 *
	 * @var $data
	 */
	private $data = array();

	/**
	 * Initiate Object of class.
	 */
	public static function run() {
		return new self();
	}

	/**
	 * Function for create initate object.
	 */
	public function __construct() {
		global $wpdb;

		$this->delete();

		$sql = "SELECT * FROM `{$wpdb->prefix}formdata`";

		$results = $wpdb->get_results( $sql, OBJECT );

		$data = array();

		foreach ( $results as $res ) {

			$data[] = array(
				'id'       => $res->id,
				'fullname' => $res->full_name,
				'email'    => $res->email,
				'phone'    => $res->phone_number,
			);
		}
		parent::__construct();
		$this->data = $data;
	}

	/**
	 * Get all Column Name.
	 */
	public function get_columns() {
		$columns = array(
			'cb'       => '<input type="checkbox" />',
			'id'       => 'ID',
			'fullname' => 'FullName',
			'email'    => 'Email',
			'phone'    => 'Phone',

		);
		return $columns;
	}

	/**
	 * Prepare Data for display.
	 */
	public function prepare_items() {
		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = $this->data;
		$per_page              = $this->get_items_per_page( 'data_per_page', 10 );
		$current_page          = $this->get_pagenum();
		$total_items           = count( $this->data );
		$data                  = array_slice( $this->data, ( ( $current_page - 1 ) * $per_page ), $per_page );
		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
			)
		);
		$this->found_data = $data;
		$this->items      = $data;
	}

	/**
	 * Set Default Column needs to show.
	 *
	 * @param array $item Array of column items.
	 * @param array $column_name Get column Name.
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'id':
			case 'fullname':
			case 'email':
			case 'phone':
				return $item[ $column_name ];
			default:
				return $item; // Show the whole array for troubleshooting purposes.
		}
	}

	/**
	 * Set Sortable column name.
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'fullname' => array( 'fullname', false ),
			'email'    => array( 'email', false ),
			'phone'    => array( 'phone', false ),

		);
		return $sortable_columns;
	}

	/**
	 * Get Column Name.
	 *
	 * @param array $item Get Delete action Column.
	 */
	public function column_name( $item ) {
		$page    = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
		$nonce   = wp_create_nonce( 'delete_contact' );
		$actions = array(
			'delete' => sprintf( '<a href="?page=%s&action=%s&record=%s">Delete</a>', $page, 'delete', $item['id'] ),
		);

		return sprintf( '%1$s %2$s', $item['name'], $this->row_actions( $actions ) );
	}

	/**
	 * Get all Actions.
	 */
	public function get_bulk_actions() {
		$actions = array(
			'delete' => 'Delete',
		);
		return $actions;
	}

	/**
	 * Column for checkbox.
	 *
	 * @param array $item Set Items.
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="record[]" value="%s" />',
			$item['id']
		);
	}

	/**
	 * Delete Functionality
	 */
	public function delete() {
		global $wpdb;
		$action     = ( ! empty( $_GET['action'] ) ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : '';
		$record_id  = ( ! empty( $_GET['record'] ) ) ? sanitize_text_field( wp_unslash( $_GET['record'] ) ) : '';
		$table_name = `{$wpdb->prefix}formdata`;
		if ( 'delete' === $action && ! empty( $record_id ) ) {
			if ( is_array( $record_id ) ) {
				foreach ( $record_id as $id ) {
					$wpdb->delete( $table_name, array( 'id' => $id ) );
				}
			} else {
				$wpdb->delete( $table_name, array( 'id' => $record_id ) );
			}
		}
	}
}
