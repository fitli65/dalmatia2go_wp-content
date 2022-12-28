<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use \wpWax\OneListing\Helper;

get_header();
?>
<div id="primary" class="content-area theme-single-blog">

	<div class="theme-container">

		<div class="row">

			<?php Helper::left_sidebar(); ?>

			<div class="<?php Helper::the_layout_class(); ?>">

				<div class="main-content">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php
						get_template_part( 'template-parts/content-single' );
						
						if ( comments_open() || get_comments_number() ): ?>

							<div class="comments-wrapper">

								<?php comments_template(); ?>
								
							</div>

						<?php 
						endif;

					endwhile; ?>

				</div>

			</div>

			<?php Helper::right_sidebar(); ?>

		</div>

	</div>
	
</div>
<?php get_footer(); ?>