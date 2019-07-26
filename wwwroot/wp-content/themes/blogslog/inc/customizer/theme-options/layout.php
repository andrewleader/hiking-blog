<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'blogslog_layout', array(
	'title'               => esc_html__('Layout','blogslog'),
	'description'         => esc_html__( 'Layout section options.', 'blogslog' ),
	'panel'               => 'blogslog_theme_options_panel',
) );

// Site layout setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[site_layout]', array(
	'sanitize_callback'   => 'blogslog_sanitize_select',
	'default'             => $options['site_layout'],
) );

$wp_customize->add_control(  new BlogSlog_Custom_Radio_Image_Control ( $wp_customize, 'blogslog_theme_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'blogslog' ),
	'section'             => 'blogslog_layout',
	'choices'			  => blogslog_site_layout(),
) ) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'blogslog_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new BlogSlog_Custom_Radio_Image_Control ( $wp_customize, 'blogslog_theme_options[sidebar_position]', array(
	'label'               => esc_html__( 'Global Sidebar Position', 'blogslog' ),
	'section'             => 'blogslog_layout',
	'choices'			  => blogslog_global_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'blogslog_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new BlogSlog_Custom_Radio_Image_Control ( $wp_customize, 'blogslog_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'blogslog' ),
	'section'             => 'blogslog_layout',
	'choices'			  => blogslog_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'blogslog_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new BlogSlog_Custom_Radio_Image_Control( $wp_customize, 'blogslog_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'blogslog' ),
	'section'             => 'blogslog_layout',
	'choices'			  => blogslog_sidebar_position(),
) ) );