<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use \wpWax\OneListing\Helper;
use \wpWax\OneListing\Theme;

$args = array(
	'category__in'        => wp_get_post_categories( $post->ID ),
	'post__not_in'        => array( $post->ID ),
	'numberposts'         => 2,
	'ignore_sticky_posts' => 1,
);
$related = get_posts( $args );
$count   = count( $related );

if ( ! $count ) {
	return;
}

$thumb_size  = 'wpwaxtheme-size2';
$date_format = apply_filters( 'wpwaxtheme_related_post_date_format', 'F j, Y' );
$post_class  = 'col-lg-6 col-md-6';
?>
<div class="theme-related-post-area m-top-60">

	<div class="related-post-title text-center">

		<h3><?php esc_html_e( 'Related Posts', 'onelisting' );?></h3>

	</div>

	<div class="row">

		<?php foreach ( $related as $post_obj ): ?>

			<div class="<?php echo esc_attr( $post_class ); ?>">

				<article id="post-<?php the_ID();?>" <?php post_class( 'theme-blog-each theme-related-blog-each' );?>>

					<div class="theme-blog-card blog-grid-card">

						<?php if ( has_post_thumbnail( $post_obj ) ): ?>

							<div class="theme-blog-card__thumbnail">

								<a href="<?php the_permalink();?>"><?php echo get_the_post_thumbnail( $post_obj, $thumb_size ); ?></a>

							</div>

						<?php endif;?>

						<div class="theme-blog-card__details">

							<div class="theme-blog-card__content">

								<h4 class="theme-blog-card__title"><a href="<?php echo esc_url( get_permalink( $post_obj ) ); ?>"><?php echo get_the_title( $post_obj ); ?></a> </h4>

							</div>

							<div class="theme-blog-card__meta">

								<div class="theme-blog-card__meta-list">

									<ul class="list-unstyled">

										<?php if ( Theme::$options['blog_date'] ): ?>

											<li class="theme-blog-card-date-meta"><span class="theme-blog-date-meta-text updated published"><?php the_time( get_option( 'date_format' ) );?></span></li>

										<?php endif;?>

										<?php if ( Theme::$options['average_reading_time'] && has_category() ): ?>

											<li class="theme-blog-reading-time-meta"><?php echo Helper::get_reading_time( get_the_content(), 'span' ); ?></li>

										<?php endif;?>

									</ul>

								</div>

							</div>

						</div>

					</div>

				</article>

			</div>

		<?php endforeach;?>

	</div>

</div>