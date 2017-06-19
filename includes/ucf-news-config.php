<?php
/**
 * Handles plugin configuration
 */
if ( ! class_exists( 'UCF_News_Config' ) ) {
	class UCF_News_Config {
		public static
			$options_prefix  = 'ucf_news_',
			$option_defaults = array(
				'title'          => 'News',
				'layout'         => 'classic',
				'sections'       => '',
				'topics'         => '',
				'limit'          => 3,
				'url'            => 'https://today.ucf.edu',
				'feed_url'       => 'https://today.ucf.edu/wp-json/wp/v2/posts/',
				'include_css'    => true,
				'fallback_image' => ''
			);

		public static function get_layouts() {
			$layouts = array(
				'classic' => 'Classic Layout',
				'modern'  => 'Modern Layout'
			);

			$layouts = apply_filters( 'ucf_news_get_layouts', $layouts );

			return $layouts;
		}

		public static function add_options() {
			$defaults = self::$option_defaults;

			add_option( self::$options_prefix . 'url', $defaults['url'] );
			add_option( self::$options_prefix . 'feed_url', $defaults['feed_url'] );
			add_option( self::$options_prefix . 'include_css', $defaults['include_css'] );
			add_option( self::$options_prefix . 'fallback_image', $defaults['fallback_image'] );
		}

		public static function delete_options() {
			delete_option( self::$options_prefix );
			delete_option( self::$options_prefix );
			delete_option( self::$options_prefix );
			delete_option( self::$options_prefix );
		}

		public static function get_option_defaults() {
			$defaults = self::$option_defaults;

			$configurable_defaults = array(
				'url'            => get_option( self::$options_prefix . 'url' ),
				'feed_url'       => get_option( self::$options_prefix . 'feed_url' ),
				'include_css'    => get_option( self::$options_prefix . 'include_css' ),
				'fallback_image' => get_option( self::$options_prefix . 'fallback_image' )
			);

			$configurable_defaults = self::format_options( $configurable_defaults );

			// Force configurable options to override $defaults, even if they are empty
			$defaults = array_merge( $defaults, $configurable_defaults );

			return $defaults;
		}

		public static function apply_option_defaults( $list, $list_keys_only=false ) {
			$defaults = self::get_option_defaults();
			$options = array();

			if ( $list_keys_only ) {
				foreach( $list as $key => $val ) {
					$options[$key] = ! empty( $val ) ? $val : $defaults[$key];
				}
			} else {
				$options = array_merge( $defaults, $list );
			}

			$options = self::format_options( $options );

			return $options;
		}

		public static function format_options( $list ) {
			foreach( $list as $key => $val ) {
				switch( $key ) {
					case 'limit':
						$list[$key] = intval( $val );
						break;
					case 'include_css':
						$list[$key] = filter_var( $val, FILTER_VALIDATE_BOOLEAN );
						break;
					default:
						break;
				}
			}

			return $list;
		}

		public static function get_option_or_default( $option_name ) {
			// Handle $option_name passed in with or without self::$option_prefix applied:
			$option_name_no_prefix = str_replace( self::$options_prefix, '', $option_name );
			$option_name = self::$options_prefix . $option_name_no_prefix;

			$option = get_option( $option_name );
			$option_formatted = self::apply_option_defaults( array(
				$option_name_no_prefix => $option
			), true );

			return $option_formatted[$option_name_no_prefix];
		}

		public static function settings_init() {
			$settings_prefix = 'ucf_news';

			// Keeping dashes and "group" for backwards compatibility
			register_setting( $settings_prefix, self::$options_prefix . 'url' );
			register_setting( $settings_prefix, self::$options_prefix . 'feed_url' );
			register_setting( $settings_prefix, self::$options_prefix . 'include_css' );
			register_setting( $settings_prefix, self::$options_prefix . 'fallback_image' );

			// Add general settings section
			add_settings_section(
				"{$settings_prefix}_section_general",
				'General Settings',
				'',
				$settings_prefix
			);

			// Add general settings
			add_settings_field(
				self::$options_prefix . 'url',
				'UCF Today URL',
				array( 'UCF_News_Config', 'display_settings_field' ),
				$settings_prefix,
				"{$settings_prefix}_section_general",
				array(
					'label_for'   => self::$options_prefix . 'url',
					'description' => 'The url of the UCF Today website (or a specific section/topic). Used to provide "Read More" link.',
					'type'        => 'text'
				)
			);

			add_settings_field(
				self::$options_prefix . 'feed_url',
				'UCF Today Feed URL',
				array( 'UCF_News_Config', 'display_settings_field' ),
				$settings_prefix,
				"{$settings_prefix}_section_general",
				array(
					'label_for'   => self::$options_prefix . 'feed_url',
					'description' => 'The url of the UCF Today feed.',
					'type'        => 'text'
				)
			);

			add_settings_field(
				self::$options_prefix . 'include_css',
				'Include CSS',
				array( 'UCF_News_Config', 'display_settings_field' ),
				$settings_prefix,
				"{$settings_prefix}_section_general",
				array(
					'label_for'   => self::$options_prefix . 'include_css',
					'description' => 'When checked, a default css file will be included on every page. Uncheck if your theme provides specific styles for news.',
					'type'        => 'checkbox'
				)
			);

			add_settings_field(
				self::$options_prefix . 'fallback_image',
				'Fallback Image',
				array( 'UCF_News_Config', 'display_settings_field' ),
				$settings_prefix,
				"{$settings_prefix}_section_general",
				array(
					'label_for'   => self::$options_prefix . 'fallback_image',
					'description' => 'An image to use when one is not available for a story.',
					'type'        => 'image'
				)
			);
		}

		public static function display_settings_field( $args ) {
			$option_name   = $args['label_for'];
			$description   = $args['description'];
			$field_type    = $args['type'];
			$current_value = self::get_option_or_default( $option_name );
			$markup        = '';

			switch( $field_type ) {
				case 'checkbox':
					ob_start();
				?>
					<input type="checkbox" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" <?php echo $current_value == true ? 'checked' : ''; ?>>
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
				case 'text':
				default:
					ob_start();
				?>
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
			}

			echo $markup;
		}

		public static function add_options_page() {
			$page_title = 'UCF News Settings';
			$menu_title = 'UCF News';
			$capability = 'manage_options';
			$menu_slug  = 'ucf_news';
			$callback   = array( 'UCF_News_Config', 'options_page_html' );

			add_options_page(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$callback
			);

		}

		public static function options_page_html() {
			ob_start();
		?>
			<div class="wrap">
				<h1><?php echo get_admin_page_title(); ?></h1>
				<form method="post" action="options.php">
					<?php
					settings_fields( 'ucf_news' );
					do_settings_sections( 'ucf_news' );
					submit_button();
					?>
				</form>
			</div>
		<?php
			echo ob_get_clean();
		}
	}

	add_action( 'admin_init', array( 'UCF_News_Config', 'settings_init' ) );
	add_action( 'admin_menu', array( 'UCF_News_Config', 'add_options_page' ) );
}
?>
