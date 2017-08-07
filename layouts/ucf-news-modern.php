<?php
/**
 * The default functions for the modern layout
 **/
if ( ! function_exists( 'ucf_news_display_modern_before' ) ) {
	function ucf_news_display_modern_before( $content, $items, $title, $display_type ) {
		ob_start();
	?>
		<div class="ucf-news modern">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_modern_before', 'ucf_news_display_modern_before', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_modern_title' ) ) {
	function ucf_news_display_modern_title( $content, $item, $title, $display_type ) {
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

	add_filter( 'ucf_news_display_modern_title', 'ucf_news_display_modern_title', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_modern' ) ) {
	function ucf_news_display_modern( $content, $items, $title, $display_type ) {
		if ( ! is_array( $items ) ) { $items = array( $items ); }
		ob_start();

		foreach( $items as $item ) :
		$item_img = UCF_News_Common::get_story_image_or_fallback( $item );
		$sections = UCF_News_Common::get_story_sections( $item );
		$section = $sections[0];
	?>
		<div class="ucf-news-item">
			<a href="<?php echo $item->link; ?>">
			<?php if ( $item_img ) : ?>
				<div class="ucf-news-thumbnail">
					<img src="<?php echo $item_img; ?>" class="ucf-news-thumbnail-image" alt="">
				</div>
			<?php endif; ?>
				<div class="ucf-news-item-content">
					<div class="ucf-news-section">
						<span class="ucf-news-section-title"><?php echo $section->name; ?></span>
					</div>
					<div class="ucf-news-item-details">
						<p class="ucf-news-item-title"><?php echo $item->title->rendered; ?></p>
						<p class="ucf-news-item-excerpt"><?php echo wp_trim_words( $item->excerpt->rendered, 25 ); ?></p>
					</div>
				</div>
			</a>
		</div>
	<?php
		endforeach;

		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_modern', 'ucf_news_display_modern', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_modern_after' ) ) {
	function ucf_news_display_modern_after( $content, $items, $title, $display_type ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_modern_after', 'ucf_news_display_modern_after', 10, 4 );
}
