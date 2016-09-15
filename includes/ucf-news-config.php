<?php
/**
 * Handles plugin configuration
 */
if ( ! class_exists( 'UCF_News_Config' ) ) {
	class UCF_News_Config {
		public static function add_options_page() {
			add_options_page(
				'UCF News',
				'UCF News',
				'manage_options',
				'ucf_news_settings',
				array(
					'UCF_News_Config',
					'add_settings_page'
				)
			);

			add_action( 'admin_init', array( 'UCF_News_Config', 'register_settings' ) );
		}

		public static function register_settings() {
			register_setting( 'ucf-news-group', 'ucf_news_feed_url' );
			register_setting( 'ucf-news-group', 'ucf_news_include_css' );
		}

		public static function add_settings_page() {
	?>
	<div class="wrap">
	<h1>UCF News Settings</h1>
	<form method="post" action="options.php">
		<?php settings_fields( 'ucf-news-group' ); ?>
		<?php do_settings_sections( 'ucf-news-groups' ); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">UCF News Feed URL</th>
				<td><input type="text" name="ucf_news_feed_url" value="<?php echo esc_attr( get_option( 'ucf_news_feed_url' ) ); ?>"></td>
			</tr>
			<tr valign="top">
				<th scope="row">Include CSS</th>
				<td><input type="checkbox" name="ucf_news_include_css" <?php echo ( get_option( 'ucf_news_include_css' ) === 'on' ) ? 'checked' : ''; ?>>
					Include Default Css
				</input></td>
			</tr>
		<?php submit_button(); ?>
	</form>
	<?php
		}
	}
}
?>
