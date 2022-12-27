<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !$has_slider ) {
   return;
}
// $img_size_class = ( 'contain' === $data['background-size'] ) ? '' : ' plasmaSlider__cover';
$i = 0;

if(!empty($data['images'])) {
?>
<div class="top-gallery-section top-gallery-variable-width-section">
	<div class="listing-slider-variable-width">
	<?php foreach( $data['images'] as $image) { ?>
		<div>
			<img data-fancy-image-index="<?php echo $i; ?>" class="img-responsive fanboxTopGalleryVar-item" data-lazy="<?php echo esc_url($image['src']); ?>" src="<?php echo esc_url($image['src']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
		</div>
	<?php $i++; } ?>
	</div>
</div>
<?php fancybox_gallery_html($data['images'], "fanboxTopGalleryVar");//hidden images for gallery fancybox 3 ?>
<?php } ?>