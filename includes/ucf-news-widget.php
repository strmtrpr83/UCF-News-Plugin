<?php
/**
 * Defines the news widget
 **/

if ( ! class_exists( 'UCF_News_Widget' ) ) {
	class UCF_News_Widget extends WP_Widget {
		/**
		* Sets up the widget
		**/
		public function __construct() {
			$widget_opts = array(
				'classname'   => 'ucf_news',
				'description' => 'UCF News Widget'
			);
			parent::__construct( 'ucf_news_widget', 'UCF News Widget', $widget_opts );
		}

		/**
		* Outputs the content of the widget
		* @param array $args
		* @param array $instance
		**/
		public function widget( $args, $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : 'News';
			$title = apply_filters( 'widget_title', $title, $this->id_base );
			$title = $args['before_title'] . $title . $args['after_title'];
			$sections =	str_replace( ' ', '', $instance['sections'] );
			$topics = str_replace( ' ', '', $instance['topics'] );
			$limit = (int) $instance['limit'];
			$offset = (int) $instance['offset'];
			$layout = $instance['layout'];

			$items = UCF_News_Feed::get_news_items( array(
				'title'    => $title,
				'sections' => $sections,
				'topics'   => $topics,
				'limit'    => $limit,
				'offset'   => $offset
			) );

			ob_start();

			if ( $items ):
		?>
			<aside class="widget ucf-news-widget">
		<?php
			echo UCF_News_Common::display_news_items( $items, $layout, $title, 'widget' );
		?>
			</aside>
		<?php
			endif;

			echo ob_get_clean();
		}

		public function form( $instance ) {
			$options = UCF_News_Config::apply_default_options( $instance );

			$title = $options['title'];
			$layout = $options['layout'];
			$sections = $options['sections'];
			$topics = $options['topics'];
			$limit = $options['limit'];
			$offset = $options['offset'];
	?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo __( 'Title' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php echo __( 'Select Layout' ); ?>:</label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" type="text">
				<?php foreach( UCF_News_Config::get_layouts() as $key=>$value ) : ?>
					<option value="<?php echo $key; ?>" <?php echo ( $layout == $key ) ? 'selected' : ''; ?>><?php echo $value; ?></option>
				<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'sections' ) ); ?>"><?php echo __( 'Filter by sections' ); ?></label>
				<input class="widefat section-input" id="<?php echo esc_attr( $this->get_field_id( 'sections' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sections' ) ); ?>" type="text" value="<?php echo esc_attr( $sections ); ?>" >
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'topics' ) ); ?>"><?php echo __( 'Filter by topics' ); ?></label>
				<input class="widefat topic-input" id="<?php echo esc_attr( $this->get_field_id( 'topics' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'topics' ) ); ?>" type="text" value="<?php echo esc_attr( $topics ); ?>" >
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php echo __( 'Limit results' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" value="<?php echo esc_attr( $limit ); ?>" >
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php echo __( 'Offset results' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" value="<?php echo esc_attr( $offset ); ?>" >
			</p>
	<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = UCF_News_Config::apply_default_options( $new_instance );

			return $instance;
		}
	}

	add_action( 'widgets_init',
		create_function( '', 'return register_widget( "UCF_News_Widget" );' )
	);

}

?>
