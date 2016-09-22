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
				'categories' => $args['sections'] ? explode( ',', $args['sections'] ) : null,
				'tags'       => $args['topics'] ? explode( ',', $args['topics'] ) : null,
			);

			// Empty array of indexes with no value.
			$keys = array_keys( $args, NULL );

			foreach( $keys as $key ) {
				unset( $args[$key] );
			}

			$categories = self::format_tax_arg( $args['categories'], 'category' );

			$tags = self::format_tax_arg( $args['tags'], 'tag' );

			$filter = array_merge( $categories, $tags );

			$query = http_build_query( array(
				'per_page'   => $args['limit'],
				'filter'     => $filter,
				'_embed'     => true
			) );

			$query = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $query);

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

		public static function format_tax_arg( $terms, $tax ) {
			return array(
				$tax . '_name' => array_filter( $terms )
			);
		}

		public static function get_sections( $search ) {
			$base_url = get_option( 'ucf_news_feed_url', 'https://today.ucf.edu/wp-json/wp/v2/' );
			$url = $base_url . 'categories/?search=' . $search;

			$opts = array(
				'http' => array(
					'timeout' => 15
				)
			);

			$context = stream_context_create( $opts );

			$file = file_get_contents( $url, false, $context );

			$retval = json_decode( $file );

			return $retval;

		}

		public static function get_topics( $search ) {
			$base_url = get_option( 'ucf_news_feed_url', 'https://today.ucf.edu/wp-json/wp/v2/' );
			$url = $base_url . 'tags/?search=' . $search;

			$opts = array(
				'http' => array(
					'timeout' => 15
				)
			);

			$context = stream_context_create( $opts );

			$file = file_get_contents( $url, false, $context );

			$retval = json_decode( $file );

			return $retval;
		}
	}
}
?>
