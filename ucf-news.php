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

	define( 'UCF_NEWS__PLUGIN_DIR', plugins_url( '/ucf-news/' ) );

	require_once 'includes/ucf-news-config.php';
	require_once 'includes/ucf-news-feed.php';
	require_once 'includes/ucf-news-common.php';
	require_once 'includes/ucf-news-shortcode.php';
	require_once 'includes/ucf-news-widget.php';
	require_once 'admin/ucf-news-admin.php';
	require_once 'admin/ucf-news-api.php';

	add_action( 'init', array( 'UCF_News_Shortcode', 'register_shortcode' ) );
	add_action( 'admin_init', array( 'UCF_News_Shortcode', 'register_shortcode_interface' ) );
	add_action( 'admin_menu', array( 'UCF_News_Config', 'add_options_page' ) );
	add_action( 'rest_api_init', array( 'UCF_News_Admin_API', 'register_routes' ) );

} );

?>
