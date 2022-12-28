<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

trait Sidebar_Trait {

	public static function has_sidebar() {
		$has_sidebar_widgets = false;

		if ( is_active_sidebar( 'sidebar' ) ) {
			$has_sidebar_widgets = true;
		}

		if ( $has_sidebar_widgets && Theme::$layout != 'full-width' ) {
			return true;
		} else {
			return false;
		}
	}

	public static function the_layout_class() {
		$layout_class = self::has_sidebar() ? 'col-lg-8 col-sm-12' : 'col-sm-12';
		
		if ( is_single() ) {
			$layout_class = self::has_sidebar() ? 'col-lg-8 col-sm-12' : 'col-lg-8 offset-lg-2';
		}

		echo apply_filters( 'wpwaxtheme_layout_class', $layout_class );
	}

	public static function the_sidebar_class() {
		echo apply_filters( 'wpwaxtheme_sidebar_class', 'col-lg-4 col-sm-12' );
	}

	public static function left_sidebar() {

		if ( self::has_sidebar() ) {

			if ( Theme::$layout == 'left-sidebar' ) {
				get_sidebar();
			}

		}
	}

	public static function right_sidebar() {

		if ( self::has_sidebar() ) {

			if ( Theme::$layout == 'right-sidebar' ) {

				get_sidebar();

			}

		}
	}
}