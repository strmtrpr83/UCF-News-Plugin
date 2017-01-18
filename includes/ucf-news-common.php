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

if ( ! function_exists( 'ucf_news_display_classic_before' ) ) {
	function ucf_news_display_classic_before( $items, $title, $display_type ) {
		ob_start();
	?>
		<div class="ucf-news classic">
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_news_display_classic_before', 'ucf_news_display_classic_before', 10, 3 );
}

if ( ! function_exists( 'ucf_news_display_classic_title' ) ) {
	function ucf_news_display_classic_title( $item, $title, $display_type) {
		$formatted_title = $title;

		switch( $display_type ) {
			case 'widget':
				break;
			case 'default':
			default:
				if ( $title ) {
					$formatted_title = '<h2 class="ucf-news-title">' . $title . '</h2>';
				}
				break;
		}

		echo $formatted_title;
	}

	add_action( 'ucf_news_display_classic_title', 'ucf_news_display_classic_title', 10, 3 );
}

if ( ! function_exists( 'ucf_news_display_classic' ) ) {
	function ucf_news_display_classic( $items, $title, $display_type ) {
		ob_start();
	?>
		<div class="ucf-news-items">
	<?php
		foreach( $items as $item ) :
			$item_img = UCF_News_Common::get_story_image_or_fallback( $item );
	?>
			<div class="ucf-news-item">
			<?php if ( $item_img ): ?>
				<div class="ucf-news-thumbnail">
					<img class="ucf-news-thumbnail-image" src="<?php echo $item_img; ?>">
				</div>
			<?php endif; ?>
				<div class="ucf-news-item-title">
					<a href="<?php echo $item->link; ?>">
						<?php echo $item->title->rendered; ?>
					</a>
				</div>
			</div>
	<?php
		endforeach;
	?>
	</div>
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_news_display_classic', 'ucf_news_display_classic', 10, 3 );
}

if ( ! function_exists( 'ucf_news_display_classic_after' ) ) {
	function ucf_news_display_classic_after( $items, $title, $display_type ) {
		ob_start();
	?>
		</div>
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_news_display_classic_after', 'ucf_news_display_classic_after', 10, 3 );
}

}
?>
