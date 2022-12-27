<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.0.5.3
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-card directorist-single-listing-header">
	
	<?php $listing->slider_template(); ?>

	<div class="container directorist-card__body">

		<div class="directorist-listing-details">

			<?php $listing->quick_info_template(); ?>

			<?php if ( $display_title ): ?>
				<h2 class="directorist-listing-details__listing-title"><?php echo esc_html( $listing->get_title() ); ?></h2>
			<?php endif; ?>

			<?php do_action( 'directorist_single_listing_after_title', $listing->id ); ?>

			<?php if ( $display_tagline && $listing->get_tagline() ): ?>
				<p class="directorist-listing-details-tagline"><?php echo esc_html( $listing->get_tagline() ); ?></p>
			<?php endif; ?>

			<?php if ( $display_content && $listing->get_contents() ): ?>
				<div class="directorist-listing-details__text">
					<?php echo wp_kses_post( $listing->get_contents() ); ?>
				</div>
			<?php endif; ?>

			<?php $listing->quick_actions_template(); ?>

		</div>

	</div>

</div>