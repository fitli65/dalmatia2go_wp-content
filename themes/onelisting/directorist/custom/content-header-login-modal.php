<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use wpWax\OneListing\Helper;

if( is_user_logged_in() ) {
	return;
}

if ( atbdp_is_page( 'login' ) || atbdp_is_page( 'registration' ) ) {
	return;
}

$redirect_to = get_directorist_option( 'redirection_after_login', 'previous_page' );
?>
<?php if( 'previous_page' == $redirect_to ): ?>
	<script>directorist.redirect_url = '<?php echo esc_attr( get_the_permalink() ); ?>' </script>
<?php endif;?>

<div class="theme-authentication-modal">

	<div class="modal fade" id="theme-login-modal" role="dialog" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered" role="document">

			<div class="modal-content">

				<div class="modal-header">

					<h5 class="modal-title" id="login_modal_label"><?php esc_html_e( 'Sign In', 'onelisting' );?></h5>

					<button type="button" class="theme-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				
				</div>

				<div class="modal-body">

					<?php Helper::get_template_part( 'directorist/custom/header-popup-login' );?>

				</div>

			</div>

		</div>

	</div>

	<div class="modal fade" id="theme-register-modal" role="dialog" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered">

			<div class="modal-content">

				<div class="modal-header">

					<h5 class="modal-title"><?php esc_attr_e( 'Registration', 'onelisting' ); ?></h5>

					<button type="button" class="theme-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span> </button>

				</div>

				<div class="modal-body">

					<?php 

		
					$user_type = ! empty( $atts['user_type'] ) ? $atts['user_type'] : '';
					$user_type = ! empty( $_REQUEST['user_type'] ) ? $_REQUEST['user_type'] : $user_type;
					
					$args = array(
						'parent'               => 0,
						'container_fluid'      => is_directoria_active() ? 'container' : 'container-fluid',
						'username'             => get_directorist_option( 'reg_username', __( 'Username', 'onelisting' ) ),
						'password'             => get_directorist_option( 'reg_password', __( 'Password', 'onelisting' ) ),
						'display_password_reg' => get_directorist_option( 'display_password_reg', 1 ),
						'require_password'     => get_directorist_option( 'require_password_reg', 1 ),
						'email'                => get_directorist_option( 'reg_email', __( 'Email', 'onelisting' ) ),
						'display_website'      => get_directorist_option( 'display_website_reg', 0 ),
						'website'              => get_directorist_option( 'reg_website', __( 'Website', 'onelisting' ) ),
						'require_website'      => get_directorist_option( 'require_website_reg', 0 ),
						'display_fname'        => get_directorist_option( 'display_fname_reg', 0 ),
						'first_name'           => get_directorist_option( 'reg_fname', __( 'First Name', 'onelisting' ) ),
						'require_fname'        => get_directorist_option( 'require_fname_reg', 0 ),
						'display_lname'        => get_directorist_option( 'display_lname_reg', 0 ),
						'last_name'            => get_directorist_option( 'reg_lname', __( 'Last Name', 'onelisting' ) ),
						'require_lname'        => get_directorist_option( 'require_lname_reg', 0 ),
						'display_bio'          => get_directorist_option( 'display_bio_reg', 0 ),
						'bio'                  => get_directorist_option( 'reg_bio', __( 'About/bio', 'onelisting' ) ),
						'require_bio'          => get_directorist_option( 'require_bio_reg', 0 ),
						'reg_signup'           => get_directorist_option( 'reg_signup', __( 'Sign Up', 'onelisting' ) ),
						'display_login'        => get_directorist_option( 'display_login', 1 ),
						'login_text'           => get_directorist_option( 'login_text', __( 'Already have an account? Please login', 'onelisting' ) ),
						'login_url'            => ATBDP_Permalink::get_login_page_link(),
						'log_linkingmsg'       => get_directorist_option( 'log_linkingmsg', __( 'Here', 'onelisting' ) ),
						'terms_label'          => get_directorist_option( 'regi_terms_label', __( 'I agree with all', 'onelisting' ) ),
						'terms_label_link'     => get_directorist_option( 'regi_terms_label_link', __( 'terms & conditions', 'onelisting' ) ),
						't_C_page_link'        => ATBDP_Permalink::get_terms_and_conditions_page_url(),
						'privacy_page_link'    => ATBDP_Permalink::get_privacy_policy_page_url(),
						'privacy_label'        => get_directorist_option( 'registration_privacy_label', __( 'I agree to the', 'onelisting' ) ),
						'privacy_label_link'   => get_directorist_option( 'registration_privacy_label_link', __( 'Privacy & Policy', 'onelisting' ) ),
						'user_type'			   => $user_type,
						'author_checked'	   => ( 'general' != $user_type ) ? 'checked' : '',
						'general_checked'	   => ( 'general' == $user_type ) ? 'checked' : ''
					);

					Helper::get_template_part( 'directorist/custom/header-popup-registration', $args );?>

				</div>

			</div>

		</div>

	</div>

</div>


