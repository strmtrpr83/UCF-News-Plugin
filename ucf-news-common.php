<?php
/**
 * Place common functions here.
 **/

class UCF_News_Common {
	public function display_news_items( $items, $layout, $title ) {
		if ( get_theme_mod( 'ucf_news_include_css', False ) ) {
			wp_enqueue_style( 'ucf_news_css', plugins_url( 'static/css/ucf-news.min.css', __FILE__ ), false, false, 'all' );
		}

		if ( has_action( 'ucf_news_display_' . $layout . '_before' ) ) {
			do_action( 'ucf_news_display_' . $layout . '_before', $items, $title );
		}

		if ( has_action( 'ucf_news_display_' . $layout  ) ) {
			do_action( 'ucf_news_display_' . $layout, $items, $title );
		}

		if ( has_action( 'ucf_news_display_' . $layout . '_after' ) ) {
			do_action( 'ucf_news_display_' . $layout . '_after', $items, $title );
		}
	}
}

function ucf_news_display_classic_before( $items, $title ) {
	ob_start();
?>
	<div class="news classic">
		<h2 class="news-title"><?php echo $title; ?></h2> 
<?php
	echo ob_get_clean();
}

add_action( 'ucf_news_display_classic_before', 'ucf_news_display_classic_before', 10, 2 );

function ucf_news_display_classic( $items, $title ) {
	ob_start();
?>
	<div class="news-items">
<?php
	foreach( $items as $item ) :
?>
		<div class="news-item">
		<?php if ( $item->featured_image !== 0 ) : 
			$image = $item->_embedded->{'wp:featuredmedia'}[0];
			$image_url = $image->media_details->sizes->thumbnail->source_url;
		?>
			<div class="news-thumbnail">
				<img class="news-thumbnail-image" src="<?php echo $image_url; ?>">
			</div>
		<?php endif; ?>
			<div class="news-item-title">
				<a href="<?php echo $item->link; ?>">
					<?php echo $item->title->rendered; ?>
				</a>
			</div>
		</div>
<?php
	endforeach;

	echo ob_get_clean();
}

add_action( 'ucf_news_display_classic', 'ucf_news_display_classic', 10, 2 );

function ucf_news_display_classic_after( $items, $title ) {
	ob_start();
?>
	</div>
<?php
	echo ob_get_clean();
}

add_action( 'ucf_news_display_classic_after', 'ucf_news_display_classic_after', 10, 2 );

?>
