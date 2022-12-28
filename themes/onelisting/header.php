<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */
?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="profile" href="https://gmpg.org/xfn/11" />

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div id="page" class="site">

		<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'onelisting' ); ?></a>

		<header id="site-header" class="menu-area <?php do_action( 'top_header_menu_area_class'); ?> sticky-top">

			<?php get_template_part( 'template-parts/content-header' ); ?>

		</header>
		<span class="theme-mobile-menu-overlay"></span>
		<div id="content" class="site-content">
		
			<?php get_template_part( 'template-parts/content', 'banner' ); ?>