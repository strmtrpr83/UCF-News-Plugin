<?php
/**
 * Handles the registration of the UCF News Shortcode
 **/
class UCF_News_Shortcode extends UCF_Modular_Shortcode {
	public
		$name        = 'UCF News Feed',
		$command     = 'ucf-news-feed',
		$description = 'Displays a news feed pulled from UCF Today',
		$callback    = 'callback',
		$wysiwyg     = TRUE;

	function params() {
		$layouts = UCF_NewsConfig::get_layouts();
		
		return array(
			array(
				'name'      => 'Title',
				'id'        => 'title',
				'help_text' => 'The title to display before the news feed',
				'type'      => 'text',
				'default'   => 'News'
			),
			array(
				'name'      => 'Layout',
				'id'        => 'layout',
				'help_text' => 'The layout to use to display the news items',
				'type'      => 'dropdown',
				'choices'   => $layouts,
				'default'   => 'classic'
			),
			array(
				'name'      => 'Filter by Section ID',
				'id'        => 'sections',
				'help_text' => 'The section id of each section to filter by',
				'type'      => 'text',
				'default'   => ''
			),
			array(
				'name'      => 'Filter by Topic ID',
				'id'        => 'topics',
				'help_text' => 'The topic id of each topic to filter by',
				'type'      => 'text',
				'default'   => ''
			),
			array(
				'name'      => 'Number of News Items',
				'id'        => 'limit',
				'help_text' => 'The number of news items to show',
				'type'      => 'number',
				'default'   => '3'
			)
		);
	}

	function callback( $attr, $content='' ) {
		$attr = shortcode_atts( array(
			'title'    => 'News',
			'layout'   => 'classic',
			'sections' => '',
			'topics'   => '',
			'limit'    => 3
		), $attr);

		$title = $attr['title'];
		$layout = $attr['layout'];

		$args = array(
			'sections' => $attr['sections'] ? explode( ',', $attr['sections'] ) : null,
			'topics'   => $attr['topics'] ? explode( ',', $attr['topics'] ) : null,
			'limit'    => $attr['limit'] ? (int) $attr['limit'] : 3
		);

		$items = UCF_News_Feed::get_news_items( $args );
		echo UCF_News_Common::display_news_items( $items, $layout, $title );
	}
}
?>
