<?php
/**
 * Handles all feed related code.
 **/

if ( ! class_exists( 'UCF_News_Feed' ) ) {
	class UCF_News_Feed {
		public static function get_json_feed( $feed_url ) {
			$response = wp_safe_remote_get( $feed_url, array( 'timeout' => 15 ) );

			if ( is_array( $response ) && wp_remote_retrieve_response_code( $response ) == 200 ) {
				$result = json_decode( wp_remote_retrieve_body( $response ) );
			}
			else {
				$result = false;
			}

			return $result;
		}

		public static function format_tax_arg( $terms, $tax ) {
			$terms_filtered = is_array( $terms ) ? array_filter( $terms ) : array();

			return array(
				$tax => $terms_filtered
			);
		}

		public static function get_news_items( $args ) {

			$args = array(
				'url'        => get_option( 'ucf_news_feed_url', 'https://today.ucf.edu/wp-json/wp/v2/' ),
				'limit'      => isset( $args['limit'] ) ? (int) $args['limit'] : 3,
				'offset'     => isset( $args['offset'] ) ? (int) $args['offset'] : 0,
				'categories' => isset( $args['sections'] ) ? explode( ',', $args['sections'] ) : null,
				'tags'       => isset( $args['topics'] ) ? explode( ',', $args['topics'] ) : null,
			);

			// Empty array of indexes with no value.
			$keys = array_keys( $args, NULL );

			foreach( $keys as $key ) {
				unset( $args[$key] );
			}

			// Set up query params.
			$categories = $tags = array();

			if ( isset( $args['categories'] ) ) {
				$categories = self::format_tax_arg( $args['categories'], 'category_name' );
			}
			if ( isset( $args['tags'] ) ) {
				$tags = self::format_tax_arg( $args['tags'], 'tag' );
			}

			$filter = array_merge( $categories, $tags );

			$query = http_build_query( array(
				'per_page'   => $args['limit'],
				'offset'     => $args['offset'],
				'filter'     => $filter,
				'_embed'     => true
			) );
			$query = preg_replace( '/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $query );

			// Fetch feed
			$feed_url = $args['url'] . 'posts?' . $query;

			return self::get_json_feed( $feed_url );
		}

		public static function get_sections( $search ) {
			$base_url = get_option( 'ucf_news_feed_url', 'https://today.ucf.edu/wp-json/wp/v2/' );
			$url      = $base_url . 'categories/?search=' . $search;

			return self::get_json_feed( $url );
		}

		public static function get_topics( $search ) {
			$base_url = get_option( 'ucf_news_feed_url', 'https://today.ucf.edu/wp-json/wp/v2/' );
			$url      = $base_url . 'tags/?search=' . $search;

			return self::get_json_feed( $url );
		}
	}
}
?>
