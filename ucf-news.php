<?php
/*
Plugin Name: UCF News
Description: Contains shortcode and widget for displaying UCF News Feeds
Version: 1.0.0
Author: UCF Web Communications
License: GPL3
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'plugins_loaded', function() {
	if ( ! class_exists( 'UCF_Modular' ) ) {
		wp_die(
			__( 'This plugin requires the UCF Modular Framework plugin to be installed and activated.' ),
			__( 'Error' ),
			array( 'back_link' => true )
		);
	}

	include_once 'ucf-news-config.php';
	include_once 'ucf-news-feed.php';
	include_once 'ucf-news-common.php';
	include_once 'ucf-news-shortcode.php';
	include_once 'ucf-news-widget.php';

} );

?>
