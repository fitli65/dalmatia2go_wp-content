<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use \wpWax\OneListing\Helper;

if ( class_exists( 'Directorist_Base' ) ) {

	if ( atbdp_is_page( 'dashboard' ) && is_user_logged_in() ) {
		Helper::get_template_part( "directorist/custom/directorist-page" );
		return;
	}

	if ( class_exists( 'BD_Map_View' ) && atbdp_is_page( 'all-listing' ) ) {
		$is_lwm_active = strpos( get_the_content(), 'listings_with_map' );
		
		if ( $is_lwm_active ) {
			Helper::get_template_part( "directorist/custom/directorist-page" );
	
			return;
		}
	}
}

get_header();
?>
<div id="primary" class="content-area<?php do_action( 'onelisting_content_area_class'); ?>">

	<div class="theme-container">

		<div class="row">

			<?php Helper::left_sidebar(); ?>

			<div class="<?php Helper::the_layout_class(); ?>">

				<div class="main-content">

					<?php
					while ( have_posts() ){
						the_post();
						get_template_part( 'template-parts/content', 'page' );
						if ( comments_open() || get_comments_number() ){
							comments_template();
						}
					}
					?>

				</div>

			</div>

			<?php Helper::right_sidebar(); ?>

		</div>

	</div>

</div>
<?php get_footer(); ?>