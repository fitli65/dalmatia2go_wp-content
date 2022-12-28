<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

$theme_data = wp_get_theme( get_template() );

if ( ONELISTING_THEME == 'pro' ) {
	$item_id = 66670;
}
else {
	$item_id = 71979;
}

// Loads the updater classes
$updater = new Directorist_Theme_Updater_Admin(
	// Config settings
	array(
		'remote_api_url' => 'https://directorist.com', // Site where EDD is hosted
		'item_id'        => $item_id, // ID of item in site where EDD is hosted
		'version'        => $theme_data->get( 'Version' ), // The current version of this theme
		'author'         => $theme_data->get( 'Author' ), // The author of this theme
	),
	// Strings
	array(
		'theme-license'             => __( 'Theme License', 'onelisting' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'onelisting' ),
		'license-key'               => __( 'License Key', 'onelisting' ),
		'license-action'            => __( 'License Action', 'onelisting' ),
		'deactivate-license'        => __( 'Deactivate License', 'onelisting' ),
		'activate-license'          => __( 'Activate License', 'onelisting' ),
		'status-unknown'            => __( 'License status is unknown.', 'onelisting' ),
		'renew'                     => __( 'Renew?', 'onelisting' ),
		'unlimited'                 => __( 'unlimited', 'onelisting' ),
		'license-key-is-active'     => __( 'License key is active.', 'onelisting' ),
		/* translators: the license expiration date */
		'expires%s'                 => __( 'Expires %s.', 'onelisting' ),
		'expires-never'             => __( 'Lifetime License.', 'onelisting' ),
		/* translators: 1. the number of sites activated 2. the total number of activations allowed. */
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'onelisting' ),
		'activation-limit'          => __( 'Your license key has reached its activation limit.', 'onelisting' ),
		/* translators: the license expiration date */
		'license-key-expired-%s'    => __( 'License key expired %s.', 'onelisting' ),
		'license-key-expired'       => __( 'License key has expired.', 'onelisting' ),
		/* translators: the license expiration date */
		'license-expired-on'        => __( 'Your license key expired on %s.', 'onelisting' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'onelisting' ),
		'license-is-inactive'       => __( 'License is inactive.', 'onelisting' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'onelisting' ),
		'license-key-invalid'       => __( 'Invalid license.', 'onelisting' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'onelisting' ),
		/* translators: the theme name */
		'item-mismatch'             => __( 'This appears to be an invalid license key for %s.', 'onelisting' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'onelisting' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'onelisting' ),
		'error-generic'             => __( 'An error occurred, please try again.', 'onelisting' ),
	)
);
