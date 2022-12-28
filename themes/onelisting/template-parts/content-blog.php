<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use wpWax\OneListing\Helper;
use \wpWax\OneListing\Theme;

$thumb_size = 'wpwaxtheme-size2';
$get_cat_ob = get_the_category();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'theme-blog-each' ); ?>>

	<div class="theme-blog-card blog-grid-card">

		<?php if ( has_post_thumbnail() ): ?>

			<div class="theme-blog-card__thumbnail">

				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumb_size ); ?></a>

			</div>

		<?php endif; ?>

		<div class="theme-blog-card__details">

			<div class="theme-blog-card__content">

				<h4 class="theme-blog-card__title">

					<a href="<?php the_permalink(); ?>" class="entry-title" rel="bookmark"><?php the_title(); ?></a>

				</h4>

				<?php if ( Theme::$options['show_blog_excerpt'] ): ?>

					<div class="theme-blog-card__summary entry-summary"><?php the_excerpt(); ?></div>

				<?php endif;?>

			</div>

			<?php if ( Theme::$options['blog_date'] || Theme::$options['blog_cats'] ): ?>

				<div class="theme-blog-card__meta">

					<div class="theme-blog-card__meta-list">

						<ul>

							<?php if ( Theme::$options['blog_date'] ): ?>
								
								<?php printf( '<li class="theme-blog-date-meta"><a href="%s"><span class="theme-blog-date-meta-text updated published">%s</span></a></li>', get_the_permalink(), esc_html( get_the_time( get_option( 'date_format' ) ) ) ); ?> 
							
							<?php endif; ?>

							<?php if ( Theme::$options['average_reading_time'] ): ?>
								
								<li><?php echo Helper::get_reading_time( get_the_content(), 'span' ); ?></li>
							
							<?php endif; ?>
							
							<?php if ( Theme::$options['blog_cats'] && has_category() ): ?>

								<li class="theme-blog-category-meta">

									<?php if ( ! empty( $get_cat_ob ) ) {

										$term_link	= isset(  $get_cat_ob[0] ) ? get_category_link( $get_cat_ob[0]->cat_ID ) : '';
										$cat_name	= isset( $get_cat_ob[0] ) ? $get_cat_ob[0]->name : '';
										$total_term	= count( $get_cat_ob );

										printf( '<a href="%s"><span>%s</span> %s</a>', esc_url( $term_link ), esc_html__( 'In', 'onelisting' ) , esc_html( $cat_name ) );

										if ( $total_term > 1 ) {
											$total_term = $total_term - 1; 
											?>

											<div class="theme-blog-category-meta__popup">

												<?php printf( '<span class="theme-blog-category-meta__extran-count">%s %s</span>', esc_html( '+', 'onelisting' ), esc_html( $total_term ) ); ?>
												
												<div class="theme-blog-category-meta__popup__content">
													
													<?php 
													foreach ( array_slice($get_cat_ob, 1) as $cat ) {
														$term_label = trim( "{$cat->name}" );
														$term_link  = get_category_link( $cat->cat_ID);;

														printf( '<a href="%s">%s</a>', esc_url( $term_link ), esc_html( $term_label ) );
													}
													?>

												</div>

											</div>
											
											<?php
										}
									}
									?>

								</li>
								
							<?php endif; ?>

						</ul>

					</div>

				</div>

			<?php endif; ?>

		</div>

	</div>

</article>