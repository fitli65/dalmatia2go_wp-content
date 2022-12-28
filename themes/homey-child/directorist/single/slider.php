<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$size = 'homey-variable-slider';
$listing_id = get_the_ID();
$listing_imgs  = get_post_meta( $listing_id, '_listing_img', true );
$listing_imgs  = $listing_imgs ? $listing_imgs : array();
$image_links   = array();

// Get the preview image
$preview_img_id   = get_post_meta( $listing_id, '_listing_prv_img', true );
$preview_img_link = ! empty( $preview_img_id ) ? atbdp_get_image_source( $preview_img_id, $size ) : '';
$preview_img_alt  = get_post_meta( $preview_img_id, '_wp_attachment_image_alt', true );
$preview_img_alt  = ( ! empty( $preview_img_alt ) ) ? $preview_img_alt : get_the_title( $preview_img_id );

if ( ! empty( $preview_img_link ) ) {
	$image_links[] = array(
		'alt' => $preview_img_alt,
		'src' => $preview_img_link,
		'id'  => isset( $preview_img_id ) ? $preview_img_id : '',
	);
}

// Get the Slider Images
foreach ( $listing_imgs as $img_id ) {
	$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
	$alt = ( ! empty( $alt ) ) ? $alt : get_the_title( $img_id );

	$image_links[] = array(
		'alt' => ( ! empty( $alt ) ) ? $alt : $listing_title,
		'src' => atbdp_get_image_source( $img_id, $size ),
		'id'  => $img_id,
	);
}

$i = 0;

if(! empty( $image_links )) {
?>
<div class="top-gallery-section top-gallery-variable-width-section">
	<div class="listing-slider-variable-width">
	<?php foreach ( $image_links as $image ) { ?>
		<div>
		<a href="<?php echo esc_attr( isset( $image['id'] ) ? atbdp_get_image_source( $image['id'], 'full' ) : $image['src'] ) ?>" class="swipebox">
			<img data-fancy-image-index="<?php echo $i; ?>" class="img-responsive" data-lazy="<?php echo esc_attr( $image['src'] ) ?>" src="<?php echo esc_attr( $image['src'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ) ?>"/>
		</a>
		</div>
	<?php $i++; } ?>
	</div>
</div>
<?php fancybox_gallery_html($image_links, "fanboxTopGalleryVar");//hidden images for gallery fancybox 3 ?>
<?php } ?>