<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use \wpWax\OneListing\Helper;
use \wpWax\OneListing\Theme;

if ( ! Theme::$has_banner ) {
	return;
}

if( is_404() )  {
	return;
}
?>
<div class="banner theme-banner-breadcrumb">

	<div class="theme-banner-content theme-breadcrumb-banner">

		<div class="container">

			<h1><?php echo wp_kses_post( Helper::get_page_title() ); ?></h1>

			<?php if ( Theme::$has_breadcrumb && Helper::has_breadcrumb_support() ): ?>

				<div class="main-breadcrumb"><?php Helper::the_breadcrumb(); ?></div>

			<?php endif;?>
		</div>

	</div>

</div>