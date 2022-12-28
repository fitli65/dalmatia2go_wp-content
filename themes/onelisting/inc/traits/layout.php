<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

trait Layout_Trait {

	private function bgimg_option( $key, $is_single = true ) {
		$layout_key = $this->post_type . '_' . $key;
		$key_prefix = "{$this->prefix}_layout_settings_{$this->post_type}_";

		$meta      = ! empty( $this->meta_value[$key_prefix . $key] ) ? $this->meta_value[$key_prefix . $key] : 'default';
		$op_layout = Theme::$options[$layout_key];
		$op_global = Theme::$options[$key];

		if ( ! empty( $meta['url'] ) ) {
			$img = $meta['url'];
		} elseif ( ! empty( $op_layout['url'] ) ) {
			$img = $op_layout['url'];
		} elseif ( ! empty( $op_global['url'] ) ) {
			$img = $op_global['url'];
		} else {
			$img = Helper::get_img( 'banner.jpg' );
		}

		return $img;
	}

	private function layout_option( $key ) {
		$layout_key = $this->post_type . '_' . $key;
		$op_layout  = Theme::$options[$layout_key];

		return $op_layout;
	}

	private function meta_layout_option( $key ) {
		$layout_key = $this->post_type . '_' . $key;
		$key_prefix = "{$this->prefix}_layout_settings_{$this->post_type}_";

		$meta      = ! empty( $this->meta_value[$key_prefix . $key] ) ? $this->meta_value[$key_prefix . $key] : 'default';
		$op_layout = Theme::$options[$layout_key];

		if ( $meta != 'default' ) {
			$result = $meta;
		} else {
			$result = $op_layout;
		}

		return $result;
	}

	private function layout_global_option( $key, $is_bool = false ) {
		$layout_key = $this->post_type . '_' . $key;

		$op_layout = Theme::$options[$layout_key] ? Theme::$options[$layout_key] : 'default';
		$op_global = Theme::$options[$key];

		if ( $op_layout != 'default' ) {
			$result = $op_layout;
		} else {
			$result = $op_global;
		}

		if ( $is_bool ) {
			$result = ( $result == 1 || $result == 'on' ) ? true : false;
		}

		return $result;
	}

	private function meta_layout_global_option( $key, $is_bool = false ) {
		$layout_key = $this->post_type . '_' . $key;
		$key_prefix = "{$this->prefix}_layout_settings_{$this->post_type}_";

		$meta      = ! empty( $this->meta_value[$key_prefix . $key] ) ? $this->meta_value[$key_prefix . $key] : 'default';
		$op_layout = Theme::$options[$layout_key] ? Theme::$options[$layout_key] : 'default';
		$op_global = Theme::$options[$key];

		if ( $meta != 'default' ) {
			$result = $meta;
		} elseif ( $op_layout != 'default' ) {
			$result = $op_layout;
		} else {
			$result = $op_global;
		}

		if ( $is_bool ) {
			$result = ( $result == 1 || $result == 'on' ) ? true : false;
		}

		return $result;
	}
}