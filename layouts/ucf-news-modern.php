<?php
/**
 * The default functions for the modern layout
 **/
if ( ! function_exists( 'ucf_news_display_modern_before' ) ) {
	function ucf_news_display_modern_before( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		<div class="ucf-news modern">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_modern_before', 'ucf_news_display_modern_before', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_modern_title' ) ) {
	function ucf_news_display_modern_title( $content, $items, $args, $display_type ) {
		$formatted_title = $args['title'];

		switch( $display_type ) {
			case 'widget':
				break;
			case 'default':
			default:
				if ( $formatted_title ) {
					$formatted_title = '<h2 class="ucf-news-title">' . $formatted_title . '</h2>';
				}
				break;
		}

		return $formatted_title;
	}

	add_filter( 'ucf_news_display_modern_title', 'ucf_news_display_modern_title', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_modern' ) ) {
	function ucf_news_display_modern( $content, $items, $args, $display_type, $fallback_message ) {
		if ( $items === false ) {
			$items = array();
		}
		else if ( ! is_array( $items ) ) {
			$items = array( $items );
		}

		ob_start();

	if ( count( $items ) === 0 ) : echo $fallback_message; else :

		foreach( $items as $item ) :
			$item_img = UCF_News_Common::get_story_img_tag( $item );
			$section = UCF_News_Common::get_story_primary_section( $item );
	?>
		<div class="ucf-news-item">
			<a href="<?php echo $item->link; ?>">
				<?php if ( $item_img ) : ?>
				<div class="ucf-news-thumbnail">
					<?php echo $item_img; ?>
				</div>
				<?php endif; ?>
				<div class="ucf-news-item-content">
					<?php if ( $section ): ?>
					<div class="ucf-news-section">
						<span class="ucf-news-section-title"><?php echo $section->name; ?></span>
					</div>
					<?php endif; ?>
					<div class="ucf-news-item-details">
						<p class="ucf-news-item-title"><?php echo $item->title->rendered; ?></p>
						<p class="ucf-news-item-excerpt"><?php echo wp_trim_words( $item->excerpt->rendered, 25 ); ?></p>
					</div>
				</div>
			</a>
		</div>
	<?php
		endforeach;

	endif; // End if item count

		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_modern', 'ucf_news_display_modern', 10, 5 );
}

if ( ! function_exists( 'ucf_news_display_modern_after' ) ) {
	function ucf_news_display_modern_after( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_modern_after', 'ucf_news_display_modern_after', 10, 4 );
}
