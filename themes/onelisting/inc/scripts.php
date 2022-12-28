<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

use Elementor\Plugin;
class Scripts {

	public $version;
	protected static $instance = null;

	public function __construct() {
		$this->version = Constants::$theme_version;

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 12 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 15 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'gutenberg_scripts' ) );
	}

	public static function instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function register_scripts() {

		// Bootstrap
		wp_register_style( 'bootstrap', Helper::get_vendor_assets( 'bootstrap/css/bootstrap.min.css' ), array(), $this->version );
		// Bootstrap RTL
		wp_register_style( 'bootstrap-rtl', Helper::get_vendor_assets( 'bootstrap/css/bootstrap-rtl.css' ), array(), $this->version );
		wp_register_script( 'bootstrap', Helper::get_vendor_assets( 'bootstrap/js/bootstrap.bundle.min.js' ), array( 'jquery' ), $this->version, true );
		// Swiper Slider.
		wp_register_style( 'swiper', Helper::get_vendor_assets( 'swiper/swiper.css' ), array(), $this->version );
		wp_register_script( 'swiper', Helper::get_vendor_assets( 'swiper/swiper.js' ), array( 'jquery' ), $this->version, true );
		// Line Awesome
		wp_register_style( 'line-awesome', Helper::get_vendor_assets( 'line-awesome/css/line-awesome.min.css' ), array(), $this->version );
		// Countdown
		wp_register_script( 'counter-up', Helper::get_vendor_assets( 'counter/counter-up.min.js' ), array( 'jquery' ), $this->version, true );
		// Waypoints
		wp_register_script( 'waypoints', Helper::get_vendor_assets( 'waypoints/waypoints.min.js' ), array( 'jquery' ), $this->version, true );
		// Magnific Popup
		wp_register_script( 'magnific-popup', Helper::get_vendor_assets( 'magnific-popup/jquery.magnific-popup.min.js' ), array( 'jquery' ), $this->version, true );
		wp_register_style( 'magnific-popup', Helper::get_vendor_assets( 'magnific-popup/magnific-popup.css' ), array(), $this->version, 'all' );

		// Main Style
		wp_register_style( 'onelisting-directorist', Helper::get_css( 'directorist' ), array(), $this->version );
		// Directory Listing RTL
		wp_register_style( 'onelisting-directorist-rtl', Helper::get_css( 'directorist-rtl' ), array(), $this->version );
		wp_register_style( 'onelisting-elementor', Helper::get_css( 'elementor' ), array(), $this->version );
		// Elementor RTL.
		wp_register_style( 'onelisting-elementor-rtl', Helper::get_css( 'elementor-rtl' ), array(), $this->version );
		wp_register_style( 'onelisting-style', Helper::get_css( 'style' ), array(), $this->version );
		// Main RTL Style.
		wp_register_style( 'onelisting-rtl-style', Helper::get_css( 'theme-style-rtl' ), array(), $this->version );
		// Main js
		wp_register_script( 'onelisting-main', Helper::get_js( 'main' ), array( 'jquery' ), $this->version );

		$data = array(
			'ajaxurl'         => admin_url( 'admin-ajax.php' ),
			'resmenuWidth'    => isset( Theme::$options['resmenu_width'] ) ? Theme::$options['resmenu_width'] : '991',
			'category_colors' => class_exists( 'Directorist_Base' ) ? Directorist_Support::get_categories_color() : '',
			'category_icons'  => class_exists( 'Directorist_Base' ) ? Directorist_Support::get_categories_icon() : '',
		);

		wp_localize_script( 'onelisting-main', 'onelisting_localize_data', $data );
	}

	public function add_google_fonts() {
		wp_enqueue_style( 'csf-google-web-fonts', '//fonts.googleapis.com/css?family=Roboto:400,500&#038;display=swap', false );
	}

	public function enqueue_scripts() {

		$this->add_google_fonts(); // add google fonts.

		$this->elementor_scripts(); // Elementor Scripts in preview mode
		$this->conditional_scripts();
		$this->dynamic_style();

		if ( is_rtl() ) {
			// Bootstrap TRL.
			wp_enqueue_style( 'bootstrap-rtl' );
			// Directory Listing RTL.
			wp_enqueue_style( 'onelisting-directorist-rtl' );
			// Elementor RTL.
			wp_enqueue_style( 'onelisting-elementor-rtl' );
			// Theme CSS RTL.
			wp_enqueue_style( 'onelisting-rtl-style' );
		} else {
			// Bootstrap.
			wp_enqueue_style( 'bootstrap' );
			// Directory Listing.
			wp_enqueue_style( 'onelisting-directorist' );
			// Elementor.
			wp_enqueue_style( 'onelisting-elementor' );
			// Theme CSS.
			wp_enqueue_style( 'onelisting-style' );
		}

		/*
		=======================
			Enqueued JS scripts
		========================*/

		// Theme JS
		wp_enqueue_script( 'onelisting-main' );
		// Bootstrap JS
		wp_enqueue_script( 'bootstrap' );
		//Swiper JS
		wp_enqueue_style( 'swiper' );
		//Swiper CSS
		wp_enqueue_script( 'swiper' );
	}

	public function elementor_scripts() {

		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		if ( Plugin::$instance->preview->is_preview_mode() ) {
			wp_enqueue_script( 'swiper' );
			wp_enqueue_style( 'swiper' );
			wp_enqueue_script( 'counter-up' );
			wp_enqueue_script( 'waypoints' );
		}

	}

	public function gutenberg_scripts() {
		wp_enqueue_style( 'onelisting-gutenberg', Helper::get_css( 'gutenberg' ), array(), $this->version );
		ob_start();
		Helper::requires( 'dynamic-styles/common.php' );
		$dynamic_css = ob_get_clean();
		$css         = $this->add_prefix_to_css( $dynamic_css, '.wp-block.block-editor-block-list__block' );
		ob_start();
		Helper::requires( 'dynamic-styles/frontend.php' );
		$css .= ob_get_clean();
		$css = str_replace( 'gtnbg_root', '', $css );
		$css = str_replace( 'gtnbg_suffix', 'wp-block.block-editor-block-list__block', $css );
		$css = $this->optimized_css( $css );
		wp_add_inline_style( 'onelisting-gutenberg', $css );
	}

	private function conditional_scripts() {

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( is_home() || is_category() || is_tag() || is_author() || is_date() ) {
			wp_enqueue_script( 'jquery-masonry' );
		}

		if ( class_exists( 'Directorist_Base' ) ) {
			if ( is_singular( 'at_biz_dir' ) ) {
				wp_enqueue_style( 'swiper' );
				wp_enqueue_script( 'swiper' );
				wp_enqueue_style( 'magnific-popup' );
				wp_enqueue_script( 'magnific-popup' );
			}

			if ( atbdp_is_page( 'all_locations' ) || atbdp_is_page( 'category' ) ) {
				wp_enqueue_script( 'jquery-masonry' );
			}
		}

	}

	private function template_style() {
		$css = '';

		if ( Theme::$bgtype == 'bgcolor' ) {
			$bgcolor      = Theme::$bgcolor;
			$banner_style = "background-color:{$bgcolor};";
		} else {
			$bgimg        = Theme::$bgimg;
			$banner_style = "background:url({$bgimg}) no-repeat scroll center center / cover;";
		}

		$css .= ".banner{{$banner_style}}";

		if ( Theme::$bgtype == 'bgimg' ) {
			$opacity = Theme::$options['bgopacity'] / 100;
			$css .= ".header-bgimg .banner:before{background-color: #05071D; opacity: {$opacity};}";
		}

		return $css;
	}

	private function add_prefix_to_css( $css, $prefix ) {
		$parts = explode( '}', $css );
		foreach ( $parts as &$part ) {
			if ( empty( $part ) ) {
				continue;
			}

			$firstPart = substr( $part, 0, strpos( $part, '{' ) + 1 );
			$lastPart  = substr( $part, strpos( $part, '{' ) + 2 );
			$subParts  = explode( ',', $firstPart );
			foreach ( $subParts as &$subPart ) {
				$subPart = str_replace( "\n", '', $subPart );
				$subPart = $prefix . ' ' . trim( $subPart );
			}

			$part = implode( ', ', $subParts ) . $lastPart;
		}

		$prefixedCSS = implode( "}\n", $parts );

		return $prefixedCSS;
	}

	private function optimized_css( $css ) {
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), ' ', $css );

		return $css;
	}

	private function dynamic_style() {
		$dynamic_css = '';
		$dynamic_css .= $this->template_style();
		ob_start();
		Helper::requires( 'dynamic-styles/frontend.php' );
		$dynamic_css .= ob_get_clean();
		$dynamic_css = $this->optimized_css( $dynamic_css );

		$handler = is_rtl() ? 'onelisting-rtl-style' : 'onelisting-style';
		wp_add_inline_style( $handler, $dynamic_css );
	}

}

Scripts::instance();