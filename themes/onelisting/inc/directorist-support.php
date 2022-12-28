<?php
/**
 *
 * @author  WpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

use Directorist\Directorist_Listings;
use Directorist\Directorist_Listing_Dashboard;
use Directorist\Directorist_Listing_Form;
use Directorist\Directorist_Listing_Taxonomy;
use Directorist\Directorist_Single_Listing;
use Directorist\Helper;
use wpWax\OneListing\Helper as OneListingHelper;

class Directorist_Support {
	use Directorist_Taxonomy_Custom_Fields;

	protected static $instance = null;
	public static $searchform;
	public static $listing_DB;
	public static $listings_options;
	public static $price_currency_symbol;

	public function __construct() {

		$this->directorist_taxonomy_custom_fields_init();

		// Adds & Modified Builder Settings Fields
		add_filter( 'atbdp_listing_type_settings_field_list', array( $this, 'atbdp_listing_type_settings_field_list' ) );

		// Adds Similar Listings Submenu: Builder-> Single Page Layout-> Other Settings
		add_filter( 'directorist_builder_layouts', array( $this, 'directorist_builder_layouts' ) );
		// Adds and Modified: Builder-> Single Page Layout -> Listing Header
		add_filter( 'directorist_listing_header_layout', array( $this, 'directorist_listing_header_layout' ) );
		// Adds New Sections: Builder-> Single Page Layout-> Contents
		add_filter( 'atbdp_single_listing_other_fields_widget', array( $this, 'atbdp_single_listing_other_fields_widget' ) );
		add_filter( 'atbdp_single_listing_content_widgets', array( $this, 'atbdp_single_listing_content_widgets' ) );
		
		// Add User signup & login Modal to header
		add_action( 'wp_body_open', array( $this, 'header_login_modal' ) );

		// Listing with Map
		add_filter( 'bdmv_view_as', array( $this, 'bdmv_view_as' ) );
		add_filter( 'atbdp_listings_with_map_header_sort_by_button', array( $this, 'atbdp_listings_with_map_header_sort_by_button' ) );
		// Map Header Title by JS
		add_action( 'wp_ajax_onelisting_map_header_title', array( $this, 'wp_ajax_onelisting_map_header_title' ) );
		add_action( 'wp_ajax_nopriv_onelisting_map_header_title', array( $this, 'wp_ajax_onelisting_map_header_title' ) );

		// All Listings Ajax
		add_action( 'wp_ajax_onelisting_archive_listings', array( $this, 'wp_ajax_nopriv_onelisting_archive_listings' ) );
		add_action( 'wp_ajax_nopriv_onelisting_archive_listings', array( $this, 'wp_ajax_nopriv_onelisting_archive_listings' ) );

		// Adds and Modified Add Listing Form
		add_filter( 'atbdp_form_preset_widgets', array( $this, 'atbdp_form_preset_widgets' ) );
		add_filter( 'atbdp_submission_form_settings', array( $this, 'atbdp_submission_form_settings' ) );
		add_action( 'directorist_before_add_listing_from_frontend', array( $this, 'directorist_before_add_listing_from_frontend' ) );
		add_filter( 'atbdp_form_custom_widgets', array( $this, 'atbdp_form_custom_widgets' ) );

		// Add Listing Popup Login
		add_filter( 'atbdp_listing_form_login_link', array( $this, 'atbdp_listing_form_login_link' ) );
		add_filter( 'atbdp_listing_form_signup_link', array( $this, 'atbdp_listing_form_signup_link' ) );

		// If view as list then don't execute
		if( 'list' != get_directorist_option('display_locations_as') ) {
			// Modified the query $args for All Locations
			add_filter( 'atbdp_all_locations_argument', array( $this, 'atbdp_all_locations_argument' ) );
		}
		// Add Title in Taxonomy Page
		add_action( 'atbdp_before_all_categories_loop', array( $this, 'taxonomy_title' ) );
		add_action( 'atbdp_before_all_locations_loop', array( $this, 'taxonomy_title' ) );
		add_action( 'atbdp_category_image_size', array( $this, 'atbdp_category_image_size' ) );
		add_action( 'atbdp_location_image_size', array( $this, 'atbdp_location_image_size' ) );

		// Unique Classes are Added Based on Directorist Template
		add_filter( 'body_class', array( $this, 'body_classes' ) );

		// Header Search Popup
		add_action( 'wp_body_open', array( $this, 'header_search_popup' ), 100 );

		// Enqueue scripts for Builder
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		// Removing the 'directorist-inline-style' to prevent CSS conflict
		add_filter( 'directorist_load_inline_style', '__return_false' );

		// Unset Option Value
		add_action( 'directorist_option', array( $this, 'directorist_option' ), 10, 2 );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function atbdp_listing_type_settings_field_list( $fields ) {

		// Adds & Modified Grid & List View
		foreach ( $fields as $key => $value ) {

			if ( 'listings_card_grid_view' == $key ) {
				array_push( $fields[$key]['card_templates']['grid_view_with_thumbnail']['layout']['thumbnail']['bottom_left']['acceptedWidgets'],
					'pricing' );

				if ( class_exists( 'BD_Business_Hour' ) ) {
					array_push( $fields[$key]['card_templates']['grid_view_with_thumbnail']['layout']['footer']['right']['acceptedWidgets'],
						'open_close_badge' );
					array_push( $fields[$key]['card_templates']['grid_view_without_thumbnail']['layout']['footer']['right']['acceptedWidgets'],
						'open_close_badge' );
				}
			}

			if ( 'listings_card_list_view' == $key ) {
				array_push( $fields[$key]['card_templates']['list_view_with_thumbnail']['layout']['footer']['right']['acceptedWidgets'],
					'pricing' );

				if ( class_exists( 'BD_Business_Hour' ) ) {
					array_push( $fields[$key]['card_templates']['list_view_without_thumbnail']['layout']['footer']['right']['acceptedWidgets'],
						'open_close_badge' );
				}
			}

		}

		// Adds Pricing Plan Listing Type Section Settings
		if ( class_exists( 'ATBDP_Pricing_Plans' ) ) {
			$fields['enable_onelisting_listing_type'] = array(
				'label' => __( 'Show Listing Type Section at Top', 'onelisting' ),
				'type'  => 'toggle',
				'name'  => 'enable_onelisting_listing_type',
				'value' => true,
			);

			$fields['onelisting_choose_listing_type_label'] = array(
				'type'  => 'text',
				'name'  => 'general_label',
				'label' => esc_html__( 'Section Title', 'onelisting' ),
				'value' => esc_html__( 'Choose listing type', 'onelisting' ),

			);
			$fields['onelisting_general_label'] = array(
				'type'  => 'text',
				'name'  => 'general_label',
				'label' => esc_html__( 'General listing label', 'onelisting' ),
				'value' => esc_html__( 'Regular listing', 'onelisting' ),

			);
			$fields['onelisting_featured_label'] = array(
				'type'  => 'text',
				'name'  => 'featured_label',
				'label' => esc_html__( 'Featured listing label', 'onelisting' ),
				'value' => esc_html__( 'Featured listing', 'onelisting' ),

			);
		}

		// Add sSimilar Listings Section at Bottom of the Single Listing Page
		$fields['show_similar_listings'] = array(
			'type'      => 'toggle',
			'label'     => __( 'OneListing: Similar Listings at Bottom', 'onelisting' ),
			'labelType' => 'h3',
			'value'     => true,
		);
		$fields['similar_listings_label'] = array(
			'type'    => 'text',
			'name'    => 'featured_label',
			'label'   => esc_html__( 'Section Title', 'onelisting' ),
			'value'   => esc_html__( 'Similar Properties', 'onelisting' ),
			'show_if' => array(
				'where'      => "show_similar_listings",
				'conditions' => array(
					array( 'key' => 'value', 'compare' => '=', 'value' => true ),
				),
			),

		);

		// Unset the 'Popular Categories Title'
		unset( $fields['popular_cat_title'] );

		return $fields;
	}

	public function directorist_builder_layouts( $settings ) {
		foreach ( $settings as $key => $value ) {
			if ( 'single_page_layout' === $key ) {
				if ( isset( $value['submenu']['similar_listings'] ) ) {
					array_push( $settings[$key]['submenu']['similar_listings']['sections']['other']['fields'], 'show_similar_listings' );
					array_push( $settings[$key]['submenu']['similar_listings']['sections']['other']['fields'], 'similar_listings_label' );
				}
			}
		}

		return $settings;
	}

	public function directorist_listing_header_layout( $fields ) {

		if ( class_exists( 'BD_Business_Hour' ) ) {
			$fields['widgets']['open_close_badge'] = array(
				'type'  => "button",
				'label' => esc_html__( "Open/Close", "onelisting" ),
				'icon'  => 'uil uil-text-fields',
			);

			array_push( $fields['layout']['listings_header']['quick_info']['acceptedWidgets'],
				'open_close_badge' );
		}

		// Add Listing Title in General Area
		$fields['card-options']['general']['listing_title'] = array(
			'type'    => "title",
			'label'   => __( "Listing Title", "onelisting" ),
			'options' => array(
				'title'  => __( "Listing Title Settings", "onelisting" ),
				'fields' => array(
					'enable_title' => array(
						'type'  => "toggle",
						'label' => __( "Show Title", "onelisting" ),
						'value' => true,
					),
				),
			),
		);

		// Remove Unused Fields
		unset( $fields['card-options']['content_settings']['listing_description'] );
		unset( $fields['card-options']['content_settings']['listing_title'] );
		unset( $fields['card-options']['general']['section_title'] );
		unset( $fields['widgets']['listing_slider']['options'] );

		$listing_type_id = isset ( $_REQUEST['listing_type_id'] ) ? $_REQUEST['listing_type_id'] : '';
		$single_listing_enabled = get_directorist_type_option( $listing_type_id, 'enable_single_listing_page' );
		
		if ( ! $single_listing_enabled ) {
			unset( $fields['card-options']['general']['back'] );
		}
		
		return $fields;
	}

	public function atbdp_single_listing_other_fields_widget( $fields ) {

		$fields['onelisting_description'] = array(
			'type'    => 'section',
			'label'   => esc_html__( 'OneListing: Description', 'onelisting' ),
			'icon'    => 'uil uil-text-fields',
			'options' => array(
				'label'                => array(
					'type'  => 'text',
					'label' => esc_html__( 'Label', 'onelisting' ),
					'value' => 'Description',
				),
				'custom_block_id'      => array(
					'type'  => 'text',
					'label' => esc_html__( 'Custom block ID', 'onelisting' ),
					'value' => '',
				),
				'custom_block_classes' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Custom block Classes', 'onelisting' ),
					'value' => '',
				),
			),
		);

		return $fields;
	}

	public function atbdp_single_listing_content_widgets( $fields ) {
		$fields['onelisting_feature_list'] = array(
			'options' => array(
				'icon' => array(
					'type'  => 'icon',
					'label' => esc_html__( 'Icon', 'onelisting' ),
					'value' => 'las la-list',
				),
			),
		);

		return $fields;
	}

	public function header_login_modal() {
		return OneListingHelper::get_template_part( 'directorist/custom/content-header-login-modal' );
	}

	public function bdmv_view_as( $html ) {
		$html = OneListingHelper::get_template_part( 'directorist/custom/sort-map' );
		$html .= OneListingHelper::get_template_part( 'directorist/custom/view-mode-map' );

		return $html;
	}

	public function atbdp_listings_with_map_header_sort_by_button( $html ) {
		return;
	}

	public function wp_ajax_onelisting_map_header_title() {
		$post_id = isset( $_POST['post_id'] ) ? esc_attr( $_POST['post_id'] ) : get_the_ID();
		$js_data = isset( $_POST['form'] ) ? $_POST['form'] : '';
		echo self::get_header_title( $post_id, $js_data );
		wp_die();
	}

	public function wp_ajax_nopriv_onelisting_archive_listings() {
		$type = isset( $_POST['type'] ) ? esc_attr( $_POST['type'] ) : null;
		$atts = isset( $_POST['atts'] ) ? $_POST['atts'] : array();

		$atts['directory_type']   = $type;
		$listings                 = new Directorist_Listings( $atts, 'listing' );
		$listings->directory_type = $type;

		$view          = isset( $atts['view'] ) ? sanitize_text_field( $atts['view'] ) : 'grid';
		$template_file = "archive/{$view}-view";

		Helper::get_template( $template_file, array( 'listings' => $listings ) );

		wp_die();
	}

	public function atbdp_form_preset_widgets( $fields ) {
		// Removed unused field
		unset( $fields['tagline'] );

		return $fields;
	}

	public function atbdp_submission_form_settings( $settings ) {

		// Adds Pricing Plan Listing Type Section Settings
		if ( class_exists( 'ATBDP_Pricing_Plans' ) ) {
			$settings['onelisting_listing_type'] = array(
				'title'     => __( 'OneListing: Pricing Plan Listing Type', 'onelisting' ),
				'container' => 'short-width',
				'fields'    => array(
					'enable_onelisting_listing_type',
					'onelisting_choose_listing_type_label',
					'onelisting_general_label',
					'onelisting_featured_label',
				),
			);
		}

		return $settings;
	}

	public function directorist_before_add_listing_from_frontend() {

		// Add Pricing Plan Listing Type Section Markup
		if ( ! class_exists( 'ATBDP_Pricing_Plans' ) ) {
			return;
		}

		if ( strpos( $_SERVER['REQUEST_URI'], 'edit' ) ) {
			return;
		}

		OneListingHelper::get_template_part( 'directorist/custom/add-listing_listing_type', $this->get_add_listing_settings_data( Directorist_Listing_Form::instance()->current_listing_type ) );
	}

	public function atbdp_form_custom_widgets( $fields ) {
		$custom_field_meta_key_field = apply_filters( 'directorist_custom_field_meta_key_field_args', array(
			'type'  => 'hidden',
			'label' => esc_html__( 'Key', 'onelisting' ),
			'value' => 'custom-text',
			'rules' => array(
				'unique'   => true,
				'required' => true,
			),
		) );

		$fields['onelisting_feature_list'] = array(
			'label'   => 'OneListing: Feature List',
			'icon'    => 'las la-list',
			'options' => array(
				'type'        => array(
					'type'  => 'hidden',
					'value' => 'textarea',
				),
				'label'       => array(
					'type'  => 'text',
					'label' => esc_html__( 'Label', 'onelisting' ),
					'value' => 'Feature List',
				),
				'field_key'   => array_merge( $custom_field_meta_key_field, array(
					'value' => 'custom-feature-list',
				) ),
				'rows'        => array(
					'type'  => 'number',
					'label' => esc_html__( 'Rows', 'onelisting' ),
					'value' => 8,
				),
				'placeholder' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Placeholder', 'onelisting' ),
					'value' => esc_html__( 'ex: Air Conditioning', 'onelisting' ),
				),
				'description' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Description', 'onelisting' ),
					'value' => esc_html__( 'Each new line will print a feature', 'onelisting' ),
				),
				'required'    => array(
					'type'  => 'toggle',
					'label' => esc_html__( 'Required', 'onelisting' ),
					'value' => false,
				),
			),

		);

		return $fields;
	}

	public function atbdp_listing_form_login_link() {
		return __( '<a href="#" data-bs-toggle="modal" data-bs-target="#theme-login-modal">Here</a>', 'onelisting' );
	}

	public function atbdp_listing_form_signup_link() {
		return __( '<a href="#" data-bs-toggle="modal" data-bs-target="#theme-register-modal">Sign Up</a>', 'onelisting' );
	}

	public function atbdp_all_locations_argument( $args ) {

		// If Locations don't have any parent
		foreach ( $args as $key => $value ) {
			if ( 'parent' === $key ) {
				$args[$key] = '';
			}
		}

		return $args;
	}

	public function taxonomy_title() {
		if ( ! is_page() ) {
			return;
		}
		if ( get_the_ID() == get_directorist_option( 'all_categories_page' ) || get_the_ID() == get_directorist_option( 'single_category_page' ) || get_the_ID() == get_directorist_option( 'all_locations_page' ) || get_the_ID() == get_directorist_option( 'single_location_page' ) || get_the_ID() == get_directorist_option( 'single_tag_page' ) ) {
			printf( '<h2 class="directorist-archive-title">%s</h2>', self::get_header_title( get_the_ID() ) );
		}
	}

	public function atbdp_category_image_size() {
		return 'wpwaxtheme-476x340';
	}

	public function atbdp_location_image_size() {
		return 'wpwaxtheme-260x300';
	}

	public function body_classes( $classes ) {

		$listing = Directorist_Single_Listing::instance();

		$page_list = array(
			'home',
			'search-result',
			'add-listing',
			'all-listing',
			'dashboard',
			'author',
			'category',
			'single_category',
			'all_locations',
			'single_location',
			'single_tag',
			'registration',
			'login',
		);

		foreach ( $page_list as $page ) {

			if ( atbdp_is_page( $page ) ) {
				$classes[] = "theme-dir-{$page}";
			}

		}

		if ( is_singular( 'at_biz_dir' ) && $listing->single_page_enabled() ) {
			$classes[] = "custom_single_listing";
		}

		if ( is_single() && 'at_biz_dir' == get_post_type() ) {
			$classes[] = "theme-dir-single_listing";
		}

		if ( class_exists( 'BD_Map_View' ) && atbdp_is_page( 'all-listing' ) ) {
			$is_lwm_active = strpos( get_the_content(), 'listings_with_map' );
			$classes[]     = ( $is_lwm_active ) ? 'dir-listings_with_map' : '';
		}



		return $classes;
	}

	public function header_search_popup() {
		if ( ! atbdp_is_page( 'add_listing' ) && Theme::$options['header_search'] ) {
			OneListingHelper::get_template_part( 'directorist/custom/popup-search' );
		}
	}

	public function admin_enqueue_scripts() {

		if ( isset( $_REQUEST['page'] ) && 'atbdp-directory-types' != $_REQUEST['page'] ) {
			return;
		}

		// Removed the Image Slider from Single Listing Header
		$css = '.cptm-card-preview-widget {
			display: grid;
		}

		.cptm-title-bar {grid-row: 2;}';

		$listing_type_id = isset ( $_REQUEST['listing_type_id'] ) ? $_REQUEST['listing_type_id'] : '';
		$single_listing_enabled = get_directorist_type_option( $listing_type_id, 'enable_single_listing_page' );
		
		if ( ! $single_listing_enabled ) {					
			wp_add_inline_style( 'directorist-admin-style', $css );			
		}		
	}

	public function directorist_option( $v, $name ) {

		// Unset Popular Category Title
		if ( 'popular_cat_title' === $name ) {
			$v = '';
		}

		return $v;
	}

	/*====================
	// Helper Functions //
	====================*/

	// Symbol for Dashboard-> Bookmarks
	public static function get_currency_symbol() {
		$currency = atbdp_get_payment_currency();

		return atbdp_currency_symbol( $currency );
	}

	// Member Joined Text for Author Page
	public static function get_member_joined_text( $author_id ) {
		$user_registered = get_the_author_meta( 'user_registered', $author_id );
		$date            = date( 'M Y', strtotime( $user_registered ) );

		return sprintf( '%s %s', __( 'Joined in', 'onelisting' ), $date );
	}

	// Ratings HTML for Author Page
	public static function get_rating_stars_html( $avg_rating ) {

		$avg_rating = round( $avg_rating, 1 );

		ob_start();?>

		<ul class="ratings" data-rating="<?php echo $avg_rating; ?>">
			<li class="rating__item"></li>
			<li class="rating__item"></li>
			<li class="rating__item"></li>
			<li class="rating__item"></li>
			<li class="rating__item"></li>
		</ul>

		<?php echo ob_get_clean();
	}

	// Author $args for Author
	public static function get_author_args( $author ) {
		$author_id = $author->id;
		$bio       = get_user_meta( $author_id, 'description', true );
		$bio       = trim( $bio );

		$display_email = get_directorist_option( 'display_author_email', 'public' );

		if ( $display_email == 'public' ) {
			$email_endabled = true;
		} elseif ( $display_email == 'logged_in' && is_user_logged_in() ) {
			$email_endabled = true;
		} else {
			$email_endabled = false;
		}

		$args = array(
			'author'         => $author,
			'bio'            => nl2br( $bio ),
			'address'        => get_user_meta( $author_id, 'address', true ),
			'phone'          => get_user_meta( $author_id, 'atbdp_phone', true ),
			'email_endabled' => $email_endabled,
			'email'          => get_the_author_meta( 'user_email', $author_id ),
			'website'        => get_the_author_meta( 'user_url', $author_id ),
			'facebook'       => get_user_meta( $author_id, 'atbdp_facebook', true ),
			'twitter'        => get_user_meta( $author_id, 'atbdp_twitter', true ),
			'linkedin'       => get_user_meta( $author_id, 'atbdp_linkedin', true ),
			'youtube'        => get_user_meta( $author_id, 'atbdp_youtube', true ),
		);

		return $args;
	}

	// Header Title for All Listings, Search Results & Listings with Map
	public static function get_header_title( $post_id, $js_data = '' ) {
		$data = array();

		if ( $js_data && ! empty( $js_data ) ) {
			parse_str( $js_data, $data );
		} else if ( $_GET ) {
			$data = $_GET;
		} else if ( $_POST ) {
			$data = $_POST;
		}

		$string  = ( isset( $data['q'] ) && ! empty( $data['q'] ) ) ? $data['q'] : '';
		$address = ( isset( $data['address'] ) && ! empty( $data['address'] ) ) ? $data['address'] : '';
		$in_cat  = ( isset( $data['in_cat'] ) && ! empty( $data['in_cat'] ) ) ? $data['in_cat'] : '';

		if ( ! $data ) {
			return get_the_title( $post_id );
		} else if ( ! empty( $address ) ) {

			if ( ! empty( $string ) ) {
				return sprintf( __( '%s <span>in</span> %s', 'onelisting' ), $string, $address );
			} else {
				return $address;
			}
		} else if ( ! empty( $in_cat ) ) {
			$term = get_term( $in_cat );

			if ( ! empty( $string ) ) {
				return sprintf( __( '%s <span>at</span> %s', 'onelisting' ), $string, $term->name );
			} else {
				return $term->name;
			}
		} else if ( ! empty( $string ) ) {
			return sprintf( __( 'Search results <span>for</span> %s', 'onelisting' ), $string );
		} else {
			return get_the_title( $post_id );
		}
	}

	// Show Custom Title in these pages
	public static function show_title( $post_id ) {
		$pages = array(
			'all_listing_page',
			'search_result_page',
			'single_category_page',
			'single_location_page',
			'single_tag_page',
		);

		foreach ( $pages as $key => $page ) {
			if ( $post_id == get_directorist_option( $page ) ) {
				return true;
			}
		}

		return false;
	}

	// Remove Brackets
	public static function remove_bracket( $count_html, $only_int = false ) {
		$count_html = str_replace( array( '(', ')' ), array( '' ), $count_html );

		if ( $only_int ) {
			$count_html = strip_tags( $count_html );
		}

		return $count_html;
	}

	// If terms has parent
	public static function has_parent_name( $term ) {

		if ( is_array( $term ) && 0 != $term['term']->parent ) {
			$term_obj = get_term( $term['term']->parent );

			return $term_obj->name;
		} else if ( is_object( $term ) && $term->parent ) {
			$term_obj = get_term( $term->parent );

			return $term_obj->name;
		}

		return false;
	}

	// Single Listing Header
	public static function get_single_listing_header( $listing ) {
		return get_term_meta( $listing->type, 'single_listing_header', true );
	}

	// Rating Reviews HTML
	public static function get_rating_reviews_html( $post_id ) {
		$reviews_count = ATBDP()->review->db->count( array( 'post_id' => $post_id ) );
		$avg_rating    = ATBDP()->review->get_average( $post_id );
		$review_text   = (  ( $reviews_count > 1 ) || ( $reviews_count === 0 ) ) ? __( 'reviews', 'onelisting' ) : __( 'review', 'onelisting' );

		printf( '<div class="directorist-review-meta"><span class="directorist-rating-avg">%s %s </span>%s %s</div>', directorist_icon( 'fas fa-star', false ), $avg_rating, $reviews_count, $review_text );
	}

	// Dashboard Navigation for Header Avatar
	public static function get_dashboard_navigation() {
		$data['dashboard'] = Directorist_Listing_Dashboard::instance();

		return OneListingHelper::get_template_part( '/directorist/custom/header-dashboard-navigation', $data );
	}

	// Taxonomy Custom Template Args for Elementor All Categories-> Grid View -> Style 2
	public static function get_taxonomy_data( $atts ) {
		$taxonomy = new Directorist_Listing_Taxonomy( $atts );

		$args = array(
			'taxonomy'   => $taxonomy,
			'categories' => $taxonomy->tax_data(),
			'columns'    => $taxonomy->columns,
		);

		return $args;
	}

	// Add Listing Settings Data for Pricing Plan
	public function get_add_listing_settings_data( $dir_id ) {
		$enable_onelisting_listing_type       = get_term_meta( $dir_id, 'enable_onelisting_listing_type' );
		$onelisting_choose_listing_type_label = get_term_meta( $dir_id, 'onelisting_choose_listing_type_label' );
		$onelisting_general_label             = get_term_meta( $dir_id, 'onelisting_general_label' );
		$onelisting_featured_label            = get_term_meta( $dir_id, 'onelisting_featured_label' );

		return array(
			'current_listing_type'                 => $dir_id,
			'enable_onelisting_listing_type'       => isset( $enable_onelisting_listing_type[0] ) ? $enable_onelisting_listing_type[0] : 1,
			'onelisting_choose_listing_type_label' => isset( $onelisting_choose_listing_type_label[0] ) ? $onelisting_choose_listing_type_label[0] : esc_html__( 'Choose listing type', 'onelisting' ),
			'onelisting_general_label'             => isset( $onelisting_general_label[0] ) ? $onelisting_general_label[0] : esc_html__( 'Regular listing', 'onelisting' ),
			'onelisting_featured_label'            => isset( $onelisting_featured_label[0] ) ? $onelisting_featured_label[0] : esc_html__( 'Featured listing', 'onelisting' ),
		);
	}

	// Get View Mode 'active' class by $_POST & $object
	public static function get_map_view_mode( $object, $mode ) {

		if ( isset( $_POST['view_as'] ) ) {
			$view_as = isset( $_POST['view_as'] ) ? $_POST['view_as'] : '';

			return ( $mode == $view_as ) ? "active" : '';
		}

		foreach ( $object->options as $key => $value ) {
			if ( 'listing_map_view' == $key ) {
				if ( $mode == $value ) {
					return 'active';
				}
			}
		}
	}

	// Get Sort Placeholder by $_Post & Object
	public static function get_map_sort_default_title( $post_data = array(), $listings ) {

		$best_match = esc_html__( 'Best match', 'onelisting' );

		if ( empty( $post_data ) ) {
			return $best_match;
		}

		foreach ( $post_data as $key => $value ) {
			if ( 'sort_by' == $key ) {
				foreach ( $listings->get_sort_by_link_list() as $_key => $_value ) {
					if ( $_value['key'] == $value ) {
						return ! empty( $_value['label'] ) ? $_value['label'] : $best_match;
					}
				}
			}
		}

		return $best_match;
	}

	// Get Listings Options
	public static function get_listings_options() {
		if ( ! self::$listings_options ) {
			self::$listings_options = new Directorist_Listings;
		}

		return self::$listings_options;
	}

	// Categories Icons to Pass by Localize
	public static function get_categories_icon() {
		$terms = get_terms( array(
			'taxonomy' => ATBDP_CATEGORY,
			'hide_empty' => false,
		) );

		$id_icon_list = array();
		foreach ( $terms as $term ) {
			$icon                         = get_term_meta( $term->term_id, 'category_icon', true );
			$id_icon_list[$term->term_id] = Helper::get_icon_src( $icon );
		}

		return $id_icon_list;
	}

	// Categories Colors to Pass by Localize
	public static function get_categories_color() {
		$terms = get_terms( array(
			'taxonomy' => ATBDP_CATEGORY,
			'hide_empty' => false,
		) );

		$id_color_list = array();
		foreach ( $terms as $term ) {
			$color                         = get_term_meta( $term->term_id, 'onelisting_category_color', '000' );
			$id_color_list[$term->term_id] = $color ? $color : '000';
		}

		return $id_color_list;
	}

	// Get Listing Images by Size
	public static function get_single_listing_images_by_size( $listing_id, $size ) {
		$listing_imgs  = get_post_meta( $listing_id, '_listing_img', true );
		$listing_imgs  = $listing_imgs ? $listing_imgs : array();
		$listing_title = get_the_title( $listing_id );
		$image_links   = array();

		// Get the preview image
		$preview_img_id   = get_post_meta( $listing_id, '_listing_prv_img', true );
		$preview_img_link = ! empty( $preview_img_id ) ? atbdp_get_image_source( $preview_img_id, $size ) : '';
		$preview_img_alt  = get_post_meta( $preview_img_id, '_wp_attachment_image_alt', true );
		$preview_img_alt  = ( ! empty( $preview_img_alt ) ) ? $preview_img_alt : get_the_title( $preview_img_id );

		if ( ! empty( $preview_img_link ) ) {
			$image_links[] = array(
				'alt' => $preview_img_alt,
				'src' => $preview_img_link,
				'id'  => isset( $preview_img_id ) ? $preview_img_id : '',
			);
		}

		// Get the Slider Images
		foreach ( $listing_imgs as $img_id ) {
			$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
			$alt = ( ! empty( $alt ) ) ? $alt : get_the_title( $img_id );

			$image_links[] = array(
				'alt' => ( ! empty( $alt ) ) ? $alt : $listing_title,
				'src' => atbdp_get_image_source( $img_id, $size ),
				'id'  => $img_id,
			);
		}

		// Default Image
		$type          = get_post_meta( $listing_id, '_directory_type', true );
		$default_image = Helper::default_preview_image_src( $type );

		if ( count( $listing_imgs ) < 1 ) {
			$listing_imgs[] = array(
				'alt' => $listing_title,
				'src' => $default_image,
				'id'  => '',
			);
		}

		return $image_links;
	}

	// Check Is View Mode Active
	public static function is_view_mode_active( $listings, $view_mode ) {
		$list      = $listings->get_view_as_link_list();
		$view_mode = ucwords( $view_mode );

		foreach ( $list as $key => $value ) {
			if ( $view_mode === $list[$key]['label'] ) {
				return true;
			}
		}

		return false;
	}

	// Get View Mode Link
	public static function get_view_mode_link( $listings, $view_mode ) {
		$list      = $listings->get_view_as_link_list();
		$view_mode = ucwords( $view_mode );

		foreach ( $list as $key => $value ) {
			if ( $view_mode === $list[$key]['label'] ) {
				return $value['link'];
			}
		}

		return "?{$view_mode}";
	}

	// Check whether a field has in Basic or Advanced area
	public static function has_field_in_search_form( $field_name, $searchform, $form_type = "basic" ) {
		$basic_or_advance = 'basic' === $form_type ? '0' : '1';

		return isset( $searchform->form_data[$basic_or_advance]['fields'][$field_name] ) ? true : false;
	}
}

Directorist_Support::instance();