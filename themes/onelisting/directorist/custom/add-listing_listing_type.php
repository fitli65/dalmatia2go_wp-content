<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$plan_id = selected_plan_id();
$order_id = !empty( $_GET['order'] ) ? $_GET['order'] : '';

if ( ! $args['enable_onelisting_listing_type'] ) {
	return;
}

if (  ( package_or_PPL( $plan_id ) === 'pay_per_listng' ) ) {
	$type = 'regular';

	if ( PPL_with_featured() ) {
		$type = 'featured';
	}
	?>
	<input type="hidden" name="listing_type" value="<?php echo esc_attr( $type ); ?>">
	<?php

	return;
};

$num_regular  = get_post_meta( $plan_id, 'num_regular', true );
$num_featured = get_post_meta( $plan_id, 'num_featured', true );
$remaining  = plans_remaining( $plan_id, $order_id );
?>

<div class="directorist-form-listing-type">

	<?php $listing_type = ! empty( $args['listing_type'] ) ? $args['listing_type'] : ''; ?>

	<h4 class="directorist-option-title"><?php echo esc_attr( $args['onelisting_choose_listing_type_label'] ); ?></h4>

	<div class="directorist-form-listing-type__list">

		<?php 
		if ( is_array( $remaining ) && isset( $remaining['regular'] ) ) {
			$regular = $remaining['regular'];
			?>

			<?php if ( 'Unlimited' === $regular ) : ?>

				<div class="directorist-form-listing-type__single directorist-radio directorist-radio-circle">

					<input id="regular" <?php echo ( $listing_type == 'regular' ) ? 'checked' : ''; ?> type="radio" class="atbdp_radio_input" name="listing_type" value="regular" checked>

					<label for="regular" class="directorist-radio__label"><?php echo esc_attr( $args['onelisting_general_label'] ); ?>

						<span class="atbdp_make_str_green"><?php _e( " (Unlimited)", 'onelisting' ); ?></span>

					</label>

				</div>

			<?php else: ?>

				<div class="directorist-form-listing-type__single directorist-radio directorist-radio-circle">

					<input id="regular" <?php echo ( $listing_type == 'regular' ) ? 'checked' : ''; ?> type="radio" class="atbdp_radio_input" name="listing_type" value="regular" checked>

					<label for="regular" class="directorist-radio__label"><?php echo esc_attr( $args['onelisting_general_label'] ); ?>
					
						<span class="<?php echo $regular > 0 ? 'atbdp_make_str_green' : 'atbdp_make_str_red' ?>">

							<?php printf( esc_html__( '%s of %s Listing available' ), esc_html( $regular ), esc_html( $num_regular ) ); ?>

						</span>

					</label>

				</div>

			<?php endif; ?>
		
			<?php
		}
		?>

		<?php
		if ( is_array( $remaining ) && isset( $remaining['featured'] ) ) {
	
			$featured = $remaining['featured'];
			?>

			<?php if ( 'Unlimited' === $featured ) : ?>

				<div class="directorist-form-listing-type__single directorist-radio directorist-radio-circle">

					<input id="featured" type="radio" class="atbdp_radio_input" <?php echo ( $listing_type == 'featured' ) ? 'checked' : ''; ?> name="listing_type" value="featured">

					<label for="featured" class="directorist-radio__label featured_listing_type_select">

						<?php echo esc_attr( $args['onelisting_featured_label'] ); ?>

						<span class="atbdp_make_str_green"><?php _e( " (Unlimited)", 'onelisting' )?></span>

					</label>

				</div>

			<?php else : ?>

				<div class="directorist-form-listing-type__single directorist-radio directorist-radio-circle">

					<input id="featured" type="radio" <?php echo ( $listing_type == 'featured' ) ? 'checked' : ''; ?> class="atbdp_radio_input" name="listing_type" value="featured">

					<label for="featured" class="directorist-radio__label featured_listing_type_select">

						<?php echo esc_attr( $args['onelisting_featured_label'] ); ?>
						
						<span class="<?php echo $featured > 0 ? 'atbdp_make_str_green' : 'atbdp_make_str_red' ?>">

							<?php printf( esc_html__( '%s of %s Listing available' ), esc_html( $featured ), esc_html( $num_featured ) ); ?>

						</span>
						
					</label>

				</div>

			<?php endif; ?>

			<?php
		}
		?>

	</div>

</div>