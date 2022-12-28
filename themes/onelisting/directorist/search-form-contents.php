<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.3.1
 */

use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="directorist-search-contents" data-atts='<?php echo esc_attr( $searchform->get_atts_data() ); ?>'>

	<?php do_action( 'directorist_search_listing_before_title' ); ?>

	<?php if ( $searchform->show_title_subtitle && ( $searchform->search_bar_title || $searchform->search_bar_sub_title ) ) : ?>

		<div class="directorist-search-top">

			<?php if ( $searchform->search_bar_title ) : ?>
				<h2 class="directorist-search-top__title"><?php echo esc_html( $searchform->search_bar_title ); ?></h2>
			<?php endif; ?>

			<?php if ( $searchform->search_bar_sub_title ) : ?>
				<p class="directorist-search-top__subtitle"><?php echo esc_html( $searchform->search_bar_sub_title ); ?></p>
			<?php endif; ?>

		</div>

	<?php endif; ?>

	<?php
	$class			= '';
	$multi_directory = get_directorist_option( 'enable_multi_directory', false );
	if ( ! empty( $multi_directory ) && ( count( $searchform->get_listing_type_data() ) > 1 ) ) {
		$class = 'enable-multi-directory';
	} else {
		$class = 'disable-multi-directory';
	}
	?>

	<form action="<?php echo esc_url( ATBDP_Permalink::get_search_result_page_link() ); ?>" class="directorist-search-form" data-atts="<?php echo esc_attr( $searchform->get_atts_data() ); ?>">
	
		<?php $searchform->directory_type_nav_template(); ?>
	
		<div class="directorist-search-form-wrap">
			
			<?php Helper::get_template( 'search-form/form-box', [ 'searchform' =>  $searchform ] ); ?>
			
		</div>

	</form>

	<?php do_action( 'directorist_search_listing_after_search_bar' ); ?>

	<?php $searchform->top_categories_template(); ?>

</div>