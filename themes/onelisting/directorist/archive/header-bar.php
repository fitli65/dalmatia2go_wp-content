<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.3.1
 */

use \Directorist\Helper;
use wpWax\OneListing\Directorist_Support;
use wpWax\OneListing\Helper as OneListingHelper;

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-header-bar">

	<div class="<?php Helper::directorist_container_fluid(); ?>">

		<div class="directorist-listings-header">

			<?php if ( $listings->has_listings_header() ): ?>

				<div class="directorist-listings-header__left">

					<?php if ( $listings->has_filters_button ): ?>
						<a href="#" class="directorist-btn directorist-btn-sm directorist-btn-px-15 directorist-btn-outline-primary directorist-filter-btn"><?php echo wp_kses_post( $listings->filter_btn_html() ); ?></a>
					<?php endif; ?>

					<?php if ( $listings->header_title ): ?>
						<h3 class="directorist-header-found-title"><?php echo wp_kses_post( $listings->item_found_title() ); ?></h3>
					<?php endif; ?>
				</div>

			<?php endif; ?>

			<?php if ( $listings->has_header_toolbar() ): ?>

				<div class="directorist-listings-header__right">

					<?php foreach ( $listings->get_view_as_link_list() as $key => $value ): 
								$link = isset( $value['link'] ) ? $value['link'] : '#';
						?>

						<?php if ( strpos( $link, 'map' ) ):?>
							
							<div class="theme-btn-show-map directorist-viewas-dropdown">
								<?php printf( '<a href="%s" class="directorist-dropdown__links--single btn theme-btn btn-show-map">%s %s</a>',esc_attr( $value['link'] ), directorist_icon( 'las la-map', false ), esc_html__( 'Show Map', 'onelisting' ) ); ?>
							</div>
							
						<?php endif;?>

					<?php endforeach;?>

					<div class="directorist-listings-header__actions">

						<?php
						if ( $listings->display_sortby_dropdown ) {
							$listings->sortby_dropdown_template();
						}

						if ( $listings->display_viewas_dropdown ) {
							OneListingHelper::get_template_part( 'directorist/custom/view-mode', [ 'listings' =>$listings ] );
						}
						?>
						
					</div>
					

				</div>

			<?php endif; ?>

		</div>

		<?php if ( $listings->advanced_filter ) { ?>
			<div class="<?php Helper::search_filter_class( $listings->filters_display ); ?>">
				<?php $listings->search_form_template();?>
			</div>
		<?php } ?>

	</div>

</div>