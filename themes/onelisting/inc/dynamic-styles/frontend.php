<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

Helper::includes( 'dynamic-styles/common.php' );

/*--------------
#-CSS Variables
---------------*/
$primary_color = Helper::get_primary_color(); // #ff385c
$primary_rgb   = Helper::hex2rgb( $primary_color ); // 239, 48, 114
$other_colors  = Theme::$options['other_colors'] ? Theme::$options['other_colors'] : 'primary_color';
$is_custom     = 'custom' === $other_colors ? true : false;

$menu_text_colors       = Theme::$options['menu_text_colors'] ? Theme::$options['menu_text_colors'] : array();
$menu_color_text        = $menu_text_colors['default'] ? $menu_text_colors['default'] : '#51526e';
$menu_hover_color_text  = $is_custom && $menu_text_colors['hover'] ? $menu_text_colors['hover'] : $primary_color;
$menu_active_color_text = $is_custom && $menu_text_colors['active'] ? $menu_text_colors['active'] : $primary_color;

$add_listing_button_text_colors      = Theme::$options['add_listing_button_text_colors'] ? Theme::$options['add_listing_button_text_colors'] : array();
$add_listing_button_text_color       = $add_listing_button_text_colors['default'] ? $add_listing_button_text_colors['default'] : '#fff';
$add_listing_button_text_color_hover = $add_listing_button_text_colors['hover'] ? $add_listing_button_text_colors['hover'] : '#fff';
$add_listing_button_bgcolors         = Theme::$options['add_listing_button_bgcolors'] ? Theme::$options['add_listing_button_bgcolors'] : array();
$add_listing_button_bgcolor          = $is_custom && $add_listing_button_bgcolors['default'] ? $add_listing_button_bgcolors['default'] : $primary_color;
$add_listing_button_bgcolors_hover   = $is_custom && $add_listing_button_bgcolors['hover'] ? $add_listing_button_bgcolors['hover'] : $primary_color;

$banner_bgopacity             = Theme::$options['bgopacity'] ? Theme::$options['bgopacity'] : '60';
$banner_title_color           = Theme::$options['banner_title_color'] ? Theme::$options['banner_title_color'] : '#fff';
$breadcrumb_link_colors       = Theme::$options['breadcrumb_link_colors'] ? Theme::$options['breadcrumb_link_colors'] : array();
$breadcrumb_link_color        = $breadcrumb_link_colors['default'] ? $breadcrumb_link_colors['default'] : '#f8f9fb';
$breadcrumb_link_color_hover  = $is_custom && $breadcrumb_link_colors['hover'] ? $breadcrumb_link_colors['hover'] : $primary_color;
$breadcrumb_link_color_active = $is_custom && $breadcrumb_link_colors['active'] ? $breadcrumb_link_colors['active'] : '#acabac';
$breadcrumb_seperator_color   = Theme::$options['breadcrumb_seperator_color'] ? Theme::$options['breadcrumb_seperator_color'] : '#f8f9fb';

$footer_bgcolor       = Theme::$options['footer_bgcolor'] ? Theme::$options['footer_bgcolor'] : '#ffffff';
$footer_divider_color = Theme::$options['footer_divider_color'] ? Theme::$options['footer_divider_color'] : '#eff1f6';
$footer_title_color   = Theme::$options['footer_title_color'] ? Theme::$options['footer_title_color'] : '#1a1b29';
$footer_text_color    = Theme::$options['footer_text_color'] ? Theme::$options['footer_text_color'] : '#605f74';

$footer_link_colors      = Theme::$options['footer_link_colors'];
$footer_link_color       = $footer_link_colors['default'] ? $footer_link_colors['default'] : '#51526e';
$footer_link_hover_color = $is_custom && $footer_link_colors['hover'] ? $footer_link_colors['hover'] : $primary_color;
?>

<?php
/*--------------
#-CSS Variables
---------------*/
?>

:root {
    --color-primary: <?php echo esc_attr( $primary_color ); ?>;
    --color-primary-rgba: <?php echo esc_attr( $primary_rgb ); ?>;
    --color-primary-rgb-1: rgb(<?php echo esc_attr( $primary_rgb ); ?>, 0.1) ;
    --color-primary-rgb-05: rgb(<?php echo esc_attr( $primary_rgb ); ?>, 0.05);
    --color-primary-rgb-15: rgb(<?php echo esc_attr( $primary_rgb ); ?>, 0.15);

    --color-menu: <?php echo esc_attr( $menu_color_text ); ?>;
    --color-menu-hover: <?php echo esc_attr( $menu_hover_color_text ); ?>;
    --color-menu-active: <?php echo esc_attr( $menu_active_color_text ); ?>;

    --color-add-listing-button-text: <?php echo esc_attr( $add_listing_button_text_color ); ?>;
    --color-add-listing-button-text-hover: <?php echo esc_attr( $add_listing_button_text_color_hover ); ?>;
    --bgcolor-add-listing-button: <?php echo esc_attr( $add_listing_button_bgcolor ); ?>;
    --bgcolor-add-listing-button-hover: <?php echo esc_attr( $add_listing_button_bgcolors_hover ); ?>;

    --banner-bg-opacity: <?php echo esc_attr( $banner_bgopacity ); ?>;
    --color-banner_title: <?php echo esc_attr( $banner_title_color ); ?>;
    --color-breadcrumb-link: <?php echo esc_attr( $breadcrumb_link_color ); ?>;
    --color-breadcrumb-link-hover: <?php echo esc_attr( $breadcrumb_link_color_hover ); ?>;
    --color-breadcrumb-active: <?php echo esc_attr( $breadcrumb_link_color_active ); ?>;
    --color-breadcrumb_separator: <?php echo esc_attr( $breadcrumb_seperator_color ); ?>;

    --bgcolor-footer: <?php echo esc_attr( $footer_bgcolor ); ?>;
    --color-footer-divider: <?php echo esc_attr( $footer_divider_color ); ?>;
    --color-footer-title: <?php echo esc_attr( $footer_title_color ); ?>;
    --color-footer-text: <?php echo esc_attr( $footer_text_color ); ?>;
    --color-footer-link: <?php echo esc_attr( $footer_link_color ); ?>;
    --color-footer-link-hover: <?php echo esc_attr( $footer_link_hover_color ); ?>;
}