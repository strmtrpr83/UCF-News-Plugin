<?php
/**
 * Place common functions here.
 **/

if ( ! class_exists( 'UCF_News_Common' ) ) {

	class UCF_News_Common {
		public static function display_news_items( $items, $layout, $args, $display_type='default', $content='' ) {
			ob_start();

			// Before
			$layout_before = ucf_news_display_classic_before( '', $items, $args, $display_type );
			if ( has_filter( 'ucf_news_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_news_display_' . $layout . '_before', $layout_before, $items, $args, $display_type );
			}
			echo $layout_before;

			// Title
			$layout_title = ucf_news_display_classic_title( '', $items, $args, $display_type );
			if ( has_filter( 'ucf_news_display_' . $layout . '_title' ) ) {
				$layout_title = apply_filters( 'ucf_news_display_' . $layout . '_title', $layout_title, $items, $args, $display_type );
			}
			echo $layout_title;

			// Main content/loop
			$layout_content = ucf_news_display_classic( '', $items, $args, $display_type, $content );
			if ( has_filter( 'ucf_news_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_news_display_' . $layout, $layout_content, $items, $args, $display_type, $content );
			}
			echo $layout_content;

			// After
			$layout_after = ucf_news_display_classic_after( '', $items, $args, $display_type );
			if ( has_filter( 'ucf_news_display_' . $layout . '_after' ) ) {
				$layout_after = apply_filters( 'ucf_news_display_' . $layout . '_after', $layout_after, $items, $args, $display_type );
			}
			echo $layout_after;

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
			return $item->thumbnail ?: self::get_fallback_image();
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
