<?php
/**
* Homepage (Static ) options
*
* @package Theme Palace
* @subpackage BlogSlog
* @since BlogSlog 1.0.0
*/

// Homepage (Static ) setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[enable_frontpage_content]', array(
	'sanitize_callback'   => 'blogslog_sanitize_checkbox',
	'default'             => $options['enable_frontpage_content'],
) );

$wp_customize->add_control( 'blogslog_theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Content', 'blogslog' ),
	'description' 	=> esc_html__( 'Check to enable content on static front page only.', 'blogslog' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
) );