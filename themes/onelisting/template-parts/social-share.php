<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use wpWax\OneListing\Helper;
use \wpWax\OneListing\Theme;

if ( empty( Theme::$options['post_share'] ) ) {
	return;
}

$selected = Theme::$options['post_share'];
$url      = urlencode( get_permalink() );
$title    = urlencode( get_the_title() );
$sharers  = array();

$all = array(
	'facebook'  => array(
		'url'   => "//www.facebook.com/sharer.php?u=$url",
		'icon'  => Helper::get_svg_icon( 'facebook' ),
		'label' => __( 'Share', 'onelisting' ),
		'class' => __( 'facebook', 'onelisting' ),
	),
	'twitter'   => array(
		'url'   => "//twitter.com/intent/tweet?source=$url&text=$title:$url",
		'icon'  => Helper::get_svg_icon( 'twitter' ),
		'label' => __( 'Tweet', 'onelisting' ),
		'class' => __( 'twitter', 'onelisting' ),
	),
	'linkedin'  => array(
		'url'   => "//www.linkedin.com/shareArticle?mini=true&url=$url&title=$title",
		'icon'  => Helper::get_svg_icon( 'linkedin' ),
		'label' => __( 'Share', 'onelisting' ),
		'class' => __( 'linkedin', 'onelisting' ),
	),
	'pinterest' => array(
		'url'   => "//pinterest.com/pin/create/button/?url=$url&description=$title",
		'icon'  => Helper::get_svg_icon( 'pinterest' ),
		'label' => __( 'Share', 'onelisting' ),
		'class' => __( 'pinterest', 'onelisting' ),
	),
	'tumblr'    => array(
		'url'   => "//www.tumblr.com/share?v=3&u=$url&quote=$title",
		'icon'  => Helper::get_svg_icon( 'tumblr' ),
		'label' => __( 'Share', 'onelisting' ),
		'class' => __( 'tumblr', 'onelisting' ),
	),
	'reddit'    => array(
		'url'   => "//www.reddit.com/submit?url=$url&title=$title",
		'icon'  => Helper::get_svg_icon( 'reddit' ),
		'label' => __( 'Share', 'onelisting' ),
		'class' => __( 'reddit', 'onelisting' ),
	),
	'vk'        => array(
		'url'   => "//vkontakte.ru/share.php?url=$url",
		'icon'  => Helper::get_svg_icon( 'vk' ),
		'label' => __( 'Share', 'onelisting' ),
		'class' => __( 'vk', 'onelisting' ),
	),
	'copy_url'  => array(
		'url'   => "$url",
		'icon'  => Helper::get_svg_icon( 'link-solid' ),
		'label' => __( 'Copy', 'onelisting' ),
		'class' => __( 'copy', 'onelisting' ),
	),
);

foreach ( $selected as $value ) {
	$sharers[$value] = $all[$value];
}

$sharers = apply_filters( 'wpwaxtheme_social_sharing_icons', $sharers );
?>
<div class="theme-post-social">

	<span class="theme-post-social__title"><?php esc_html_e( 'Share this article:', 'onelisting' );?></span>

	<ul class="theme-post-social__list list-unstyled">

		<?php foreach ( $sharers as $key => $sharer ): ?>

			<?php if ( 'copy_url' === $key ): ?>

				<li>
					<input type="hidden" value="<?php echo get_permalink(); ?>" id="copyUrl">

					<div class="toolip_wrapper">
						<a href="#" class="theme-post-social-<?php echo esc_html( $sharer['class'] ); ?>" id="copyBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard">
							<?php echo $sharer['icon']; ?> <?php echo esc_html( $sharer['label'] ); ?>
						</a>
					</div>
				</li>

			<?php else: ?>

				<li>
					<a href="<?php echo esc_url( $sharer['url'] ); ?>" class="theme-post-social-<?php echo esc_html( $sharer['class'] ); ?>" target="_blank"><?php echo $sharer['icon']; ?> <span><?php echo esc_html( $sharer['label'] ); ?></span> </a>
				</li>

			<?php endif;?>

		<?php endforeach;?>

	</ul>

</div>