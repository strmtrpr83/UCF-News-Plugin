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

	include_once 'ucf-news-config.php';
	include_once 'ucf-news-feed.php';
	include_once 'ucf-news-common.php';
	include_once 'ucf-news-shortcode.php';
	include_once 'ucf-news-widget.php';

	add_action( UCF_Modular::$slug . '_config', UCF_Modular::$config->add_shortcode( 'UCF_News_Shortcode' ) );

} );

?>
