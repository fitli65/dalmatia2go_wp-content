<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

$email = get_post_meta( get_the_ID(), '_email', true);
$form_id = apply_filters('atbdp_contact_listing_owner_widget_form_id', 'atbdp-contact-form-widget');
?>
<div class="modal theme-modal theme-contact-modal fade" id="theme-author-contact-modal" tabindex="-1" role="dialog" aria-labelledby="contact_modal_title" aria-hidden="true">

	<div class="modal-dialog modal-dialog-centered" role="document">

		<div class="modal-content">

			<div class="modal-header">

				<h5 class="modal-title" id="contact_modal_title"><?php esc_html_e( 'Request Info', 'onelisting' ); ?></h5>

				<button type="button" class="theme-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

			</div>

			<div class="modal-body">

				<form id="onelisting-contact-owner-form" class="form-vertical directorist-contact-owner-form">
					
					<div class="form-group theme-form-group">

						<label for="atbdp-contact-name">Name</label>
						
						<input type="text" class="form-control theme-form-control" id="atbdp-contact-name" name="name" placeholder="<?php esc_attr_e('Name', 'onelisting'); ?>" required />
					
					</div>

					<div class="form-group theme-form-group">

						<label for="atbdp-contact-email">Email</label>

						<input type="email" class="form-control theme-form-control" id="atbdp-contact-email" name="email" placeholder="<?php esc_attr_e('Email', 'onelisting'); ?>" required />
					
					</div>

					<?php
					$msg_html = '<div class="form-group theme-form-group">';
					$msg_html .= sprintf('<label for="atbdp-contact-message">%s</label>', esc_html__( 'Message', 'onelisting') );
					$msg_html .= '<textarea class="form-control theme-form-control" id="atbdp-contact-message" name="message" rows="3" placeholder="' . esc_html__('I would like more information about...', 'onelisting') . '..." required ></textarea>';
					$msg_html .= '</div>';
					
					/**
					 * @since 5.10.0
					 */
					echo apply_filters('atbdp_widget_contact_form_message_field', $msg_html);
					?>

					<input type="hidden" id="onelisting-post-id" name="onelisting-post-id" value="<?php echo esc_attr( get_the_ID() ); ?>" />
					<input type="hidden" id="atbdp-listing-email" name="email" value="<?php echo ! empty($email) ? sanitize_email($email) : ''; ?>" />
					
					<?php
					/**
					 * It fires before contact form in the widget area
					 * @since 4.4.0
					 */

					do_action('atbdp_before_contact_form_submit_button');
					?>

					<p class="atbdp-widget-elm" id="directorist-contact-message-display"></p>

					<button type="submit" class="btn btn-dark theme-btn btn-block"><?php esc_html_e('Send Message', 'onelisting'); ?></button>

				</form>

			</div>

		</div>

	</div>

</div>