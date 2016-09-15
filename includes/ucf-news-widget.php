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
			$sections =	$instance['sections'];
			$topics = $instance['topics'];
			$limit = (int) $instance['limit'];
			$layout = $instance['layout'];

			$items = UCF_News_Feed::get_news_items( array(
				'title'    => $title,
				'sections' => $sections,
				'topics'   => $topics,
				'limit'    => $limit
			) );

			ob_start();
	?>
			<aside class="widget ucf-news-widget">
	<?php
			UCF_News_Common::display_news_items( $items, $layout, $title );
	?>
			</aside>
	<?php
			echo ob_get_clean();
		}

		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'News', 'ucf_news' );
			$layout = ! empty( $instance['layout'] ) ? $instance['layout'] : 'classic';
			$sections = ! empty( $instance['sections'] ) ? $instance['sections'] : '';
			$topics = ! empty( $instance['topics'] ) ? $instance['topics'] : '';
			$limit = ! empty( $instance['limit'] ) ? $instance['limit'] : '3';
	?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo __( 'Title' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'sections' ) ); ?>"><?php echo __( 'Filter by sections' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sections' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sections' ) ); ?>" type="text" value="<?php echo esc_attr( $sections ); ?>" >
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'topics' ) ); ?>"><?php echo __( 'Filter by topics' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'topics' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'topics' ) ); ?>" type="text" value="<?php echo esc_attr( $topics ); ?>" >
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php echo __( 'Select Layout' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" type="text">
				<?php foreach( UCF_News_Config::get_layouts() as $key=>$value ) : ?>
					<option value="<?php echo $key; ?>" <?php echo ( $layout == $key ) ? 'selected' : ''; ?>><?php echo $value; ?></option>
				<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php echo __( 'Limit results' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" value="<?php echo esc_attr( $limit ); ?>" >
			</p>
	<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? $new_instance['title'] : __( 'News', 'ucf-news' );
			$instance['sections'] = ( ! empty( $new_instance['sections'] ) ) ? str_replace( ' ', '', $new_instance['sections'] ) : '';
			$instance['topics']   = ( ! empty( $new_instance['topics'] ) ) ? str_replace( ' ', '', $new_instance['topics'] ) : '';
			$instance['limit']    = ( ! empty( $new_instance['limit'] ) ) ? (int) $new_instance['limit'] : 3;
			$instance['layout']   = ( ! empty( $new_instance['layout'] ) ) ? $new_instance['layout'] : 'classic';

			return $instance;
		}
	}

	add_action( 'widgets_init',
		create_function( '', 'return register_widget( "UCF_News_Widget" );' )
	);

}

?>
