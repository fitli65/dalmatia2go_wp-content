<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use \wpWax\OneListing\Helper;
?>
<div class="<?php Helper::the_sidebar_class(); ?>">

	<aside class="sidebar-widget-area">

		<?php
		do_action( 'wpwaxtheme_before_sidebar' );

		dynamic_sidebar( 'sidebar' );

		do_action( 'wpwaxtheme_after_sidebar' );
		?>

	</aside>
	
</div>