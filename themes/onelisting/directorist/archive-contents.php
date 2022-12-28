<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.2.1
 */

use wpWax\OneListing\Directorist_Support;

if ( ! defined( 'ABSPATH' ) ) exit;

$is_elementor	 = isset( $listings->atts['is_elementor'] )  ? true : false;
$version_7_2_1	 = version_compare( ATBDP_VERSION, "7.2.1", ">=" );
$current_page_id = isset( $_REQUEST['current_page_id'] ) ? esc_attr( $_REQUEST['current_page_id'] ) : get_the_ID();
?>

<?php if ( $version_7_2_1 ) : ?>

	<div <?php $listings->wrapper_class(); $listings->data_atts(); ?>>

<?php else : ?>

	<div <?php $listings->wrapper_class(); ?>>

<?php endif; ?>
	
	<?php if ( Directorist_Support::show_title( $current_page_id ) ): ?>

		<div class="row">

			<div class="col-12">

				<h2 class="directorist-archive-title"><?php echo Directorist_Support::get_header_title( $current_page_id ); ?></h2>

			</div>

		</div>

	<?php endif;?>

	<?php
	$listings->directory_type_nav_template();
	$listings->header_bar_template();
	$listings->archive_view_template();
	?>

</div>