<?php
/**
 * Banner Section options
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

// Add Banner section
$wp_customize->add_section( 'blogslog_banner_section', array(
	'title'             => esc_html__( 'Banner','blogslog' ),
	'description'       => esc_html__( 'Banner Section options.', 'blogslog' ),
	'panel'             => 'blogslog_front_page_panel',
) );

// Banner content enable control and setting
$wp_customize->add_setting( 'blogslog_theme_options[banner_section_enable]', array(
	'default'			=> 	$options['banner_section_enable'],
	'sanitize_callback' => 'blogslog_sanitize_switch_control',
) );

$wp_customize->add_control( new BlogSlog_Switch_Control( $wp_customize, 'blogslog_theme_options[banner_section_enable]', array(
	'label'             => esc_html__( 'Banner Section Enable', 'blogslog' ),
	'section'           => 'blogslog_banner_section',
	'on_off_label' 		=> blogslog_switch_options(),
) ) );

// Banner content enable control and setting
$wp_customize->add_setting( 'blogslog_theme_options[banner_search_enable]', array(
	'default'			=> 	$options['banner_search_enable'],
	'sanitize_callback' => 'blogslog_sanitize_switch_control',
) );

$wp_customize->add_control( new BlogSlog_Switch_Control( $wp_customize, 'blogslog_theme_options[banner_search_enable]', array(
	'label'             => esc_html__( 'Search Enable', 'blogslog' ),
	'section'           => 'blogslog_banner_section',
	'active_callback' 	=> 'blogslog_is_banner_section_enable',
	'on_off_label' 		=> blogslog_switch_options(),
) ) );

// banner pages drop down chooser control and setting
$wp_customize->add_setting( 'blogslog_theme_options[banner_content_page]', array(
	'sanitize_callback' => 'blogslog_sanitize_page',
) );

$wp_customize->add_control( new BlogSlog_Dropdown_Chooser( $wp_customize, 'blogslog_theme_options[banner_content_page]', array(
	'label'             => esc_html__( 'Select Page', 'blogslog' ),
	'section'           => 'blogslog_banner_section',
	'choices'			=> blogslog_page_choices(),
	'active_callback'	=> 'blogslog_is_banner_section_enable',
) ) );

// banner posts drop down chooser control and setting
$wp_customize->add_setting( 'blogslog_theme_options[banner_content_post]', array(
	'sanitize_callback' => 'blogslog_sanitize_page',
) );
