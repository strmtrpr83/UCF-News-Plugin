<?php
/**
 * The default functions for the classic layout
 **/
if ( ! function_exists( 'ucf_news_display_classic_before' ) ) {
	function ucf_news_display_classic_before( $content, $items, $title, $display_type ) {
		ob_start();
	?>
		<div class="ucf-news classic">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_classic_before', 'ucf_news_display_classic_before', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_classic_title' ) ) {
	function ucf_news_display_classic_title( $content, $items, $title, $display_type ) {
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

		return $formatted_title;
	}

	add_filter( 'ucf_news_display_classic_title', 'ucf_news_display_classic_title', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_classic' ) ) {
	function ucf_news_display_classic( $content, $items, $title, $display_type ) {
		if ( ! is_array( $items ) ) { $items = array( $items ); }
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
					<img class="ucf-news-thumbnail-image" src="<?php echo $item_img; ?>" alt="">
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
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_classic', 'ucf_news_display_classic', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_classic_after' ) ) {
	function ucf_news_display_classic_after( $content, $items, $title, $display_type ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_classic_after', 'ucf_news_display_classic_after', 10, 4 );
}
