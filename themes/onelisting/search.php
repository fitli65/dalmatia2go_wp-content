<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use \wpWax\OneListing\Helper;

get_header();
?>
<div id="primary" class="content-area site-search">

	<div class="theme-container">

		<div class="row">

			<?php Helper::left_sidebar(); ?>

			<div class="<?php Helper::the_layout_class(); ?>">

				<div class="main-content">

					<?php if ( have_posts() ) :?>

						<div class="row">

							<?php while ( have_posts() ) : the_post(); ?>

								<div class="col-lg-4 col-md-6 col-12">

									<?php get_template_part( 'template-parts/content', 'blog' ); ?>
								
								</div>

							<?php endwhile; ?>
							
						</div>

					<?php else: ?>

						<?php get_template_part( 'template-parts/content', 'none' ); ?>

					<?php endif; ?>

				</div>

				<?php get_template_part( 'template-parts/pagination' ); ?>

			</div>

			<?php Helper::right_sidebar(); ?>

		</div>

	</div>
	
</div>
<?php get_footer(); ?>