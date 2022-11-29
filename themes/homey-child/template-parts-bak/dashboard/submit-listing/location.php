<?php
global $homey_local, $hide_fields, $listing_data, $listing_meta_data;

$add_location_lat = homey_option('add_location_lat');
$add_location_long = homey_option('add_location_long');
$geo_country_limit = homey_option('geo_country_limit');

// MAGICLINE changes
$args = array(
        'show_option_all'    => 'Select Catagory',
        'show_option_none'   => '',
        'orderby'            => 'name',
        'order'              => 'ASC',
        'show_count'         => 0,
        'hide_empty'         => 0,
        'child_of'           => 0,
        'echo'               => 1,
        'hierarchical'       => 1,
        'name'               => 'locality',
        'id'                 => 'city',
        'class'              => 'selectpicker form-control',
        'depth'              => 1,
        'tab_index'          => 0,
        'taxonomy'           => 'listing_city',
        'hide_if_empty'      => false,
        'value_field'        => 'name',
      );
// end of MAGICLINE changes

$geocomplete_country = '';
if( $geo_country_limit != 0 ) {
    $geocomplete_country = homey_option('geocomplete_country');
}
?>
<div class="form-step">
    <!--step information-->
    <div class="block">
        <div class="block-title">
            <div class="block-left">
                <h2 class="title"><?php echo esc_html(homey_option('ad_location')); ?></h2>
            </div><!-- block-left -->
        </div>
        <div class="block-body">

            <div class="row">

              <?php if($hide_fields['city'] != 1) { ?>
              <div class="col-sm-4">
                  <div class="form-group">
                      <label for="city"><?php echo esc_attr(homey_option('ad_city')).homey_req('city'); ?></label>
                      <!-- MAGICLINE changes -->
                      <?php wp_dropdown_categories( $args ); ?>
                      <input type="hidden" autocomplete="false" name="administrative_area_level_1" <?php homey_required('state'); ?> value="Dalmatia" id="countyState"  class="form-control" id="state" placeholder="<?php echo esc_attr(homey_option('ad_state_placeholder')); ?>">
                      <input type="hidden" class="form-control" autocomplete="false" name="country" <?php homey_required('country'); ?> value="Croatia" id="homey_country" placeholder="<?php echo esc_attr(homey_option('ad_country_placeholder')); ?>">
                      <input type="hidden" name="country_short" value="HR">
                      <!-- end of MAGICLINE changes -->
                  </div>
              </div>
              <?php } ?>

                <?php if($hide_fields['listing_address'] != 1) { ?>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="listing_address"><?php echo esc_attr(homey_option('ad_address')).homey_req('listing_address'); ?></label>
                        <input type="text" autocomplete="false" data-input-title="<?php echo esc_html__(esc_attr(homey_option('ad_address')), 'homey'); ?>" name="listing_address" <?php homey_required('listing_address'); ?> class="form-control" id="listing_address" placeholder="<?php echo esc_attr(homey_option('ad_address_placeholder')); ?>">
                    </div>
                </div>
                <?php } ?>

                <?php if($hide_fields['zipcode'] != 1) { ?>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="zip"><?php echo esc_attr(homey_option('ad_zipcode')).homey_req('zip'); ?></label>
                        <input type="text" autocomplete="false" name="zip" <?php homey_required('zip'); ?> class="form-control" id="zip" placeholder="<?php echo esc_attr(homey_option('ad_zipcode_placeholder')); ?>">
                    </div>
                </div>
                <?php } ?>

                <?php if($hide_fields['area'] != 1) { ?>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="neighborhood"><?php echo esc_attr(homey_option('ad_area')).homey_req('area'); ?></label>
                        <input class="form-control" autocomplete="false" name="neighborhood" id="area" <?php homey_required('area'); ?> placeholder="<?php echo esc_attr(homey_option('ad_area_placeholder')); ?>">
                    </div>
                </div>
                <?php } ?>

            </div>
            <div class="row add-listing-map">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label><?php echo esc_attr(homey_option('ad_drag_pin')); ?></label>
                        <div class="map_canvas" data-add-lat="<?php echo esc_attr($add_location_lat); ?>" data-add-long="<?php echo esc_attr($add_location_long); ?>" id="map">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row add-listing-map">
                <div class="col-sm-12">
                    <label><?php echo esc_attr(homey_option('ad_find_address')); ?></label>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <input type="text" name="lat" id="lat" class="form-control" placeholder="<?php echo empty(esc_attr(homey_option('ad_lat'))) ? esc_attr($add_location_lat) :  esc_attr(homey_option('ad_lat')); ?>" value="<?php echo !empty(esc_attr(homey_option('ad_lat'))) ? esc_attr($add_location_lat) :  esc_attr(homey_option('ad_lat')); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <input type="text" name="lng" id="lng" class="form-control" placeholder="<?php echo empty(esc_attr(homey_option('ad_long'))) ? esc_attr($add_location_long) :  esc_attr(homey_option('ad_long')); ?>" value="<?php echo !empty(esc_attr(homey_option('ad_long'))) ? esc_attr($add_location_long) :  esc_attr(homey_option('ad_long')); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo !empty(esc_attr(homey_option('ad_long'))) ? '<script type="text/javascript">jQuery(document).ready(function(){ jQuery("#find").click();})</script>' : ''; ?>
