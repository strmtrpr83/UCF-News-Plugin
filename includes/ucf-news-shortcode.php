<?php
/**
 * Handles the registration of the UCF News Shortcode
 **/

if ( ! class_exists( 'UCF_News_Shortcode' ) ) {
	class UCF_News_Shortcode {
		public static function register_shortcode() {
			add_shortcode( 'ucf-news-feed', array( 'UCF_News_Shortcode', 'sc_ucf_news_feed' ) );
		}

		public static function register_shortcode_interface() {
			if ( class_exists( 'UCF_Shortcode_Interface' ) ) {
				$params = array(
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

				$args = array(
					'name'        => 'UCF News Feed',
					'command'     => 'ucf-news-feed',
					'description' => 'Creates a feed of UCF News Items',
					'params'      => $params
				);

				UCF_Shrotcode_Interface::add_shortcode( $args );
			}
		}

		public static function sc_ucf_news_feed( $attr, $content='' ) {
			$attr = shortcode_atts( array(
				'title'    => 'News',
				'layout'   => 'classic',
				'sections' => '',
				'topics'   => '',
				'offset'   => 0,
				'limit'    => 3
			), $attr );

			$title = $attr['title'];
			$layout = $attr['layout'];

			$args = array(
				'sections' => $attr['sections'] ?: null,
				'topics'   => $attr['topics'] ?: null,
				'offset'   => $attr['offset'] ? (int) $attr['offset'] : 0,
				'limit'    => $attr['limit'] ? (int) $attr['limit'] : 3
			);

			$items = UCF_News_Feed::get_news_items( $args );

			ob_start();

			if ( $items ) {
				echo UCF_News_Common::display_news_items( $items, $layout, $title, 'default' );
			}

			return ob_get_clean();
		}
	}
}

?>
