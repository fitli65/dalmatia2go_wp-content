<?php
/**
 * Template Name: Blank Template
 *
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */
?>

<?php get_header(); ?>

<div <?php post_class(); ?> id="page-<?php the_ID(); ?>">

	<?php the_content(); ?>

</div>

<?php
get_footer();
