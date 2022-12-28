<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use \wpWax\OneListing\Theme;

$footer_columns = 0;

foreach ( range( 1, 4 ) as $i ) {

	if ( is_active_sidebar( 'footer-' . $i ) ) {
		$footer_columns++;
	}

}

switch ( $footer_columns ) {
	case '1':
		$footer_class = 'col-sm-12 col-12';
		break;
	case '2':
		$footer_class = 'col-sm-6 col-12';
		break;
	case '3':
		$footer_class = 'col-md-4 col-sm-12 col-12';
		break;
	default:
		$footer_class = 'col-lg-3 col-sm-6 col-12';
		break;
}
?>
</div><!-- #content -->

<footer class="site-footer">

	<?php if ( Theme::$options['footer_area'] && $footer_columns ): ?>

		<div class="theme-footer-top-area">

			<div class="theme-container">

				<div class="row">

					<?php foreach ( range( 1, 4 ) as $i ) :

						if ( ! is_active_sidebar( 'footer-' . $i ) ) {
							continue;
						}
						?>

						<div class="<?php echo esc_attr( $footer_class ); ?>">

							<?php dynamic_sidebar( 'footer-' . $i ); ?>

						</div>

					<?php endforeach; ?>

				</div>

			</div>

		</div>

	<?php endif;?>

	<?php if ( Theme::$options['copyright_area'] ): ?>

		<div class="theme-footer-bottom-area">

			<div class="theme-container">

				<div class="row">

					<div class="col-md-12">

						<div class="theme-copyright-text"><?php echo do_shortcode( Theme::$options['copyright_text'] ); ?></div>

					</div>

				</div>

			</div>

		</div>

	<?php endif; ?>

</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>