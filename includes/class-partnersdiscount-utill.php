<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    PartnersDiscount
 * @subpackage PartnersDiscount/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    PartnersDiscount
 * @subpackage PartnersDiscount/includes
 * @author     Devin Vinson <devinvinson@gmail.com>
 */
class PartnersDiscount_Utill {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      PartnersDiscount_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected static $options = [];

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      PartnersDiscount_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected static $post_type_name = "partners";

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      PartnersDiscount_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected static $redemption_post_type_name = "redemptions";

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      PartnersDiscount_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected static $taxonomy_name = "partners_cats";

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() { 

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function start_session() {
		if(!session_id()) {
			session_start();
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function get_post_type_name() {
		return self::$post_type_name;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function get_redemption_post_type_name() {
		return self::$redemption_post_type_name;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function get_taxonomy_name() {
		return self::$taxonomy_name;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function reset_options($options = []) {
		$options = $options ? $options : get_option('partnersdiscount_options', true);
		if(empty($options) || !is_array($options)) {
			$options = [];
		}

		self::$options = $options;
		return self::$options;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function get_options() {
		if( empty(self::$options) ) {
			self::reset_options();
		}

		return self::$options;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function get_option($name, $default = null) {
		$options = self::get_options();
		// echo '<pre>';
		// print_r($options);
		return self::get_data($options, $name, $default);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function get_session($key, $default = null) {
		$session = isset($_SESSION['partnersdiscount']) ? $_SESSION['partnersdiscount'] : [];
		return self::get_data($session, $key, $default);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function set_session($key, $value) {
		self::start_session();

		$_SESSION['partnersdiscount'][$key] = $value;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function reset_session() {
		self::start_session();

		$_SESSION['partnersdiscount'] = [];
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function plugin_url() {
		return PARTNERSDISCOUNT_PLUGIN_URL;
	}
	
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function get_data($data, $key, $default = null) {
		return isset($data[$key]) 
			? (is_string($data[$key]) ? wp_kses_post(stripslashes($data[$key])) : $data[$key]) 
			: $default;
	}
	
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function is_checked($value, $compare = 1) {
		return ($value == $compare) ? 'checked="checked"' : '';
	}
	
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public static function select_options($rows, $selected_option = null, $empty_lable = "", $use_key = true) {
		if( !is_array($rows) ) return;

	    $options = "";

	    // Selected value to array for multiple values
	    if($selected_option && !is_array($selected_option)) {
	        $selected_option = array($selected_option);
	    }

	    // Empty label
	    if( $empty_lable != "" ) {
	        $options .= "<option value=\"\">{$empty_lable}</option>";
	    }

	    // Creaye options from array
	    foreach ($rows as $key => $value) {
	        $value_item = ($use_key) ? $key : $value;
	        $selected = (!empty($selected_option) && in_array($value_item, $selected_option)) ? 'selected="selected"' : "";

	        $options .= "<option value=\"{$value_item}\" {$selected}>{$value}</option>";
	    }
	    return $options;
	}

	/**
	 * Check if partner expired
	 *
	 * @since    1.0.0
	 */
	public static function is_expired($partner_expiry) {
		$today = date('Y-m-d');
		return strtotime($today) > strtotime($partner_expiry);
	}

}
