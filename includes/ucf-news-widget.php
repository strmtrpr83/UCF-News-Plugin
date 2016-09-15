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
			$options = UCF_News_Config::apply_default_options( $instance );

			$title = $options['title'];
			$layout = $options['layout'];
			$sections = $options['sections'];
			$topics = $options['topics'];
			$limit = $options['limit'];
	?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo __( 'Title' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
	<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = UCF_News_Config::apply_default_options( $new_instance );

			return $instance;
		}

		public function add_script() {
			wp_enqueue_script( 'suggest' );
		}

		public function add_script_config() {
?>
		<script type="text/javascript">
			jQuery('.section-input').suggest("<?php echo UCF_News_Admin_API::get_plugin_namespace() . '/sections'; ?>", {multiple:true, multipleSep: ","}); 
		</script>
<?php
		}
	}

	add_action( 'widgets_init',
		create_function( '', 'return register_widget( "UCF_News_Widget" );' )
	);

}

?>
