<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use \wpWax\OneListing\Helper;

$post_class = Helper::has_sidebar() ? 'col-md-6 col-12' : 'col-lg-4 col-md-6 col-12';

get_header(); 
?>
<div id="primary" class="content-area site-index">

	<div class="theme-blog-grid-area">
		
		<div class="theme-container">

			<div class="row">

				<?php Helper::left_sidebar(); ?>

				<div class="<?php Helper::the_layout_class(); ?>">

					<div id="main-content" class="main-content">
						
						<?php if ( have_posts() ) : ?>

							<div class="row " data-masonry='{"percentPosition": true }'>

								<?php while ( have_posts() ) : the_post(); ?>

									<div class="<?php echo esc_attr( $post_class ); ?>">

										<?php get_template_part( 'template-parts/content-blog' ); ?>

									</div>

								<?php endwhile; ?>

							</div>

						<?php else: ?>

							<?php get_template_part( 'template-parts/content', 'none' ); ?>

						<?php endif; ?>

					</div>

					<div class="theme-pagination-area">

						<?php echo Helper::get_paginate_links(); ?>

					</div>

				</div>

				<?php Helper::right_sidebar(); ?>

			</div>

		</div>
		
	</div>
	
</div>
<?php get_footer(); ?>