<?php
function homey_enqueue_styles() {
    // enqueue parent styles
    wp_enqueue_style('homey-parent-theme', get_template_directory_uri() .'/style.css');
    // enqueue child styles
    wp_enqueue_style('homey-child-theme', get_stylesheet_directory_uri() .'/style.css', array('homey-parent-theme'));
}
add_action('wp_enqueue_scripts', 'homey_enqueue_styles', PHP_INT_MAX);

// Enque custom scripts
function ml_main_scripts() {
    wp_dequeue_script( 'homey-custom' );
    wp_enqueue_script('ml-custom', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), '1.0', true);
    wp_enqueue_script( 'ml-main', get_stylesheet_directory_uri() .'/js/ml-main.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'ml_main_scripts', 100 );

// Remove Block Editor from Widgets
function homey_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'homey_theme_support' );

// Remove double google api from directorist plugin
function remove_google_api_frontend( $url, $handle ) {
    if ( 'google-map-api' === $handle ) {$url = '';}
    return $url;
}
add_filter( 'script_loader_tag', 'remove_google_api_frontend', 10, 3 );

// Deactivate Eicons at Elementor
function js_dequeue_eicons() {

  // Don't remove it in the backend
  if ( is_admin() || current_user_can( 'manage_options' ) ) {
        return;
  }
  wp_dequeue_style( 'elementor-icons' );
  wp_deregister_style( 'elementor-icons' );
}
add_action( 'elementor/frontend/after_enqueue_styles', 'js_dequeue_eicons', 20 );


?>
