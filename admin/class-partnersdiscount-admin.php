<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    PartnersDiscount
 * @subpackage PartnersDiscount/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    PartnersDiscount
 * @subpackage PartnersDiscount/admin
 * @author     Devin Vinson <devinvinson@gmail.com>
 */
class PartnersDiscount_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in PartnersDiscount_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The PartnersDiscount_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/partnersdiscount-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in PartnersDiscount_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The PartnersDiscount_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/partnersdiscount-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register admin menu for plugin
	 *
	 * @since    1.0.0
	 */
	function admin_menu() {
		global $_wp_last_object_menu;
		$_wp_last_object_menu++;

		$slug = 'partnersdiscount';

		add_menu_page( 
	        __( 'Partners Discount Settings', 'partnersdiscount' ),
	        __( 'Partners Discount Settings', 'partnersdiscount' ),
	        'manage_options',
	        $slug,
	        array( $this, 'settings_page' ),
	        'dashicons-admin-settings',
	        6
	    ); 

		add_submenu_page( $slug,
			__( 'Redemptions', 'partnersdiscount' ),
			__( 'Redemptions', 'partnersdiscount' ),
			'manage_options', 
			'partnersdiscount-redemptions',
			array( $this, 'redemptions_page' ) 
		);

		// add_submenu_page( $slug,
		// 	__( 'Settings', 'partnersdiscount' ),
		// 	__( 'Setting', 'partnersdiscount' ),
		// 	'manage_options', 
		// 	$slug,
		// 	array( $this, 'settings_page' ) 
		// );
	}

	/**
	 * Register settings page
	 *
	 * @since    1.0.0
	 */
	function redemptions_page() {
		// Check for permission
		if ( ! current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		$partners = PartnersDiscount_Partner::get_partners();

	    include_once 'partials/redemptions.php';
	}

	/**
	 * Register settings page
	 *
	 * @since    1.0.0
	 */
	function settings_page() {
		// Check for permission
		if ( ! current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		// Save submitted form
	    $messages = $this->settings_page_save();

	    include_once 'partials/settings.php';
	}

	/**
	 * Register settings page
	 *
	 * @since    1.0.0
	 */
	function settings_page_save() {
		// Check for permission
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		if ( ! isset( $_POST['partnersdiscount_options'] ) ) {
	        return;
	    }

	    $old_options = PartnersDiscount_Utill::get_options();
	    $partnersdiscount_options = isset($_POST['partnersdiscount']) ? $_POST['partnersdiscount'] : [];

		$partnersdiscount_options = array_merge($old_options, $partnersdiscount_options);

	    // Update options
	    update_option( 'partnersdiscount_options',  $partnersdiscount_options );

	    PartnersDiscount_Utill::reset_options($partnersdiscount_options);

	    return [
	    	'status' => 'success',
	    	'message' => __( 'Settings saved' )
	    ];
	}
}
