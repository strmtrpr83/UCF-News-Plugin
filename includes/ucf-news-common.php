<?php
/**
 * Place common functions here.
 **/

if ( ! class_exists( 'UCF_News_Common' ) ) {

	class UCF_News_Common {
		public function display_news_items( $items, $layout, $title, $display_type='default' ) {
			ob_start();

			if ( has_action( 'ucf_news_display_' . $layout . '_before' ) ) {
				do_action( 'ucf_news_display_' . $layout . '_before', $items, $title, $display_type );
			}

			if ( has_action( 'ucf_news_display_' . $layout . '_title' ) ) {
				do_action( 'ucf_news_display_' . $layout . '_title', $items, $title, $display_type );
			}

			if ( has_action( 'ucf_news_display_' . $layout  ) ) {
				do_action( 'ucf_news_display_' . $layout, $items, $title, $display_type );
			}

			if ( has_action( 'ucf_news_display_' . $layout . '_after' ) ) {
				do_action( 'ucf_news_display_' . $layout . '_after', $items, $title, $display_type );
			}

			return ob_get_clean();
		}

		public static function get_fallback_image( $size='thumbnail' ) {
			$image_id = get_option( 'ucf_news_fallback_image', null );
			$retval = null;
			if ( $image_id ) {
				$retval = wp_get_attachment_image_src( $image_id, $size );
				$retval = $retval ? $retval[0] : null;
			}

			return $retval;
		}

		public static function get_story_image_or_fallback( $item ) {
			$img_url = null;
			$featured_media = isset( $item->_embedded->{'wp:featuredmedia'} ) ? $item->_embedded->{'wp:featuredmedia'} : false;

			if ( is_array( $featured_media ) ) {
				$img_obj = $featured_media[0];
				$img_url = $img_obj->media_details->sizes->thumbnail->source_url;

				// If the thumbnail isn't defined, just use the fallback image
				if ( !$img_url ) {
					$img_url = self::get_fallback_image();
				}
			}
			else {
				$img_url = self::get_fallback_image();
			}

			return $img_url;
		}

		public static function get_story_terms( $item, $taxonomy ) {
			$tax_terms     = array();
			$taxonomy_list = isset( $item->_links->{'wp:term'} ) ? $item->_links->{'wp:term'} : false;
			$all_terms     = isset( $item->_embedded->{'wp:term'} ) ? $item->_embedded->{'wp:term'} : false;
			$all_terms_key = false;

			if ( is_array( $taxonomy_list ) && is_array( $all_terms ) ) {
				// Determine the position in $all_terms that the terms for
				// $taxonomy are located.  $taxonomy_list contains a list of
				// taxonomy objects that should be listed in the same order
				// that groups of their terms are listed in $all_terms.
				foreach ( $taxonomy_list as $key => $tax_obj ) {
					if ( $tax_obj->taxonomy == $taxonomy ) {
						$all_terms_key = $key;
						break;
					}
				}

				if ( $all_terms_key !== false ) {
					$tax_terms = $all_terms[$all_terms_key];
				}
			}

			return $tax_terms;
		}

		public static function add_css() {
			if ( get_option( 'ucf_news_include_css' ) ) {
				wp_enqueue_style( 'ucf_news_css', plugins_url( 'static/css/ucf-news.min.css', UCF_NEWS__PLUGIN_FILE ), false, false, 'all' );
			}
		}

		public static function get_story_sections( $item ) {
			return self::get_story_terms( $item, 'category' );
		}

		public static function get_story_topics( $item ) {
			return self::get_story_terms( $item, 'post_tag' );
		}
	}

	add_action( 'wp_enqueue_scripts', array( 'UCF_News_Common', 'add_css' ) );

}
?>
