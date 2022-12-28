<?php
/**
 * @author  wpWax
 */

?>
<div class="theme-modal-content">    
	<div class="add_listing_title atbd_success_mesage">
		<?php
		$display_password = get_directorist_option( 'display_password_reg', 1 );

		if( ! empty( $_GET['registration_status'] ) && true == $_GET['registration_status'] ){
			if ( empty( $display_password ) ){
				?>
				<p style="padding: 20px" class="alert-success">
					<?php directorist_icon( 'fas fa-check' ); ?>
					<?php 

					_e(' Go to your inbox or spam/junk and get your password.', 'onelisting');

					printf(__(' Click %s to login.', 'onelisting'), "<a href='" . ATBDP_Permalink::get_login_page_link() . "'><span style='color: red'> " . __('Here', 'onelisting') . "</span></a>");

					?>
				</p>
				<?php
			}else {
				?>
				<!--registration succeeded, so show notification -->
				<p style="padding: 20px" class="alert-success">
					<?php directorist_icon( 'fas fa-check' ); ?>
					<?php _e( 'Registration completed. Please check your email for confirmation.', 'onelisting' ); ?>
					<?php
					printf( __( 'Or click %s to login.', 'onelisting' ), "<a href='#' data-bs-toggle='modal' data-bs-target='#theme-register-modal'><span style='color: red'> " . __( 'Here', 'onelisting' ) . "</span></a>");

					?>
				</p>
				<?php
			}

		}
		?>
		<!--Registration failed, so show notification.-->
		<?php
		$errors = ! empty( $_GET['errors'] ) ? $_GET['errors'] : '';
		switch ( $errors ) {
			case '1':
				?> <p style="padding: 20px" class="alert-danger"> <?php directorist_icon( 'fas fa-exclamation-triangle' ); ?> <?php _e('Registration failed. Please make sure you filed up all the necessary fields marked with <span style="color: red">*</span>', 'onelisting'); ?></p><?php
				break;
			case '2':
				?> <p style="padding: 20px" class="alert-danger"> <?php directorist_icon( 'fas fa-exclamation-triangle' ); ?> <?php _e('Sorry, that email already exists!', 'onelisting'); ?></p><?php
				break;
			case '3':
				?> <p style="padding: 20px" class="alert-danger"> <?php directorist_icon( 'fas fa-exclamation-triangle' ); ?> <?php _e('Username too short. At least 4 characters is required', 'onelisting'); ?></p><?php
				break;
			case '4':
				?> <p style="padding: 20px" class="alert-danger"> <?php directorist_icon( 'fas fa-exclamation-triangle' ); ?> <?php _e('Sorry, that username already exists!', 'onelisting'); ?></p><?php
				break;
			case '5':
				?> <p style="padding: 20px" class="alert-danger"> <?php directorist_icon( 'fas fa-exclamation-triangle' ); ?> <?php _e('Password length must be greater than 5', 'onelisting'); ?></p><?php
				break;
			case '6':
				?> <p style="padding: 20px" class="alert-danger"> <?php directorist_icon( 'fas fa-exclamation-triangle' ); ?> <?php _e('Email is not valid', 'onelisting'); ?></p><?php
				break;
			case '7':
				?> <p style="padding: 20px" class="alert-danger"> <?php directorist_icon( 'fas fa-exclamation-triangle' ); ?> <?php _e('Space is not allowed in username', 'onelisting'); ?></p><?php
				break;
			case '8':
				?> <p style="padding: 20px" class="alert-danger"> <?php directorist_icon( 'fas fa-exclamation-triangle' ); ?> <?php _e('Please make sure you filed up the user type', 'onelisting'); ?></p><?php
				break;
		}
		?>
	</div>

	<form action="<?php echo esc_url( get_the_permalink() ); ?>" method="post">
		<div class="theme-modal-wrap">
			
			<div class="directorist-form-group directorist-mb-15">

				<label for="r_username"><?php printf( __( '%s', 'onelisting' ), $username ); ?><strong class="directorist-form-required">*</strong></label>

				<input id="r_username" class="directorist-form-element" type="text" name="username" value="<?php echo ( isset( $_REQUEST['username'] ) ? esc_attr( $_REQUEST['username'] ) : null ); ?>">

			</div>
			<div class="directorist-form-group directorist-mb-15">

				<label for="email"><?php printf( __( '%s', 'onelisting' ), $email ); ?> <strong class="directorist-form-required">*</strong></label>
				<input id="email" class="directorist-form-element" type="text" name="email" value="<?php echo ( isset( $_REQUEST['email'] ) ? $_REQUEST['email'] : null ); ?>">

			</div>

			<?php if ( ! empty( $display_password_reg ) ) : ?>

				<div class="directorist-form-group directorist-mb-15">
					<label for="r_password">

						<?php
						printf( __( '%s ', 'onelisting' ), $password );

						echo !empty( $require_password ) ? '<strong class="directorist-form-required">*</strong>': '';

						?>
					</label>

					<input id="r_password" class="directorist-form-element" type="password" name="password" value="<?php echo ( isset( $_POST['password'] ) ? esc_attr( $_POST['password'] ) : null ); ?>">

				</div>

			<?php endif; ?>

			<?php  if ( !empty( $display_fname ) ) : ?>

				<div class="directorist-form-group directorist-mb-15">

					<label for="r_fname">
						<?php

						printf( __( '%s ', 'onelisting' ), $first_name );
						echo !empty( $require_fname ) ? '<strong class="directorist-form-required">*</strong>': '';

						?>
					</label>

					<input id="r_fname" class="directorist-form-element" type="text" name="fname" value="<?php echo ( isset( $_REQUEST['fname'] ) ? esc_attr( $_REQUEST['fname'] ) : null ); ?>">

				</div>

			<?php endif; ?>
			
			<?php if ( !empty( $display_lname ) ) : ?>

				<div class="directorist-form-group directorist-mb-15">
					<label for="r_lname">
						<?php

						printf( __( '%s ', 'onelisting' ), $last_name );
						echo ! empty( $require_lname ) ? '<strong class="directorist-form-required">*</strong>': '';

						?>
					</label>
					<input class="directorist-form-element" id="r_lname" type="text" name="lname" value="<?php echo ( isset( $_REQUEST['lname'] ) ? esc_attr( $_REQUEST['lname'] ) : null ); ?>">
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $display_website ) ) : ?>

				<div class="directorist-form-group directorist-mb-15">
					<label for="website">
						<?php

						printf( __( '%s ', 'onelisting' ), $website ); 
						echo ! empty( $require_website ) ? '<strong class="directorist-form-required">*</strong>': '';

						?>
					</label>

					<input id="website" class="directorist-form-element" type="text" name="website" value="<?php echo ( isset( $_REQUEST['website'] ) ? esc_url( $_REQUEST['website'] ) : null ); ?>">

				</div>

			<?php endif; ?>
			
			<?php if ( ! empty( $display_bio ) ) : ?>

				<div class="directorist-form-group directorist-mb-15">
					<label for="bio">
						<?php

						printf(__('%s ', 'onelisting'), $bio); 
						echo !empty($require_bio) ? '<strong class="directorist-form-required">*</strong>': '';

						?>
					</label>

					<textarea id="bio" class="directorist-form-element" name="bio" rows="10"><?php echo ( isset( $_REQUEST['bio']) ? esc_textarea($_REQUEST['bio']) : null ); ?></textarea>
				</div>

			<?php endif; ?>

			<?php if( ! empty( get_directorist_option('display_user_type') ) ) : ?>

				<?php if( empty( $user_type) || 'author' == $user_type ) : ?>

					<div class="atbd_user_type_area directory_regi_btn directorist-radio directorist-radio-circle directorist-mb-15">

							<input id="author_type" type="radio" name="user_type" value='author' <?php echo $author_checked; ?>>

							<label for="author_type" class="directorist-radio__label"><?php _e( 'I am an author', 'onelisting' ); ?>
					</div>

				<?php endif; ?>

				<?php if( empty( $user_type ) || 'general' == $user_type ) : ?>

					<div class="atbd_user_type_area directory_regi_btn directorist-radio directorist-radio-circle directorist-mb-15">

						<input id="general_type" type="radio" name="user_type" value='general' <?php echo $general_checked; ?>>

						<label for="general_type" class="directorist-radio__label"><?php _e( 'I am a user', 'onelisting' ); ?>
					</div>

				<?php endif; ?>

			<?php endif; ?>

			<?php if ( ! empty( get_directorist_option( 'registration_privacy', 1 ) ) ) : ?>

				<div class="atbd_privacy_policy_area directory_regi_btn directorist-checkbox directorist-mb-15">

					<input id="privacy_policy_2" type="checkbox" name="privacy_policy" <?php if ( !empty( $privacy_policy ) ) if ( 'on' == $privacy_policy ) { echo 'checked'; } ?>>

					<label for="privacy_policy_2" class="directorist-checkbox__label"><?php echo esc_attr( $privacy_label ); ?>
					
						<a style="color: red" target="_blank" href="<?php echo esc_url( $privacy_page_link ); ?>"><?php echo esc_attr( $privacy_label_link ); ?></a>

						<span class="directorist-form-required"> * </span></label>
				</div>

			<?php endif; ?>

			<?php if ( ! empty( get_directorist_option( 'regi_terms_condition', 1 ) ) ) : ?>
			
				<div class="atbd_term_and_condition_area directory_regi_btn directorist-checkbox directorist-mb-15">
					<input id="listing_tr" type="checkbox" name="t_c_check" <?php if ( ! empty( $t_c_check ) ) if ( 'on' == $t_c_check ) {
						echo 'checked';
					} ?>>
					<label for="listing_tr" class="directorist-checkbox__label"><?php echo esc_attr( $terms_label ); ?>

						<a style="color: red" target="_blank" href="<?php echo esc_url( $t_C_page_link ); ?>"><?php echo esc_attr( $terms_label_link ); ?></a>

						<span class="directorist-form-required">*</span>
					</label>
				</div>
			<?php endif; ?>
			
			<?php 
			/*
			* @since 4.4.0
			*/
			do_action('atbdp_before_user_registration_submit');
			?>
			<?php if ( ! $display_password_reg ) : ?>

				<div class="directory_regi_btn">

					<p><?php _e( 'Password will be e-mailed to you.','onelisting' ); ?></p>

				</div>

			<?php endif ?>

			<div class="theme-register-btn">

				<?php $redirection_after_reg = get_directorist_option( 'redirection_after_reg' ); ?>

				<?php if( ! empty( $redirection_after_reg ) && 'previous_page' == $redirection_after_reg ) : ?>

					<input type="hidden" name='previous_page' value='<?php echo wp_get_referer(); ?>'>

				<?php endif; ?>

				<button type="submit" class="directorist-btn directorist-btn-primary" name="atbdp_user_submit"><?php printf(__('%s ', 'onelisting'),$reg_signup ); ?></button>
				<input type="hidden" value="<?php echo wp_create_nonce( directorist_get_nonce_key() ); ?>" name="directorist_nonce">
			</div>

			
		</div>
	</form>

	<?php if ( !empty( $display_login ) ) : ?>

		<div class="theme-modal-bottom">

			<p><?php echo $login_text; ?> <a href="#" data-bs-toggle='modal' data-bs-target='#theme-login-modal' data-bs-dismiss='modal'><?php echo $log_linkingmsg;?></a></p>

		</div>

	<?php endif; ?>
		
</div>

