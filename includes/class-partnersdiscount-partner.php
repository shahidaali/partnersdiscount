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
class PartnersDiscount_Partner {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      PartnersDiscount_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $partner;


    /**
	 * Magic
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
    function __get($name) {
        if (isset($this->partner->{$name})) {
            return $this->partner->{$name};
        } else {
            return null;
        }
    }

    /**
	 * Magic
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
    public function __isset($name) {
        return isset($this->partner->{$name});
    }

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($partner) {
		if(is_numeric($partner)) {
			$partner = get_post($partner);
		}

		$this->partner = $partner;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_partner() {
		return $this->partner;
	}

	/**
	 * Retrieve the email
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_partner_email() {
		return get_field('partner_email', $this->partner->ID);;
	}

	/**
	 * Retrieve the email
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_partner_expiry() {
		return get_field('partner_expiry', $this->partner->ID);;
	}

	/**
	 * Retrieve the email
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function is_expired() {
		$today = date('Y-m-d');
		return strtotime($today) > strtotime($this->get_partner_expiry());
	}

	/**
	 * Retrieve the email
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_current_user() {
		$user = wp_get_current_user();
		return $user;
	}

	/**
	 * Retrieve the email
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function add_user_redemption($user) {

		$post_id = wp_insert_post([
			'post_type'    => PartnersDiscount_Utill::get_redemption_post_type_name(),
		    'post_status'  => 'publish',
			'post_title' => "Redemption by user #{$user->ID} of partner #{$this->partner->ID}",
		    'post_content'      => 'Redemption',
		    'meta_input'   => array(
		        '_user_id' => $user->ID,
		        '_partner_id' => $this->partner->ID,
		    )
		]);
		return $post_id;
	}

	/**
	 * Retrieve the email
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_user_redemption($user) {

		$args = array(
		    'posts_per_page'   => 1,
		    'post_type'        => PartnersDiscount_Utill::get_redemption_post_type_name(),
		    'meta_query' => array(
		       array(
		           'key' => '_user_id',
		           'value' => $user->ID,
		           'compare' => '=',
		       ),
		       array(
		           'key' => '_partner_id',
		           'value' => $this->partner->ID,
		           'compare' => '=',
		       )
		   )
		);
		$cc_query = new WP_Query( $args );
		return $cc_query->posts ? array_shift($cc_query->posts) : null;
	}

	/**
	 * Retrieve the email
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public static function get_redemptions($filters = []) {

		$args = array(
		    'posts_per_page'   => -1,
		    'post_type'        => PartnersDiscount_Utill::get_redemption_post_type_name(),
		);

		if(!empty($filters['partner_id'])) {
			$args['meta_query'][] = array(
	           'key' => '_partner_id',
	           'value' => $filters['partner_id'],
	           'compare' => '=',
	        );
		}

		$cc_query = new WP_Query( $args );
		return $cc_query;
	}

	/**
	 * Retrieve the email
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public static function get_partners($filters = []) {

		$args = array(
		    'post_type' => PartnersDiscount_Utill::get_post_type_name(),
		    'posts_per_page' => -1,
		    'post_status' => 'publish',
		    'orderby' => 'menu_order', 
		    'order' => 'DESC',
		);
		
		$cc_query = new WP_Query( $args );
		return $cc_query;
	}
}
