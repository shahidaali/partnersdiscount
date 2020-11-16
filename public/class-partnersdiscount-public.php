<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    PartnersDiscount
 * @subpackage PartnersDiscount/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    PartnersDiscount
 * @subpackage PartnersDiscount/public
 * @author     Devin Vinson <devinvinson@gmail.com>
 */
class PartnersDiscount_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		PartnersDiscount_Utill::start_session();

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in PartnersDiscount_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The PartnersDiscount_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_style( 'partnersdiscount', plugin_dir_url( __FILE__ ) . 'css/partnersdiscount-public.css', array(), $this->version . "_" . rand(), 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_register_script( 'partnersdiscount', plugin_dir_url( __FILE__ ) . 'js/partnersdiscount-public.js', array(), $this->version . "_" . rand(), false );
		wp_localize_script( 'partnersdiscount', 'partnersdiscountOptions',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function body_class($classes) {

		global $post;

	    if( isset($post->post_content) && has_shortcode( $post->post_content, 'partnersdiscounts' ) ) {
	        $classes[] = 'partnersdiscount-page';
	    }
	    return $classes;

	}


	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the PartnersDiscount_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function register_post_type() {
		register_post_type( PartnersDiscount_Utill::get_post_type_name(), array(
			'labels' => array(
				'name' => __( 'Partners', 'partnersdiscount' ),
				'singular_name' => __( 'Partners', 'partnersdiscount' ),
			),
			'rewrite' => false,
			'query_var' => true,
			'public' => true,
			'capability_type' => 'post',
			'supports' => ['title', 'editor', 'thumbnail', 'excerpt']
		) );

		register_post_type( PartnersDiscount_Utill::get_redemption_post_type_name(), array(
			'labels' => array(
				'name' => __( 'Discounted', 'partnersdiscount' ),
				'singular_name' => __( 'Discounted', 'partnersdiscount' ),
			),
			'rewrite' => false,
			'query_var' => true,
			'public' => false,
			'capability_type' => 'post',
			'supports' => ['title']
		) );

		$labels = array(
		    'name' => _x( 'Partner Categories', 'taxonomy general name' ),
		    'singular_name' => _x( 'Partner Category', 'taxonomy singular name' ),
		    'search_items' =>  __( 'Search Categories' ),
		    'all_items' => __( 'All Categories' ),
		    'parent_item' => __( 'Parent Category' ),
		    'parent_item_colon' => __( 'Parent Category:' ),
		    'edit_item' => __( 'Edit Category' ), 
		    'update_item' => __( 'Update Category' ),
		    'add_new_item' => __( 'Add New Category' ),
		    'new_item_name' => __( 'New Category' ),
		    'menu_name' => __( 'Categories' ),
		);    
		 
		register_taxonomy(PartnersDiscount_Utill::get_taxonomy_name(), array(PartnersDiscount_Utill::get_post_type_name()), array(
		    'hierarchical' => true,
		    'labels' => $labels,
		    'show_ui' => true,
		    'show_in_rest' => true,
		    'show_admin_column' => true,
		    'query_var' => true,
		    'rewrite' => array( 'slug' => 'partners_category' ),
		));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function partnersdiscounts_shortcode($atts) {
		wp_enqueue_script('partnersdiscount');
		wp_enqueue_style('partnersdiscount');

		$atts = shortcode_atts([
			'button_text' => 'Redeem Benefits'
		], $atts);

		extract($atts);

		$arr_posts = PartnersDiscount_Partner::get_partners();;

		$terms = get_terms( array(
		    'taxonomy' => PartnersDiscount_Utill::get_taxonomy_name(),
		    'hide_empty' => false,
		) );


		ob_start();
		include_once 'partials/shortcode.php';
		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function partnersdiscount_ajax() {
		$json_data = [
			'status' => 'error',
			'message' => 'Nothing to process',
			'data' => []
		];

		$request_type = !empty($_REQUEST['request_type']) ? $_REQUEST['request_type'] : "";

		if($request_type == "redeem_discount") {
			$partner_id = !empty($_REQUEST['partner_id']) ? $_REQUEST['partner_id'] : 0;
			$partner = new PartnersDiscount_Partner($partner_id);

			if( $partner ) {

				$user = $partner->get_current_user();

				if(! $user->ID ) {
			        $json_data = [
						'status' => 'error',
						'message' => 'User not logged in.',
						'data' => []
					];
			    } else if( $partner->get_user_redemption($user) ) {
			        $json_data = [
						'status' => 'error',
						'message' => 'You already redeemed this partner benefits.',
						'data' => []
					];
			    } else if( $partner->is_expired($partner_expiry) ) {
			        $json_data = [
						'status' => 'error',
						'message' => 'Partner expired.',
						'data' => []
					];
			    } else if($this->save_user_redemption($user, $partner)) {
			    	$json_data = [
						'status' => 'success',
						'message' => __('Benefits redeemed'),
						'data' => []
					];
			    }
			    else {
					$json_data = [
						'status' => 'error',
						'message' => __('Error sending emails.'),
						'data' => []
					];
				}
			} else {
				$json_data = [
					'status' => 'success',
					'message' => 'Partner not found.',
					'data' => []
				];
			}
		}

		$json_data['data']['request'] = $_REQUEST;

		header('Content-Type: application/json');
		echo json_encode($json_data);
		exit();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function save_user_redemption($user, $partner) {
		$post_id = $partner->add_user_redemption($user);

		if( !is_wp_error($post_id) ) {
			return $this->send_emails($user, $partner);
		}

		return false;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function send_emails($user, $partner) {
		$client_emmail_status = true;
		$partner_emmail_status = true;
		$admin_emmail_status = true;

		if(PartnersDiscount_Utill::get_option('enable_customer_email', 'yes') == 'yes') {
			$client_emmail_status = $this->send_client_email($user, $partner);
		}
		if(PartnersDiscount_Utill::get_option('enable_partner_email', 'yes') == 'yes') {
			$partner_emmail_status = $this->send_partner_email($user, $partner);
		}
		if(PartnersDiscount_Utill::get_option('enable_admin_email', 'yes') == 'yes') {
			$admin_emmail_status = $this->send_admin_email($user, $partner);
		}

		if( $client_emmail_status && $partner_emmail_status && $admin_emmail_status ) {
			return true;
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function send_client_email($user, $partn) {

		$client_email_subject = $this->filter_tokens(PartnersDiscount_Utill::get_option('client_email_subject', ''), $user, $partner);
		$client_email_template = $this->filter_tokens(wpautop(PartnersDiscount_Utill::get_option('client_email_template', '')), $user, $partner);
		
		$to = $user->user_email;
		$subject = $client_email_subject;
		$body = $client_email_template;
		$headers = array('Content-Type: text/html; charset=UTF-8;');
		 
		$email_status = wp_mail( $to, $subject, $body, $headers );

		if( $email_status ) {
			return true;
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function send_partner_email($user, $partner) {
		$partner_email = $partner->get_partner_email();

		$partner_email_subject = $this->filter_tokens(PartnersDiscount_Utill::get_option('partner_email_subject', ''), $user, $partner);
		$partner_email_template = $this->filter_tokens(wpautop(PartnersDiscount_Utill::get_option('partner_email_template', '')), $user, $partner);

		$to = $partner_email;
		$subject = $partner_email_subject;
		$body = $partner_email_template;
		$headers = array('Content-Type: text/html; charset=UTF-8;');
		 
		$email_status = wp_mail( $to, $subject, $body, $headers );

		if( $email_status ) {
			return true;
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function send_admin_email($user, $partner) {
		$admin_email = explode(",", PartnersDiscount_Utill::get_option('admin_email', ''));
		$admin_email = array_map("trim", $admin_email);

		if(empty($admin_email)) {
			return false;
		}

		$admin_email_subject = $this->filter_tokens(PartnersDiscount_Utill::get_option('admin_email_subject', ''), $user, $partner);
		$admin_email_template = $this->filter_tokens(wpautop(PartnersDiscount_Utill::get_option('admin_email_template', '')), $user, $partner);

		$to = $admin_email[0];
		$subject = $admin_email_subject;
		$body = $admin_email_template;
		$headers = array('Content-Type: text/html; charset=UTF-8;');
		 
		$email_status = wp_mail( $to, $subject, $body, $headers );

		if( $email_status ) {
			return true;
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function filter_tokens($content, $user, $partner) {
		$name = ($user->user_firstname) ? $current_user->user_firstname . " " . $user->user_lastname : $user->display_name;
		$user_id = $user->ID;
		$membership_code = get_user_meta($user_id, "connectpx_member_code", true);

		$tokens = [
			'[PARTNER_NAME]' => $partner->post_title,
			'[PARTNER_EXPIRY_DATE]' => $partner->get_partner_expiry(),
			'[PARTNER_EMAIL]' => $partner->get_partner_email(),
			'[TODAY_DATE]' => date('Y-m-d'),
			'[USER_NAME]' => $name,
			'[USER_ID]' => $user_id,
			'[USER_MEMBERSHIP_CODE]' => $membership_code,
		];
		
		$content = str_replace(array_keys($tokens), array_values($tokens), $content);
		return $content;
	}
}
