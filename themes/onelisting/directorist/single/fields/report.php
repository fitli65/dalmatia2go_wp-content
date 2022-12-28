<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.0.6.3
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-single-listing-action directorist-action-report directorist-tooltip directorist-btn-modal directorist-btn-modal-js" data-directorist_target="directorist-report-abuse-modal" data-label="<?php esc_html_e( 'Report', 'onelisting' ); ?>">

	<?php if ( is_user_logged_in() ): ?>
		<a class="directorist-action-report-loggedin" href="#"><?php directorist_icon( $icon );?><?php esc_attr_e( 'Report', 'onelisting')?></a>
	<?php else: ?>
		<a class="directorist-action-report-not-loggedin" href="javascript:void(0)"><?php directorist_icon( $icon );?><?php esc_attr_e( 'Report', 'onelisting')?></a>
	<?php endif; ?>

	<input type="hidden" id="atbdp-post-id" value="<?php echo esc_attr( $listing->id ); ?>"/>

</div>