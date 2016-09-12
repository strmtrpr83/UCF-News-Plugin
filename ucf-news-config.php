<?php
/**
 * Handles plugin configuration
 */
function ucf_news_add_customizer_sections( $wp_customize ) {
	$wp_customize->add_section(
		'ucf_news_plugin_settings',
		array(
			'title' => 'UCF News Plugin Settings'
		)
	);
}

add_action( 'customize_register', 'ucf_news_add_customizer_sections' );

function ucf_news_add_customizer_settings( $wp_customize ) {

	$wp_customize->add_setting(
		'ucf_news_feed_url'
	);
	$wp_customize->add_control(
		'ucf_news_feed_url',
		array(
			'type'        => 'text',
			'label'       => 'UCF News WP API Feed URL',
			'description' => 'The base url of the UCF News WP API Feed URL',
			'section'     => 'ucf_news_plugin_settings'
		)
	);

	$wp_customize->add_setting(
		'ucf_news_include_css'
	);
	$wp_customize->add_control(
		'ucf_news_include_css',
		array(
			'type'        => 'checkbox',
			'label'       => 'Include Default CSS',
			'description' => 'Include the default css stylesheet on the page.',
			'section'     => 'ucf_news_plugin_settings'
		)
	);
}

add_action( 'customize_register', 'ucf_news_add_customizer_settings' );

?>
