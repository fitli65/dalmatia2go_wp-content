<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

use \Directorist\Helper;
use \Directorist\Directorist_Single_Listing;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$listing = Directorist_Single_Listing::instance();
?>

<?php get_header( 'directorist' ); ?>

	<div class="directorist-single">

		<?php Helper::get_template( 'single-contents' ); ?>

	</div>

<?php get_footer( 'directorist' ); ?>