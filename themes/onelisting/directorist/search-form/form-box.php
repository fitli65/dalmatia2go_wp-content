<?php
/**
 * @author  wpWax
 * @since   7.2.2
 * @version 7.2.2
 */

use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-search-form-box">

	<div class="directorist-search-form-top directorist-flex directorist-align-center directorist-search-form-inline">					

		<input type="hidden" name="directory_type" class="listing_type" value="<?php echo esc_attr( $searchform->listing_type_slug() ); ?>">

		<?php
		foreach ( $searchform->form_data[0]['fields'] as $field ) {
			$searchform->field_template( $field );
		}
		?>

	</div>

	<?php
	if ( $searchform->more_filters_display == 'always_open' ) {
		$searchform->advanced_search_form_fields_template();
	}
	else {
		if ( $searchform->has_more_filters_button ) {
			?>
			<div class="<?php Helper::search_filter_class( $searchform->more_filters_display ); ?>">
				<?php $searchform->advanced_search_form_fields_template(); ?>
			</div>
			<?php
		}
	}
	?>

</div>

<?php
// Search buttons.
if ( $searchform->more_filters_display !== 'always_open' ) {
	$searchform->more_buttons_template();
}
?>