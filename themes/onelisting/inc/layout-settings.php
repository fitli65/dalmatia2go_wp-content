<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

class Layouts {

	use Layout_Trait;

	protected static $instance = null;

	public $prefix;
	public $post_type;
	public $meta_value;

	public function __construct() {
		$this->prefix = Constants::$theme_prefix;
		add_action( 'template_redirect', array( $this, 'layout_settings' ) );
	}

	public static function instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function layout_settings() {

		if (  ( is_single() || is_page() ) ) {
			$post_type        = get_post_type();
			$post_id          = get_the_id();
			$this->meta_value = get_post_meta( $post_id, "{$this->prefix}_layout_settings_{$post_type}", true );

			switch ( $post_type ) {
				case 'page':
					$this->post_type = 'page';
					break;
				case 'post':
					$this->post_type = 'single_post';
					break;
				default:
					$this->post_type = 'single_post';
					break;
			}

		} elseif ( is_home() || is_archive() || is_search() || is_404() ) {

			if ( is_search() ) {
				$this->post_type = 'search';
			} elseif ( is_404() ) {
				$this->post_type                              = 'error';
				Theme::$options[$this->post_type . '_layout'] = 'full-width';
			} else {
				$this->post_type = 'blog';
			}

		} else {
			$this->post_type = 'single_post';
		}

		Theme::$layout         = $this->meta_layout_option( 'layout' );
		Theme::$has_banner     = $this->meta_layout_global_option( 'banner', true );
		Theme::$has_breadcrumb = $this->meta_layout_global_option( 'breadcrumb', true );
		Theme::$bgtype         = $this->meta_layout_global_option( 'bgtype' );
		Theme::$bgimg          = $this->bgimg_option( 'bgimg' );
		Theme::$bgcolor        = $this->meta_layout_global_option( 'bgcolor' );
	}
}

Layouts::instance();