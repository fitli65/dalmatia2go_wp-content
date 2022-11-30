<?php
/**
 * Extend Rank Math SEO Plugin with Homey & Directorist variables.
 */

 add_action( 'rank_math/vars/register_extra_replacements', function() {

	/* Variable: Homey %listing_type% */
 	rank_math_register_var_replacement(
 		'listing_type',
 		[
 			'name' => esc_html__( 'Listing Type', 'rank-math' ),
 			'description' => esc_html__( 'Type of listing', 'rank-math' ),
 			'variable' => 'listing_type',
 			'example' => listing_type_callback(),
 		],
 		'listing_type_callback'
 	);

	/* Variable: Homey %listing_price% */
	rank_math_register_var_replacement(
		'listing_price',
		[
			'name' => esc_html__( 'Listing Price', 'rank-math' ),
			'description' => esc_html__( 'Lowest Price of listing', 'rank-math' ),
			'variable' => 'listing_price',
			'example' => listing_price_callback(),
		],
		'listing_price_callback'
	);

	/* Variable: Homey %listing_address% */
	rank_math_register_var_replacement(
		'listing_address',
		[
			'name' => esc_html__( 'Listing Address', 'rank-math' ),
			'description' => esc_html__( 'Address of listing', 'rank-math' ),
			'variable' => 'listing_address',
			'example' => listing_address_callback(),
		],
		'listing_address_callback'
	);

	/* Variable: Homey %listing_lat% */
	rank_math_register_var_replacement(
		'listing_lat',
		[
			'name' => esc_html__( 'Listing Latitude', 'rank-math' ),
			'description' => esc_html__( 'Latitude of listing', 'rank-math' ),
			'variable' => 'listing_lat',
			'example' => listing_lat_callback(),
		],
		'listing_lat_callback'
	);

	/* Variable: Homey %listing_long% */
	rank_math_register_var_replacement(
		'listing_long',
		[
			'name' => esc_html__( 'Listing Longitude', 'rank-math' ),
			'description' => esc_html__( 'Longitude of listing', 'rank-math' ),
			'variable' => 'listing_long',
			'example' => listing_long_callback(),
		],
		'listing_long_callback'
	);

	/* Variable: Homey %listing_map - Only for Schema.org% */
	rank_math_register_var_replacement(
		'listing_map',
		[
			'name' => esc_html__( 'Listing Google Map', 'rank-math' ),
			'description' => esc_html__( 'Google Map link of listing - Only for Schema Template', 'rank-math' ),
			'variable' => 'listing_map',
			'example' => listing_map_callback(),
		],
		'listing_map_callback'
	);

	/* Variable: Homey %listing_guest% */
	rank_math_register_var_replacement(
		'listing_guest',
		[
			'name' => esc_html__( 'Listing Guests', 'rank-math' ),
			'description' => esc_html__( 'Maximum Guests of listing', 'rank-math' ),
			'variable' => 'listing_guest',
			'example' => listing_guest_callback(),
		],
		'listing_guest_callback'
	);

	/* Variable: Homey %listing_rooms% */
	rank_math_register_var_replacement(
		'listing_rooms',
		[
			'name' => esc_html__( 'Listing Rooms', 'rank-math' ),
			'description' => esc_html__( 'Room count of listing', 'rank-math' ),
			'variable' => 'listing_rooms',
			'example' => listing_rooms_callback(),
		],
		'listing_rooms_callback'
	);

	/* Variable: Homey %listing_size% */
	rank_math_register_var_replacement(
		'listing_size',
		[
			'name' => esc_html__( 'Listing Roomsize', 'rank-math' ),
			'description' => esc_html__( 'Room size of listing', 'rank-math' ),
			'variable' => 'listing_size',
			'example' => listing_size_callback(),
		],
		'listing_size_callback'
	);

	/* Variable: Homey %listing_bath% */
	rank_math_register_var_replacement(
		'listing_bath',
		[
			'name' => esc_html__( 'Listing Bathrooms', 'rank-math' ),
			'description' => esc_html__( 'Bathroom count of listing', 'rank-math' ),
			'variable' => 'listing_bath',
			'example' => listing_bath_callback(),
		],
		'listing_bath_callback'
	);

	/* Variable: Homey %listing_num_reviews% */
	rank_math_register_var_replacement(
		'listing_num_reviews',
		[
			'name' => esc_html__( 'Listing Number of Review', 'rank-math' ),
			'description' => esc_html__( 'Number of Reviews of listing', 'rank-math' ),
			'variable' => 'listing_num_reviews',
			'example' => listing_num_reviews_callback(),
		],
		'listing_num_reviews_callback'
	);

	/* Variable: Homey %listing_review% */
	rank_math_register_var_replacement(
		'listing_review',
		[
			'name' => esc_html__( 'Listing Review', 'rank-math' ),
			'description' => esc_html__( 'Review of listing', 'rank-math' ),
			'variable' => 'listing_review',
			'example' => listing_review_callback(),
		],
		'listing_review_callback'
	);

	/* Variable: Directorist %listing_address% 
	rank_math_register_var_replacement(
		'directorist_address',
		[
			'name' => esc_html__( 'Listing Address', 'rank-math' ),
			'description' => esc_html__( 'Address of listing', 'rank-math' ),
			'variable' => 'directorist_address',
			'example' => directorist_address_callback(),
		],
		'directorist_address_callback'
	);
	*/

 } );

 /* Functions to get the Homey callback data */
 function listing_type_callback() {
	$terms = get_the_terms(get_the_ID(), 'listing_type');
	if ( !empty( $terms ) ){
	    // get the first term
	    $term = array_shift( $terms );
	    return $term->name;
	}
 }
 function listing_price_callback() {
	$price = homey_get_listing_data('night_price');
	if ( !empty( $price ) ){
	    return $price;
	}
 }
 function listing_address_callback() {
	$address = homey_get_listing_data('listing_address');
	if ( !empty( $address ) ){
	    return $address;
	}
 }
 function listing_lat_callback() {
	$lat = homey_get_listing_data('geolocation_lat');
	if ( !empty( $lat ) ){
	    return $lat;
	}
 }
 function listing_long_callback() {
	$long = homey_get_listing_data('geolocation_long');
	if ( !empty( $long ) ){
	    return $long;
	}
 }
 function listing_map_callback() {
	$lat = homey_get_listing_data('geolocation_lat');
	$long = homey_get_listing_data('geolocation_long');
	if ( !empty( $long ) ){
	    return 'https://www.google.com/maps/@'.$lat.','.$long.',19z';
	}
 }
 function listing_guest_callback() {
	$guest = homey_get_listing_data('guests');
	if ( !empty( $guest ) ){
	    return $guest;
	}
 }
 function listing_rooms_callback() {
	$rooms = homey_get_listing_data('listing_bedrooms');
	if ( !empty( $rooms ) ){
	    return $rooms;
	}
 }
 function listing_size_callback() {
	$size = homey_get_listing_data('listing_size');
	if ( !empty( $size ) ){
	    return $size;
	}
 }
 function listing_bath_callback() {
	$bath = homey_get_listing_data('baths');
	if ( !empty( $bath ) ){
	    return $bath;
	}
 }
 function listing_num_reviews_callback() {
	$num_of_review = homey_option('num_of_review');
	$args = array(
		'post_type' =>  'homey_review',
		'meta_key' => 'reservation_listing_id',
		'meta_value' => get_the_ID(),
		'posts_per_page' => $num_of_review,
		'post_status' =>  'publish'
	);
	$review_query = new WP_Query($args);
	$total_review = $review_query->found_posts;
	if($total_review < 1) {
		return '1';
	} else {
	return intval($total_review);
	}
 }
 function listing_review_callback() {
	$review = get_post_meta( get_the_ID(), 'listing_total_rating', true );
	    return $review;
}

 /* Functions to get the Directorist callback data 
 use \Directorist\Directorist_Single_Listing;
 
 function directorist_address_callback() {
	$directorist_listing = Directorist_Single_Listing::instance();
	$address_data = $directorist_listing->get_address( $data );
	$directorist_address = ( is_string( $address_data ) ) ? $address_data : '';
	if ( !empty( $directorist_address ) ){
	    return $directorist_address;
	}
 }
 */
 
