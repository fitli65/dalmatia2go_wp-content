<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

class Theme {

	protected static $instance;

	// Sitewide static variables
	public static $options;

	// Template specific variables
	public static $layout;
	public static $has_banner;
	public static $has_breadcrumb;
	public static $bgtype;
	public static $bgimg;
	public static $bgcolor;

	private function __construct() {
		add_action( 'after_setup_theme', array( $this, 'set_options' ) );
	}

	public static function instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function set_options() {

		if ( ONELISTING_THEME == 'pro' ) {
			$options = get_option( Constants::$theme_options, array() );
		} else {
			include 'predefined-data.php';
			$predefined_options = json_decode( $predefined_options, true );
			$options            = $predefined_options;
		}

		self::$options = apply_filters( 'wpwax_theme_options', $options );
	}
}

Theme::instance();