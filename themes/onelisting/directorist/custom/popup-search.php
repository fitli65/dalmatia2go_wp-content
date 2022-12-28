<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="theme-search-popup" class="theme-search-popup">

	<button class="theme-popup-close"><span><?php esc_html_e( '×', 'onelisting' ); ?></span></button>

	<div class="theme-search-popup-box">

		<div class="container">

			<div class="row">
				<div class="col-12">

					<?php echo do_shortcode('[directorist_search_listing more_filters_button="no" show_title_subtitle="no" show_popular_category="no"]'); ?>

				</div>

			</div>

		</div>
		
	</div>

</div>

<div class="theme-shade"></div>
<div class="theme-shade theme-white-shade"></div>