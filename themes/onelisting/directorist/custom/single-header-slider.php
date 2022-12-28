<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use wpWax\OneListing\Directorist_Support;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slider_data = $args->get_slider_data();

if ( ! isset( $args->header_data['listings_header']['thumbnail'][0] ) ) {
	return;
}

if ( ! $slider_data ) {
	return;
}

$total_photos = count( $slider_data['images'] );
$listing_imgs = Directorist_Support::get_single_listing_images_by_size( get_the_ID(), 'full' );
?>

<?php if ( $total_photos ): ?>

	<div class="theme-single-listing-slider-wrap<?php echo esc_attr(  ( $total_photos > 2 ) ? '' : ' has-background-color' ); ?>">
		
		<div id="theme-single-listing-slider" class="theme-single-listing-slider theme-swiper theme-carousel" data-sw-items="4" data-sw-margin="6" data-sw-loop="true" data-sw-perslide="1" data-sw-speed="1000" data-sw-autoplay="{}" data-sw-responsive='{
			"0": {"slidesPerView": "1"},
			"768": {"slidesPerView": "2"},
			"992": {"slidesPerView": "3"},
			"1200": {"slidesPerView": "4"}
		}'>
			<div class="swiper-wrapper">

				<?php if ( ! empty( $listing_imgs ) ): ?>

					<?php foreach ( $listing_imgs as $key => $image ): ?>

						<div class="swiper-slide theme-single-listing-slider__item">

							<a href="<?php echo esc_attr( isset( $image['id'] ) ? atbdp_get_image_source( $image['id'], 'full' ) : $image['src'] ) ?>"><img src="<?php echo esc_attr( $image['src'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ) ?>"/></a>

						</div>

					<?php endforeach;?>

				<?php endif;?>

			</div>

			<div class="theme-swiper-navigation">

				<div class="theme-swiper-button-nav theme-swiper-button-prev"><?php directorist_icon( 'fas fa-angle-left' ); ?></div>

				<div class="theme-swiper-button-nav theme-swiper-button-next"><?php directorist_icon( 'fas fa-angle-right' ); ?></div>

			</div>
		</div>
		<?php if ( $total_photos > 4 ): ?>

			<div class="theme-single-listing-see-all">

				<?php printf( '<a href="" class="btn theme-btn btn-listing-see-all">%s %s %s</a>', directorist_icon( 'las la-image', false ), __( 'See photos', 'onelisting' ), $total_photos )?>

			</div>

		<?php endif;?>

	</div>

<?php endif;?>