<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */
?>
<section class="no-results not-found theme-no-result">

	<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'onelisting' ); ?></h2>

	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p><?php printf( wp_kses_post( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>', 'onelisting' ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
	
	<?php elseif ( is_search() ) : ?>

		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'onelisting' ); ?></p>
		
		<?php get_search_form(); ?>

	<?php else : ?>

		<p><?php esc_html_e( "It seems we can't find what you're looking for. Perhaps searching can help.", 'onelisting' ); ?></p>
		
		<?php get_search_form(); ?>

	<?php endif; ?>
	
</section>