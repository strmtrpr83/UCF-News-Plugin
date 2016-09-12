<?php
/**
 * Place common functions here.
 **/

class UCF_News_Common {
	public function display_news_items( $items, $layout, $title ) {
		do_action( 'ucf_news_display_' . $layout . '_before', array( $items, $title ) );
		do_action( 'ucf_news_display_' . $layout, array( $items, $title ) );
		do_action( 'ucf_news_display_' . $layout . '_after', array( $items, $title ) );
	}
}

function ucf_news_display_classic( $items, $title ) {
	ob_start();
?>

<?php
	return ob_get_clean();
}

add_action( 'ucf_news_display_classic', 'ucf_news_display_classic' );

?>
