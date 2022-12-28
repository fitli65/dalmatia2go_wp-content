<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

if ( ! isset( $content_width ) ) {
	$content_width = 1140;
}

define( 'ONELISTING_THEME', 'free' );

class OneListing_Main {

	public $theme = 'onelisting';

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'load_textdomain' ) );
		$this->includes();
	}

	public function load_textdomain() {
		load_theme_textdomain( $this->theme, get_template_directory() . '/languages' );
	}

	public function includes() {

		do_action( 'onelisting_theme_init_before' );

		require_once get_template_directory() . '/lib/tgm/class-tgm-plugin-activation.php';
		require_once get_template_directory() . '/lib/directorist-theme-updater/theme-updater-admin.php';

		require_once get_template_directory() . '/inc/constants.php';
		require_once get_template_directory() . '/inc/traits/init.php';
		require_once get_template_directory() . '/inc/helper.php';
		require_once get_template_directory() . '/inc/tgm-config.php';
		require_once get_template_directory() . '/inc/updater-config.php';
		require_once get_template_directory() . '/inc/pro-notice.php';

		require_once get_template_directory() . '/inc/theme.php';
		require_once get_template_directory() . '/inc/general.php';
		require_once get_template_directory() . '/inc/scripts.php';
		require_once get_template_directory() . '/inc/layout-settings.php';

		if ( class_exists( 'Directorist_Base' ) ) {
			require_once get_template_directory() . '/inc/directorist-support.php';
		}

		do_action( 'onelisting_theme_init_after' );
	}
}

new OneListing_Main;