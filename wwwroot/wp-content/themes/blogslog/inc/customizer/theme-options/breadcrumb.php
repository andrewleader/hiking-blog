<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

$wp_customize->add_section( 'blogslog_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','blogslog' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'blogslog' ),
	'panel'             => 'blogslog_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'blogslog_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new BlogSlog_Switch_Control( $wp_customize, 'blogslog_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'blogslog' ),
	'section'          	=> 'blogslog_breadcrumb',
	'on_off_label' 		=> blogslog_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'blogslog_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'blogslog' ),
	'active_callback' 	=> 'blogslog_is_breadcrumb_enable',
	'section'          	=> 'blogslog_breadcrumb',
) );
