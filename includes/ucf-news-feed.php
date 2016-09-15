<?php
/**
 * Handles all feed related code.
 **/

if ( ! class_exists( 'UCF_News_Feed' ) ) {
	class UCF_News_Feed {
		public static function get_news_items( $args ) {
			$args = array(
				'url'        => get_option( 'ucf_news_feed_url', 'https://today.ucf.edu/wp-json/wp/v2/' ),
				'limit'      => $args['limit'] ? (int) $args['limit'] : 3,
				'offset'     => $args['offset'] ? (int) $args['offset'] : null,
				'categories' => is_array( $args['sections'] ) ? implode( '+', $args['sections'] ) : null,
				'tags'       => is_array( $args['topics'] ) ? implode( '+', $args['topics'] ) : null,
			);

			// Empty array of indexes with no value.
			$keys = array_keys( $args, NULL );

			foreach( $keys as $key ) {
				unset( $args[$key] );
			}

			$query = http_build_query( array(
				'per_page'   => $args['limit'],
				'categories' => $args['categories'],
				'tags'       => $args['tags'],
				'_embed'      => true
			) );

			$req_url = $args['url'] . 'posts?' . $query;

			$opts = array(
				'http' => array(
					'timeout' => 15
				)
			);

			$context = stream_context_create( $opts );

			$file = file_get_contents( $req_url, false, $context );

			$items = json_decode( $file );

			return $items;
		}
	}
}
?>
