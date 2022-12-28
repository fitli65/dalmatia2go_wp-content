<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

class TGM_Config {

	public $prefix;
	public $path;

	public function __construct() {
		$this->prefix = Constants::$theme_prefix;
		$this->path   = Constants::$theme_plugins_dir;

		add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
	}

	public function register_required_plugins() {
		$plugins = array(
			array(
				'name'     => esc_html__( 'OneListing Toolkit', 'onelisting' ),
				'slug'     => 'onelisting-toolkit',
				'source'   => 'http://demo.directorist.com/theme/demo-content/onelisting-toolkit.zip',
				'version'  => '1.2',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'WpWax Demo Importer', 'onelisting' ),
				'slug'     => 'wpwax-demo-importer',
				'source'   => 'http://demo.directorist.com/theme/demo-content/wpwax-demo-importer.zip',
				'version'  => '1.0',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Elementor Page Builder', 'onelisting' ),
				'slug'     => 'elementor',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Directorist – Business Directory Plugin', 'onelisting' ),
				'slug'     => 'directorist',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Contact Form 7', 'onelisting' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'MC4WP: Mailchimp for WordPress', 'onelisting' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			),
		);

		$config = array(
			'id'           => $this->prefix, // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => $this->path, // Default absolute path to bundled plugins.
			'menu'         => $this->prefix . '-install-plugins', // Menu slug.
			'is_automatic' => false, // Automatically activate plugins after installation or not.
		);

		tgmpa( $plugins, $config );
	}
}

new TGM_Config;