<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php the_content(); ?>

	<?php 	( array( 'before' => '<div class="page-links">', 'after'  => '</div>', 'link_before' => '<span class="page-number">', 'link_after'  => '</span>' ) ); ?>

</div>