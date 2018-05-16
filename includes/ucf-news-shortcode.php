<?php
/**
 * Handles the registration of the UCF News Shortcode
 **/

if ( ! class_exists( 'UCF_News_Shortcode' ) ) {
	class UCF_News_Shortcode {
		public static function register_shortcode() {
			add_shortcode( 'ucf-news-feed', array( 'UCF_News_Shortcode', 'sc_ucf_news_feed' ) );
		}

		public static function register_shortcode_interface( $registered_shortcodes ) {
			if ( class_exists( 'WP_SCIF_Config' ) ) {
				$fields = array(
					array(
						'name'      => 'Title',
						'param'     => 'title',
						'desc'      => 'The title to display before the news feed',
						'type'      => 'text',
						'default'   => 'News'
					),
					array(
						'name'      => 'Layout',
						'param'     => 'layout',
						'desc'      => 'The layout to display the news items',
						'type'      => 'select',
						'options'   => UCF_News_Config::get_layouts(),
						'default'   => 'classic'
					),
					array(
						'name'      => 'Filter by Section ID',
						'param'     => 'sections',
						'desc'      => 'The section id of each section to filter by',
						'type'      => 'text',
						'default'   => ''
					),
					array(
						'name'      => 'Filter by Topic ID',
						'param'     => 'topics',
						'desc'      => 'The topic id of each topic to filter by',
						'type'      => 'text',
						'default'   => ''
					),
					array(
						'name'      => 'Number of News Items',
						'param'     => 'limit',
						'desc'      => 'The number of news items to show',
						'type'      => 'number',
						'default'   => 3
					),
					array(
						'name'      => 'Number of News Items Per Row',
						'param'     => 'per_row',
						'desc'      => 'The number of news items to show per row (for card layout only)',
						'type'      => 'number',
						'default'   => 3
					)
				);
				$shortcode = array(
					'command' => 'ucf-news-feed',
					'name'    => 'UCF News Feed',
					'desc'    => 'Displays a feed of UCF News items.',
					'content' => false,
					'fields'  => $fields,
					'preview' => true,
					'group'   => 'UCF News'
				);

				$registered_shortcodes[] = $shortcode;
				return $registered_shortcodes;
			}
		}

		public static function sc_ucf_news_feed( $attr, $content='' ) {
			$attr = shortcode_atts( array(
				'title'     => 'News',
				'layout'    => 'classic',
				'sections'  => '',
				'topics'    => '',
				'offset'    => 0,
				'limit'     => 3,
				'per_row'    => 3
			), $attr );

			$title = $attr['title'];
			$layout = $attr['layout'];
			$per_row = $attr['per_row'];

			$args = array(
				'sections' => $attr['sections'] ?: null,
				'topics'   => $attr['topics'] ?: null,
				'offset'   => $attr['offset'] ? (int) $attr['offset'] : 0,
				'limit'    => $attr['limit'] ? (int) $attr['limit'] : 3
			);

			$items = UCF_News_Feed::get_news_items( $args );

			ob_start();

			if ( $items !== null ) {
				echo UCF_News_Common::display_news_items( $items, $layout, array_merge( $attr, $args ), 'default', $content );
			}

			return ob_get_clean();
		}
	}
}

if ( ! function_exists( 'ucf_news_shortcode_interface_styles' ) ) {
	function ucf_news_shortcode_interface_styles( $stylesheets ) {
		$defaults = UCF_News_Config::get_default_plugin_options();
		if ( get_option( 'ucf_news_include_css', $defaults['ucf_news_include_css'] ) === 'on' ) {
			$stylesheets[] = plugins_url( 'static/css/ucf-news.min.css', UCF_NEWS__PLUGIN_FILE );
		}
		return $stylesheets;
	}
}
