<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

class Helper {

	use URI_Trait;
	use Sidebar_Trait;

	public static function has_breadcrumb_support() {
		if ( ONELISTING_THEME == 'pro' ) {
			return true;
		}
		else {
			return false;
		}
	}

	public static function the_breadcrumb() {

		if ( function_exists( 'bcn_display' ) ) {
			bcn_display();
		} else {
			$args = array(
				'show_browse'   => false,
				'post_taxonomy' => array(
					'at_biz_dir' => 'at_biz_dir-category',
					'product'    => 'product_cat',
				),
			);
			$breadcrumb = new \wpWax\Theme\Lib\Breadcrumb\Breadcrumb( $args );

			return $breadcrumb->trail();
		}
	}

	public static function filter_content( $content ) {
		// wp filters
		$content = wptexturize( $content );
		$content = convert_smilies( $content );
		$content = convert_chars( $content );
		$content = wpautop( $content );
		$content = shortcode_unautop( $content );

		// remove shortcodes
		$pattern = '/\[(.+?)\]/';
		$content = preg_replace( $pattern, '', $content );

		// remove tags
		$content = strip_tags( $content );

		return $content;
	}

	public static function get_nav_menu_args( $button ) {

		$nav_menu_args = array(
			'theme_location'  => 'primary',
			'container'       => 'nav',
			'fallback_cb'     => false,
			'container_class' => 'menu-main-menu-container',
			'items_wrap'      => '<ul id="%1$s" class="%2$s theme-main-menu">%3$s</ul>',
		);

		return $nav_menu_args;
	}

	public static function get_page_title() {

		if ( is_search() ) {
			$title = esc_html__( 'Search Results for : ', 'onelisting' ) . get_search_query();
		} elseif ( is_404() ) {
			$title = esc_html__( 'Page not Found', 'onelisting' );
		} elseif ( is_home() ) {

			if ( get_option( 'page_for_posts' ) ) {
				$title = get_the_title( get_option( 'page_for_posts' ) );
			} else {
				$title = apply_filters( "wpwaxtheme_blog_title", esc_html__( 'Blog', 'onelisting' ) );
			}

		} elseif ( is_archive() ) {
			$title = get_the_archive_title();
		} else {
			$title = get_the_title();
		}

		return apply_filters( 'wpwaxtheme_page_title', $title );
	}

	public static function get_primary_color() {
		$primary_color = Theme::$options['primary_color'];

		return apply_filters( 'wpwaxtheme_primary_color', $primary_color );
	}

	public static function comments_callback( $comment, $args, $depth ) {
		Helper::get_template_part( 'template-parts/comments-callback', compact( "comment", "args", "depth" ) );
	}

	public static function hex2rgb( $hex ) {
		$hex = str_replace( "#", "", $hex );

		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}

		$rgb = "$r, $g, $b";

		return $rgb;
	}

	public static function user_textfield( $label, $field, $value ) {
		?>

		<tr>

			<th>
				<label><?php echo esc_html( $label ); ?></label>
			</th>

			<td>
				<input class="regular-text" type="text" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $field ); ?>">
			</td>

		</tr>

		<?php
	}

	public static function uniqueid() {
		$time = microtime();
		$time = str_replace( array( ' ', '.' ), '-', $time );
		$id   = 'u-' . $time;

		return $id;
	}

	public static function get_reading_time( $content, $tag ) {
		$stripped_content = strip_tags( $content );
		$total_word       = str_word_count( $stripped_content );
		$reading_minute   = floor( $total_word / 200 );
		$reading_seconds  = floor( $total_word % 200 / ( 200 / 60 ) );

		if ( ! $reading_minute ) {
			$reading_time = $reading_seconds;
			$unit_name    = __( 'secs', 'onelisting' );
		} else {
			$reading_time = $reading_minute;
			$unit_name    = __( 'mins', 'onelisting' );
		}

		$reading_time_html = sprintf( '<%s>%s %s %s </%s>', $tag, $reading_time, $unit_name, __( 'read', 'onelisting' ), $tag );

		return $reading_time_html;
	}

	public static function get_paginate_links() {
		$args = array(
			'prev_text' => Helper::get_svg_icon( 'long-arrow-alt-left-solid' ),
			'next_text' => Helper::get_svg_icon( 'long-arrow-alt-right-solid'),
		);

		return paginate_links( $args );
	}

	public static function get_svg_icon( $filename ) {
		$dir      = 'assets/icons';
		$filename = $filename . '.svg';
		$file     = self::get_file_path( $filename, $dir );
		$svg      = file_get_contents( $file );
		$svg      = trim( $svg );

		return $svg;
	}
}