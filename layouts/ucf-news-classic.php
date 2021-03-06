<?php
/**
 * The default functions for the classic layout
 **/
if ( ! function_exists( 'ucf_news_display_classic_before' ) ) {
	function ucf_news_display_classic_before( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		<div class="ucf-news classic">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_classic_before', 'ucf_news_display_classic_before', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_classic_title' ) ) {
	function ucf_news_display_classic_title( $content, $items, $args, $display_type ) {
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

	add_filter( 'ucf_news_display_classic_title', 'ucf_news_display_classic_title', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_classic' ) ) {
	function ucf_news_display_classic( $content, $items, $args, $display_type, $fallback_message='' ) {
		if ( $items === false ) {
			$items = array();
		}
		else if ( ! is_array( $items ) ) {
			$items = array( $items );
		}

		ob_start();
	?>
		<div class="ucf-news-items">
	<?php if ( count( $items ) === 0 ) : echo $fallback_message; ?>
	<?php else : ?>
	<?php
		foreach( $items as $item ) :
			$item_img = UCF_News_Common::get_story_img_tag( $item );
	?>
			<div class="ucf-news-item">
				<?php if ( $item_img ): ?>
				<div class="ucf-news-thumbnail">
					<?php echo $item_img; ?>
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
	endif; // End if item count
	?>
	</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_classic', 'ucf_news_display_classic', 10, 5 );
}

if ( ! function_exists( 'ucf_news_display_classic_after' ) ) {
	function ucf_news_display_classic_after( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_news_display_classic_after', 'ucf_news_display_classic_after', 10, 4 );
}
