<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.3.1
 */

use \Directorist\Directorist_Single_Listing;
use \Directorist\Helper;
use wpWax\OneListing\Helper as OneListingHelper;

if ( ! defined( 'ABSPATH' ) ) exit;

$listing		 = Directorist_Single_Listing::instance();
$show_similars	 = get_directorist_type_option( $listing->type, 'show_similar_listings', true );
$label			 = get_directorist_type_option( $listing->type, 'similar_listings_label', esc_html__( 'Similar Properties', 'onelisting' ) );
$similar_listing = array( 
	'listing' => $listing,
	'label'	  => $label,
	'class'	  => '',
	'id'	  => ''
);

?>

<?php if ( $listing->single_page_enabled() ) : ?>

	<div class="directorist-single-contents-area directorist-w-100">

		<div class="<?php Helper::directorist_container(); ?>">

			<?php $listing->notice_template(); ?>

			<div class="<?php Helper::directorist_row(); ?>">

				<div class="<?php Helper::directorist_single_column(); ?>">

					<?php Helper::get_template( 'single/top-actions' ); ?>

					<div class="directorist-single-wrapper custom-listing-wrapper">

						<?php echo $listing->single_page_content(); ?>

					</div>

				</div>

				<?php Helper::get_template( 'single-sidebar' ); ?>

			</div>

		</div>
		
	</div>

<?php else: ?>

	<div class="directorist-single-contents-area directorist-w-100">
		
		<?php OneListingHelper::get_template_part( 'directorist/custom/single-header-slider', $listing ); ?>

		<?php $listing->header_template(); ?>
		
		<div class="directorist-single-listing-content">

			<div class="theme-container">

				<?php $listing->notice_template(); ?>

				<div class="directorist-row">
					
					<div class="directorist-col-12">

						<?php Helper::get_template( 'single/top-actions' ); ?>
						
					</div>

					<div class="<?php Helper::directorist_single_column(); ?>">

						<div class="directorist-single-wrapper">

							<?php
							foreach ( $listing->content_data as $section ) {
								$listing->section_template( $section );
							}
							?>

						</div>

					</div>

					<?php Helper::get_template( 'single-sidebar' ); ?>

				</div>

			</div>
			
		</div>

		<?php if ( $show_similars ):  ?>
			
			<div class="directorist-similar-properties">

				<div class="theme-container">

					<div class="row">

						<div class="col-12">

							<?php Helper::get_template( 'single/section-related_listings', $similar_listing ); ?>

						</div>

					</div>
					
				</div>
				
			</div>
			
		<?php endif; ?>
		
	</div>

<?php endif; ?>