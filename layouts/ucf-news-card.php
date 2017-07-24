<?php
/**
 * The default functions for the card layout
 **/
if ( ! function_exists( 'ucf_news_display_card_before' ) ) {
	function ucf_news_display_card_before( $items, $title, $display_type ) {
		ob_start();
	?>
		<div class="ucf-news card-layout">
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_news_display_card_before', 'ucf_news_display_card_before', 10, 3 );
}

if ( ! function_exists( 'ucf_news_display_card_title' ) ) {
	function ucf_news_display_card_title( $item, $title, $display_type ) {
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

	add_action( 'ucf_news_display_card_title', 'ucf_news_display_card_title', 10, 3 );
}

if ( ! function_exists( 'ucf_news_display_card' ) ) {
	function ucf_news_display_card( $items, $title, $per_row, $display_type ) {
		if ( ! is_array( $items ) ) { $items = array( $items ); }
		ob_start();

		echo '<div class="ucf-news-card-deck">';

		foreach( $items as $index=>$item ) :
		$date = date("M d",strtotime($item->date));
		$item_img = UCF_News_Common::get_story_image_or_fallback( $item );
	?>
		<?php
			if( $index !== 0 && ( $index % $per_row ) === 0 ) {
				echo '</div><div class="ucf-news-card-deck">';
			}
		?>
		<div class="ucf-news-card">
			<a class="ucf-news-card-link" href="<?php echo $item->link; ?>">
				<img src="<?php echo $item_img; ?>" class="ucf-news-thumbnail-image" alt="<?php echo $item->title->rendered; ?>">
				<div class="ucf-news-card-block">
					<h3 class="ucf-news-card-title"><?php echo $item->title->rendered; ?></h3>
					<p class="ucf-news-card-text"><?php echo $date; ?></p>
				</div>
			</a>
		</div>
	<?php
		endforeach;

		echo '</div>';

		echo ob_get_clean();
	}

	add_action( 'ucf_news_display_card', 'ucf_news_display_card', 10, 4 );
}

if ( ! function_exists( 'ucf_news_display_card_after' ) ) {
	function ucf_news_display_card_after( $items, $title, $display_type ) {
		ob_start();
	?>
		</div>
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_news_display_card_after', 'ucf_news_display_card_after', 10, 3 );
}