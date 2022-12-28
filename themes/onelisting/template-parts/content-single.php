<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use \wpWax\OneListing\Theme;
use \wpWax\OneListing\Helper;

$thumb_size  	= 'wpwaxtheme-size1';
$author_id	 	= get_the_author_meta( 'ID' );
$author_name 	= get_the_author_meta( 'display_name' );
$author_slug 	= get_the_author_meta( 'user_login' );
$author_bio 	= get_the_author_meta( 'description' );

$facebook 		= get_user_meta( $author_id, 'atbdp_facebook', true );
$twitter 		= get_user_meta( $author_id, 'atbdp_twitter', true );
$linkedIn 		= get_user_meta( $author_id, 'atbdp_linkedin', true );
$youtube 		= get_user_meta( $author_id, 'atbdp_youtube', true );
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'theme-post-single' ); ?>>

	<div class="theme-post-details">

		<?php if ( has_post_thumbnail() ): ?>

			<figure class="theme-post-thumbnail"><?php the_post_thumbnail( $thumb_size ); ?></figure>
		
		<?php endif; ?>

		<div class="theme-post-content">

			<div class="theme-post-header">

				<h1 class="theme-post-title"><?php echo get_the_title(); ?></h1>

				<div class="theme-post-meta">

					<ul>
					
						<?php if ( Theme::$options['post_date'] ): ?>
							
							<li><span class="updated published"><?php the_time( get_option( 'date_format' ) ); ?></span></li>
						
						<?php endif; ?>

						<?php if ( Theme::$options['post_cats'] && has_category() ): ?>

							<li><?php the_category( ', ' ); ?></li>

						<?php endif; ?>

						<?php if ( Theme::$options['single_average_reading_time'] ): ?>

							<li><?php echo Helper::get_reading_time( get_the_content(), 'span' ); ?></li>

						<?php endif; ?>
						
					</ul>

				</div>

			</div>

			<div class="theme-post-body">

				<?php the_content(); ?>

			</div>

		</div>

		<div class="theme-post-bottom">

			<?php if ( Theme::$options['post_tags'] && has_tag() ): ?>

				<div class="theme-post-tags">

					<ul class="d-flex list-unstyled">

						<?php echo get_the_term_list( $post->ID, 'post_tag', '<li>', '</li><li>', '</li>' ); ?>

					</ul>

				</div>

			<?php endif; ?>

			<?php if ( Theme::$options['post_social'] ): ?>

				<?php get_template_part( 'template-parts/social-share' ); ?>

			<?php endif; ?>

		</div>

	</div>

	<?php if ( Theme::$options['post_about_author'] && $author_bio ) : ?>

		<div class="theme-post-author cardify">

			<div class="theme-post-author__thumb">

				<a href="<?php echo get_author_posts_url( $author_id ); ?>"><?php echo get_avatar( $author_id, 100 ); ?></a>

			</div>

			<div class="theme-post-author__info">

				<h5 class="theme-post-author__name">
					<?php printf( '<a href="%s">%s</a>', esc_url( home_url( "/author/{$author_slug}/" ) ), esc_html( $author_name ) ); ?>
				</h5>

				<p class="theme-post-author__bio"><?php echo wp_kses_post( $author_bio ); ?></p>

				<?php if ( ! empty( $facebook || $twitter || $linkedIn || $youtube ) ) : ?>

					<ul class="list-unstyled theme-post-author__social">
						<?php
						if ( $facebook ) {
							printf( '<li><a target="_blank" href="%s">%s</a></li>', $facebook, Helper::get_svg_icon( 'facebook' ) );
						}
						if ( $twitter ) {
							printf( '<li><a target="_blank" href="%s">%s</a></li>', $twitter, Helper::get_svg_icon( 'twitter' ) );
						}
						if ( $linkedIn ) {
							printf( '<li><a target="_blank" href="%s">%s</a></li>', $linkedIn, Helper::get_svg_icon( 'linkedin' ) );
						}
						if ( $youtube ) {
							printf( '<li><a target="_blank" href="%s">%s</a></li>', $youtube, Helper::get_svg_icon( 'youtube' ) );
						}
						?>
					</ul>

				<?php endif ?>

			</div>

		</div>

	<?php endif;?>
	
	<?php
	if ( Theme::$options['post_pagination'] ) {
		get_template_part( 'template-parts/content-single-pagination' );
	}

	if ( Theme::$options['post_related'] ) {
		get_template_part( 'template-parts/content-single-related' );
	}	
	?>

</div>