<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use wpWax\OneListing\Helper;

if ( post_password_required() ) {
	return;
}

if ( ! have_comments() && ! comments_open() ) {
	return;
}

$post_id         = get_the_ID();
$comments_number = get_comments_number();
$comments_text   = sprintf( _n( '%s Comment', '%s Comments', $comments_number, 'onelisting' ), number_format_i18n( $comments_number ) );
$comment_args    = array(
	'callback' => 'wpWax\OneListing\Helper::comments_callback',
);

$comment_form_fields = array(
	'author'        => '<div class="col-md-6"><input name="author" type="text" placeholder="' . esc_attr_x( 'Name*', 'placeholder', 'onelisting' ) . '" class="form-control m-bottom-30" required></div>',
	'email'         => '<div class="col-md-6"><input name="email" type="email" placeholder="' . esc_attr_x( 'Email*', 'placeholder', 'onelisting' ) . '" class="form-control m-bottom-30" required></div>',
	'url'           => '',
	'cookies'       => '',
);

$comment_form_args = array(
	'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="btn theme-btn btn-primary %3$s" value="' . esc_attr_x( 'Post Comment', 'submit button', 'onelisting' ) . '">',
	'submit_field'         => '<div class="col-md-12"><p class="form-submit m-bottom-0">%1$s %2$s</p></div>',
	'title_reply_before'   => '<h3 class="m-bottom-10">',
	'title_reply_after'    => '</h3>',
	'class_form'           => 'comment_form_wrapper row',
	'comment_notes_before' => '<div class="col-md-12"><p class="comment-notes m-bottom-40"><span id="email-notes">' . esc_html__( 'Your email address will not be published.', 'onelisting' ) . '</span></p></div>',
	'fields'               => apply_filters( 'comment_form_default_fields', $comment_form_fields ),
    'comment_field'        => '<div class="col-md-12"><div class="comment-form-comment"><textarea class="form-control m-bottom-30" id="comment" name="comment" placeholder="' . esc_attr_x( 'Your Text', 'placeholder', 'onelisting' ) . '" aria-required="true"></textarea></div></div>',
    'logged_in_as'         => sprintf(
        '<div class="col-md-12"><p class="logged-in-as">%s</p></div>',
        sprintf(
            __( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>', 'onelisting' ),
            get_edit_user_link(),
            esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.', 'onelisting' ), $user_identity ) ),
            $user_identity,
            wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
        ),
    ),
);
?>

<div class="comments-area m-top-50 m-bottom-60" id="comments">

    <?php if ( have_comments() ): ?>

        <div class="comment-title">

            <h3><?php echo esc_html( $comments_text ); ?></h3>

        </div>

        <div class="comment-lists">

            <ul class="media-list list-unstyled">

                <?php wp_list_comments( $comment_args ); ?>

            </ul>

        </div>

        <div class="comment-pagination">

            <nav class="navigation pagination d-flex justify-content-center" role="navigation">

                <div class="nav-links">

                    <?php paginate_comments_links(
                        array(
                            'prev_text' => Helper::get_svg_icon( 'long-arrow-alt-left-solid'),
                            'next_text' => Helper::get_svg_icon( 'long-arrow-alt-right-solid'),
                        )
                    );
                    ?>

                </div>

            </nav>

        </div>

    <?php endif; ?>

</div>

<?php if ( comments_open() ): ?>

    <?php comment_form( $comment_form_args ); ?>

<?php else: ?>

    <div class="no-comments"><?php esc_html_e( 'Comments are closed.', 'onelisting' ); ?></div>
    
<?php endif;