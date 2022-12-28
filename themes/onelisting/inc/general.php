<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

use wpWax\OneListing\Helper;

class General_Setup {

	protected static $instance = null;

	public function __construct() {
		add_action( 'after_setup_theme',		array( $this, 'theme_setup' ) );
		add_action( 'widgets_init',				array( $this, 'register_sidebars' ), 5 );
		add_action( 'wp_head',					array( $this, 'noscript_hide_preloader' ), 1 );
		add_action( 'wp_head',					array( $this, 'pingback' ) );
		add_action( 'wp_body_open',				array( $this, 'preloader' ) );
		add_filter( 'body_class',				array( $this, 'body_classes' ) );
		add_filter( 'comment_form_fields',		array( $this, 'comment_fields_custom_order' ) );
		add_filter( 'pre_get_posts',			array( $this, 'blog_search_result' ) );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function theme_setup() {
		// Theme supports
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_post_type_support( 'post', 'page-attributes' );
		remove_theme_support( 'widgets-block-editor' );
		$this->custom_logo_setup();

		// Image sizes
		$sizes = array(
			'wpwaxtheme-size1'   => array( 920, 398, true ), // Single Post
			'wpwaxtheme-size2'   => array( 352, 252, true ), // Blog and Elementor Widget
			'wpwaxtheme-size3'   => array( 60, 60, true ),   // Blog Sidebar Widget
			'wpwaxtheme-476x340' => array( 476, 340, true ), // Single Listing Header Slider
			'wpwaxtheme-260x300' => array( 260, 300, true ), // Location Image
		);

		$this->add_image_sizes( $sizes );

		// Register menus
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'onelisting' ),
		) );
	}

	function custom_logo_setup() {
		$defaults = array(
			'height'               => 80,
			'width'                => 130,
			'flex-height'          => true,
			'flex-width'           => true,
			'unlink-homepage-lgo'  => true, 
		);
	 
		add_theme_support( 'custom-logo', $defaults );
	}

	private function add_image_sizes( $sizes ) {
		$sizes = apply_filters( 'wpwaxtheme_image_sizes', $sizes );

		foreach ( $sizes as $size => $value ) {
			add_image_size( $size, $value[0], $value[1], $value[2] );
		}
	}

	public function register_sidebars() {

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'onelisting' ),
			'id'            => 'sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s atbd_widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		) );

		$footer_widget_titles = array(
			'1' => esc_html__( 'Footer 1', 'onelisting' ),
			'2' => esc_html__( 'Footer 2', 'onelisting' ),
			'3' => esc_html__( 'Footer 3', 'onelisting' ),
			'4' => esc_html__( 'Footer 4', 'onelisting' ),
		);

		foreach ( $footer_widget_titles as $id => $name ) {
			register_sidebar( array(
				'name'          => $name,
				'id'            => 'footer-' . $id,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			) );
		}
	}

	public function noscript_hide_preloader() {
		// Hide preloader if js is disabled
		echo '<noscript><style>#preloader{display:none;}</style></noscript>';
	}

	public function pingback() {

		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}

	}

	public function preloader() {
		// Preloader
		if ( Theme::$options['preloader'] ) {

			if ( ! empty( Theme::$options['preloader_image']['url'] ) ) {
				$preloader_img = Theme::$options['preloader_image']['url'];
			} else {
				$preloader_img = Helper::get_img( 'preloader.svg' );
			}

			echo '<div id="theme-preloader" style="background-image:url(' . esc_url( $preloader_img ) . ');"></div>';
		}
	}

	public function body_classes( $classes ) {
		
		// Sidebar
		if ( Theme::$layout == 'left-sidebar' ) {
			$classes[] = 'has-sidebar left-sidebar';
		} elseif ( Theme::$layout == 'right-sidebar' ) {
			$classes[] = 'has-sidebar right-sidebar';
		} else {
			$classes[] = 'no-sidebar';
		}

		// Bgtype
		if ( Theme::$bgtype == 'bgimg' ) {
			$classes[] = 'header-bgimg';
		}

		if ( is_single() ) {
			$classes[] = 'theme-single-post';
		}

		if ( is_page() ) {
			$classes[] = 'theme-single-page';
		}

		if ( is_home() ) {
			$classes[] = 'theme-blog';
		}

		if ( is_category() ) {
			$classes[] = 'theme-category';
		}

		if ( is_archive() ) {
			$classes[] = 'theme-archive';
		}

		return $classes;
	}

	// Comment Fields Order
	public function comment_fields_custom_order( $fields ) {
		$comment_field = $fields['comment'];
		$author_field  = $fields['author'];
		$email_field   = $fields['email'];
		unset( $fields['comment'] );
		unset( $fields['author'] );
		unset( $fields['email'] );
		// The order of fields is the order below, change it as needed:
		$fields['author']  = $author_field;
		$fields['email']   = $email_field;
		$fields['comment'] = $comment_field;
		
		// Done ordering, now return the fields:
		return $fields;
	}

	// Display only blog posts in search result page.
	public function blog_search_result( $query ) {
		
		if ( isset( $_REQUEST['post_type'] ) ) {
			return $query;
		}

		if( is_search() ) {
			if ( $query->is_search ) {
				$query->set( 'post_type', 'post' );
			}
		}

		return $query;
	}
}

General_Setup::instance();