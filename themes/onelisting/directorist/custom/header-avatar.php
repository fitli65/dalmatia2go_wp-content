<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use wpWax\OneListing\Directorist_Support;
?>

<div class="theme-header-action__author--info">

	<?php
	$avatar_img = get_avatar( get_current_user_id(), 40, null, null, array( 'class' => 'rounded-circle' ) );
	$author_id     = get_user_meta( get_current_user_id(), 'pro_pic', true );
	$profile_image = wp_get_attachment_image_src( $author_id );

	if ( empty( $profile_image ) ) {
		echo wp_kses_post( $avatar_img );
		if( atbdp_is_page( 'dashboard' ) ){
			printf( '<span> %s,<span/> %s ', esc_html__( 'Hi', 'onelisting' ) , get_the_author_meta('display_name', get_current_user_id() ) ) ;
		}

	} else {
		printf( '<img width="40" src="%s" class="avatar rounded-circle"/>', esc_url( $profile_image[0] ) );
	}
	?>

	<div class="theme-header-author-navigation">

		<?php echo Directorist_Support::get_dashboard_navigation(); ?>

	</div>

</div>										