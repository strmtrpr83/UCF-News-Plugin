<?php
/**
 * Place common functions here.
 **/

if ( ! class_exists( 'UCF_News_Common' ) ) {

	class UCF_News_Common {
		public function display_news_items( $items, $layout, $title, $display_type='default' ) {
			if ( get_option( 'ucf_news_include_css' ) ) {
				wp_enqueue_style( 'ucf_news_css', UCF_NEWS__PLUGIN_DIR . 'static/css/ucf-news.min.css', false, false, 'all' );
			}

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
	}

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
				$formatted_title = '<h2 class="ucf-news-title">' . $title . '</h2>';
				break;
		}

		echo $formatted_title;
	}

	add_action( 'ucf_news_display_classic_title', 'ucf_news_display_classic_title', 10, 3 );
}

if ( ! function_exists( 'ucf_news_display_classic' ) ) {
	function ucf_news_display_classic( $items, $title, $display_type ) {
		$fallback_image_id = get_option( 'ucf_news_fallback_image' );
		$fallback_image = wp_get_attachment_image_src( $fallback_image_id );
		$fallback_image = $fallback_image[0];
		ob_start();
	?>
		<div class="ucf-news-items">
	<?php
		foreach( $items as $item ) :
	?>
			<div class="ucf-news-item">
			<?php if ( $item->featured_media !== 0 || $fallback_image_id ) :
				if ( $item->featured_media == 0 ) {
					$image_url = $fallback_image;
				}  else {
					$image = $item->_embedded->{'wp:featuredmedia'}[0];
					$image_url = $image->media_details->sizes->thumbnail->source_url;
				}

				if ( empty( $image_url ) ) {
					$image_url = $fallback_image;
				}
			?>
				<div class="ucf-news-thumbnail">
					<img class="ucf-news-thumbnail-image" src="<?php echo $image_url; ?>">
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
