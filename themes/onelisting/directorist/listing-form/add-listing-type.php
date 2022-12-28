<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.4.0
 */

use wpWax\OneListing\Theme;
use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>


<div class="directorist-add-listing-types directorist-w-100">

	<div class="directorist-row">

		<div class="cdirectorist-col-12">
			
			<h1 class="directorist-add-listing-title"><?php echo isset( Theme::$options['choose_listing_type_text'] ) ? esc_html( Theme::$options['choose_listing_type_text'] ) : esc_html__( 'Choose listing type', 'onelisting' ); ?></h1>
		
		</div>

	</div>

	<div class="<?php Helper::directorist_row();?> directorist-justify-content-center ">

		<?php foreach ( $listing_form->get_listing_types() as $id => $value ): ?>

			<div class="<?php Helper::directorist_column( array('lg-3', 'md-4', 'sm-6') );?>">

				<div class="directorist-add-listing-types__single">

					<a href="<?php echo esc_url( add_query_arg( 'directory_type', $value['term']->slug ) ); ?>" class="directorist-add-listing-types__single__link">
						
						<?php directorist_icon( $value['data']['icon'] ); ?>
						<span><?php echo esc_html( $value['name'] ); ?></span>
					</a>

				</div>

			</div>

		<?php endforeach;?>

	</div>

</div>