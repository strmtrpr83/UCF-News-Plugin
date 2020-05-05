<?php
/**
 * Handles the registration of the UCF News Shortcode
 **/

if ( ! class_exists( 'External_Stories_Shortcode' ) ) {
	class External_Stories_Shortcode {
		public static function register_shortcode() {
			add_shortcode( 'ucf-external-stories', array( 'External_Stories_Shortcode', 'sc_external_stories' ) );
		}

		public static function register_shortcode_interface( $registered_shortcodes ) {
			if ( class_exists( 'WP_SCIF_Config' ) ) {
				$fields = array(
					array(
						'name'      => 'Title',
						'param'     => 'title',
						'desc'      => 'The title to display before the news feed',
						'type'      => 'text',
						'default'   => 'In the News'
					),
					array(
						'name'      => 'Layout',
						'param'     => 'layout',
						'desc'      => 'The layout to display the news items',
						'type'      => 'select',
						'options'   => UCF_News_Config::get_external_stories_layouts(),
						'default'   => 'classic'
					),
					array(
						'name'      => 'Number of News Items',
						'param'     => 'limit',
						'desc'      => 'The number of news items to show',
						'type'      => 'number',
						'default'   => 3
					),
					array(
						'name'      => 'News Item Offset',
						'param'     => 'offset',
						'desc'      => 'The number of news items to skip in the feed. For example, set to 1 to skip the first article.',
						'type'      => 'number',
						'default'   => 0
					)
				);
				$shortcode = array(
					'command' => 'ucf-external-stories',
					'name'    => 'UCF External Stories',
					'desc'    => 'Displays a feed of UCF External Stories (In the News)',
					'content' => false,
					'fields'  => $fields,
					'preview' => true,
					'group'   => 'UCF News'
				);

				$registered_shortcodes[] = $shortcode;
				return $registered_shortcodes;
			}
		}

		public static function sc_external_stories( $attr, $content='' ) {
			$feed_url = get_option( 'ucf_external_stories_feed_url' );

			$attr = shortcode_atts( array(
				'title'     => 'In the News',
				'layout'    => 'classic',
				'offset'    => 0,
				'limit'     => 3
			), $attr );

			$title    = $attr['title'];
			$layout   = $attr['layout'];

			$args = array(
				'feed_url' => $feed_url,
				'offset'   => $attr['offset'] ? (int) $attr['offset'] : 0,
				'limit'    => $attr['limit'] ? (int) $attr['limit'] : 3
			);

			$items = UCF_News_Feed::get_external_stories( $args );

			ob_start();

			if ( $items !== null ) {
				echo UCF_News_Common::display_external_stories( $items, $layout, array_merge( $attr, $args ), 'classic', $content );
			}

			return ob_get_clean();
		}
	}
}
