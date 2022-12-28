
                    <?php
                        // start recovery stuff
                        $recovery = isset( $_GET['user'] ) ? $_GET['user'] : '';
                        $key      = isset( $_GET['key'] ) ? $_GET['key'] : '';

                        if ( ! empty( $recovery ) ) {
                            $user = get_user_by( 'email', $recovery );
                            if ( isset( $_POST['directorist_reset_password'] ) && 'true' == $_POST['directorist_reset_password'] ) {
                                $password_1 = isset( $_POST['password_1'] ) ? $_POST['password_1'] : '';
                                $password_2 = isset( $_POST['password_2'] ) ? $_POST['password_2'] : '';

                                if (  ( $password_1 === $password_2 ) && ! empty( $password_1 && $password_2 ) ) {
                                    $update_user = wp_update_user( [
                                        'ID'        => $user->ID,
                                        'user_pass' => $password_2,
                                    ] );
                                if ( $update_user ) {
                                    ?><p class="atbd_reset_success"><?php echo esc_html__( 'Password changed successfully!', 'onelisting' );
                ?>
                                        <a href="<?php echo esc_url( ATBDP_Permalink::get_login_page_url() ) ?>"><?php echo esc_html__( ' Login', 'onelisting' );
                ?></a>
                                    </p><?php
                                            }
                                                } elseif ( empty( $password_1 || $password_2 ) ) {
                                                    ?><p class="atbd_reset_warning"><?php echo esc_html__( 'Fields are required!', 'onelisting' ); ?></p><?php
} else {
            ?><p class="atbd_reset_error"><?php echo esc_html__( 'Password not matched!', 'onelisting' ); ?></p><?php
    }
        }

        $db_key = get_user_meta( $user->ID, '_atbdp_recovery_key', true );
        if ( $key === $db_key ) {
            do_action( 'directorist_before_reset_password_form' );
        ?>
                            <form method="post" class="directorist-ResetPassword lost_reset_password">
                                <p><?php echo apply_filters( 'directorist_reset_password_message', esc_html__( 'Enter a new password below.', 'onelisting' ) ); ?></p>
                                <p>
                                    <label for="password_1"><?php esc_html_e( 'New password', 'onelisting' );?> &nbsp;<span class="required">*</span></label>
                                    <input type="password" class="directorist-Input directorist-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" />
                                </p>
                                <p>
                                    <label for="password_2">
                                        <?php esc_html_e( 'Re-enter new password', 'onelisting' );?>&nbsp;
                                        <span class="required">*</span>
                                    </label>
                                    <input type="password" class="directorist-Input directorist-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" />
                                </p>

                                <div class="clear"></div>

                                <?php do_action( 'directorist_resetpassword_form' );?>

                                <p class="directorist-form-row form-row">
                                    <input type="hidden" name="directorist_reset_password" value="true" />
                                    <button type="submit" class="btn btn-primary" value="<?php esc_attr_e( 'Save', 'onelisting' );?>"><?php esc_html_e( 'Save', 'onelisting' );?></button>
                                </p>

                            <?php wp_nonce_field( 'reset_password', 'directorist-reset-password-nonce' );
                                    } else {
                                    ?>
                                <p><?php echo apply_filters( 'directorist_reset_password_link_exp_message', esc_html__( 'Sorry! The link is invalid.', 'onelisting' ) ); ?></p>
                            <?php }
                                } else {
                                    $redirection = ATBDP_Permalink::get_login_redirection_page_link();
                                    $data        = [
                                        'ajax_url'            => admin_url( 'admin-ajax.php' ),
                                        'redirect_url'        => $redirection ? $redirection : ATBDP_Permalink::get_dashboard_page_link(),
                                        'loading_message'     => esc_html__( 'Sending user info, please wait...', 'onelisting' ),
                                        'login_error_message' => esc_html__( 'Wrong username or password.', 'onelisting' ),
                                    ];
                                    wp_localize_script( 'directorist-main-script', 'ajax_login_object', $data );

                                    $log_username        = get_directorist_option( 'log_username', esc_html__( 'Username or Email Address', 'onelisting' ) );
                                    $log_password        = get_directorist_option( 'log_password', esc_html__( 'Password', 'onelisting' ) );
                                    $display_rememberMe  = get_directorist_option( 'display_rememberme', 1 );
                                    $log_rememberMe      = get_directorist_option( 'log_rememberme', esc_html__( 'Remember Me', 'onelisting' ) );
                                    $log_button          = get_directorist_option( 'log_button', esc_html__( 'Log In', 'onelisting' ) );
                                    $display_recpass     = get_directorist_option( 'display_recpass', 1 );
                                    $recpass_text        = get_directorist_option( 'recpass_text', esc_html__( 'Recover Password', 'onelisting' ) );
                                    $recpass_desc        = get_directorist_option( 'recpass_desc', esc_html__( 'Lost your password? Please enter your email address. You will receive a link to create a new password via email.', 'onelisting' ) );
                                    $recpass_username    = get_directorist_option( 'recpass_username', esc_html__( 'E-mail:', 'onelisting' ) );
                                    $recpass_placeholder = get_directorist_option( 'recpass_placeholder', esc_html__( 'eg. mail@example.com', 'onelisting' ) );
                                    $recpass_button      = get_directorist_option( 'recpass_button', esc_html__( 'Get New Password', 'onelisting' ) );
                                    $reg_text            = get_directorist_option( 'reg_text', esc_html__( "Don't have an account?", 'onelisting' ) );
                                    $reg_url             = ATBDP_Permalink::get_registration_page_link();
                                    $reg_linktxt         = get_directorist_option( 'reg_linktxt', esc_html__( 'Sign Up', 'onelisting' ) );
                                    $display_signup      = get_directorist_option( 'display_signup', 1 );
                                ?>

                            <form action="#" id="login" method="POST">
                                <div class="directorist-form-group directorist-mb-15">
                                    <input type="text" class="directorist-form-element" id="username" name="username" placeholder="<?php echo esc_attr( $log_username ); ?>">
                                </div>

                                <div class="directorist-form-group directorist-mb-15">
                                    <input type="password" id="password" autocomplete="off" name="password" class="directorist-form-element" placeholder="<?php echo esc_attr( $log_password ); ?>">
                                </div>

                                <div class="directorist-form-group directorist-mb-15">
                                    <button class="directorist-btn directorist-btn-block theme-login-modal__btn directorist-btn-primary" type="submit" value="<?php echo esc_attr( $log_button ); ?>" name="submit"><?php echo esc_html( $log_button ); ?></button>
                                    <?php wp_nonce_field( 'ajax-login-nonce', 'security' );?>
                                </div>
                                <p class="status"></p>

                                <div class="d-flex justify-content-between align-items-center">
                                <div class="theme-keep-signed directorist-checkbox directorist-mb-15">
                                    <?php
                                        if ( $display_rememberMe ) {
                                            ?>
                                        <input type="checkbox" id="keep_signed_in" value="1" name="keep_signed_in" checked>
                                        <label for="keep_signed_in" class="directorist-checkbox__label not_empty">
                                            <?php echo esc_attr( $log_rememberMe ); ?>
                                        </label>
                                </div>
                                <?php
                                        }
                                            if ( $display_recpass ) {
                                                printf( wp_kses_post(__( '<p class="atbdp_recovery_pass-wrapper">%s</p>', 'onelisting' ) ), "<a href='#' class='atbdp_recovery_pass'> " . esc_html( $recpass_text ) . '</a>' );
                                            }
                                        ?>
                                </div>
                            </form>

                            <div class="atbd_social_login">
                                <?php do_action( 'atbdp_before_login_form_end' );?>
                            </div>

                            <?php if ( ! empty( $display_signup ) ) {?>
                                <p class="mb-0 not-account">
                                    <?php echo esc_html( $reg_text ); ?>
                                    <a href="<?php echo esc_url( $reg_url ); ?>"><?php echo esc_html( $reg_linktxt ); ?></a>
                                </p>
                            <?php }
                                    //stuff to recover password start
                                    $error = $success = '';
                                    // check if we're in reset form
                                    if ( isset( $_POST['action'] ) && 'reset' == $_POST['action'] ) {
                                        $email = trim( $_POST['user_login'] );
                                        if ( empty( $email ) ) {
                                            $error = esc_html__( 'Enter an e-mail address..', 'onelisting' );
                                        } else if ( ! is_email( $email ) ) {
                                            $error = esc_html__( 'Invalid e-mail address.', 'onelisting' );
                                        } else if ( ! email_exists( $email ) ) {
                                            $error = esc_html__( 'There is no user registered with that email address.', 'onelisting' );
                                        } else {
                                            $random_password = wp_generate_password( 22, false );
                                            $user            = get_user_by( 'email', $email );
                                            $update_user     = update_user_meta( $user->ID, '_atbdp_recovery_key', $random_password );
                                            // if  update user return true then lets send user an email containing the new password
                                            if ( $update_user ) {
                                                $subject = esc_html__( '	Password Reset Request', 'onelisting' );
                                                //$message = esc_html__('Your new password is: ', 'onelisting') . $random_password;

                                                $site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
                                                $message   = esc_html__( 'Someone has requested a password reset for the following account:', 'onelisting' ) . '<br>';
                                                /* translators: %s: site name */
                                                $message .= sprintf( esc_html__( 'Site Name: %s', 'onelisting' ), $site_name ) . '<br>';
                                                /* translators: %s: user login */
                                                $message .= sprintf( esc_html__( 'User: %s', 'onelisting' ), $user->user_login ) . '<br>';
                                                $message .= esc_html__( 'If this was a mistake, just ignore this email and nothing will happen.', 'onelisting' ) . '<br>';
                                                $message .= esc_html__( 'To reset your password, visit the following address:', 'onelisting' ) . '<br>';
                                                $link = [
                                                    'key'  => $random_password,
                                                    'user' => $email,
                                                ];
                                                $message .= '<a href="' . esc_url( add_query_arg( $link, ATBDP_Permalink::get_login_page_url() ) ) . '">' . esc_url( add_query_arg( $link, ATBDP_Permalink::get_login_page_url() ) ) . '</a>';

                                                $message = atbdp_email_html( $subject, $message );

                                                $headers[] = 'Content-Type: text/html; charset=UTF-8';
                                                $mail      = class_exists( 'onelisting_CoreHelper' ) ? onelisting_CoreHelper::get_onelisting_mail( $email, $subject, $message, $headers ) : '' ;
                                                if ( $mail ) {
                                                    $success = esc_html__( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox.', 'onelisting' );
                                                } else {
                                                    $error = esc_html__( 'Password updated! But something went wrong sending email.', 'onelisting' );
                                                }
                                            } else {
                                                $error = esc_html__( 'Oops something went wrong updating your account.', 'onelisting' );
                                            }
                                        }

                                        if ( ! empty( $error ) ) {
                                            echo wp_kses_post( '<div class="message"><p class="error"><strong>' . esc_html__( 'ERROR:', 'onelisting' ) . '</strong> ' . $error . '</p></div>' );
                                        }

                                        if ( ! empty( $success ) ) {
                                            echo wp_kses_post( '<div class="error_login"><p class="success">' . $success . '</p></div>' );
                                        }

                                }?>
                            <div id="recover-pass-modal" class="directorist-mt-15">
                                <form method="post">
                                    <fieldset class="directorist-form-group">
                                        <p><?php echo wp_kses_post( $recpass_desc ); ?></p>
                                        <label for="reset_user_login"><?php echo wp_kses_post( $recpass_username );?></label>
                                        <?php $user_login = isset( $_POST['user_login'] ) ? $_POST['user_login'] : '';?>
                                        <input type="text" class="directorist-form-element directorist-mb-15" name="user_login" id="reset_user_login" value="<?php echo esc_attr( $user_login ); ?>" placeholder="<?php echo esc_attr( $recpass_placeholder ); ?>" required />
                                        <p class="mb-0 directorist-mt-15">
                                            <input type="hidden" name="action" value="reset" />
                                            <button type="submit" class="directorist-btn directorist-btn-primary"><?php echo wp_kses_post( $recpass_button ); ?></button>
                                        </p>
                                    </fieldset>
                                </form>
                            </div>
<?php }?>