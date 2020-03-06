<?php
/**
 * Handles admin actions
 **/
if ( ! class_exists( 'UCF_News_Admin' ) ) {
	class UCF_News_Admin {
		public static function enqueue_admin_scripts() {
			if ( is_admin() ) {
				wp_enqueue_script( 'suggest' );

				$plugin_data   = get_plugin_data( UCF_NEWS__PLUGIN_FILE, false, false );
				$version       = $plugin_data['Version'];
				wp_enqueue_script( 'ucf-news-suggest', plugins_url( 'static/js/ucf-news-admin.min.js', UCF_NEWS__PLUGIN_FILE ), array( 'suggest' ), $version, true );
			}
		}
	}

	add_action( 'admin_enqueue_scripts', array( 'UCF_News_Admin', 'enqueue_admin_scripts' ) );

}
?>
