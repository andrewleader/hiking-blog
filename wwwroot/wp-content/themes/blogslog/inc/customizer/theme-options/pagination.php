<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'blogslog_pagination', array(
	'title'               => esc_html__('Pagination','blogslog'),
	'description'         => esc_html__( 'Pagination section options.', 'blogslog' ),
	'panel'               => 'blogslog_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[pagination_enable]', array(
	'sanitize_callback' => 'blogslog_sanitize_switch_control',
	'default'             => $options['pagination_enable'],
) );

$wp_customize->add_control( new BlogSlog_Switch_Control( $wp_customize, 'blogslog_theme_options[pagination_enable]', array(
	'label'               => esc_html__( 'Pagination Enable', 'blogslog' ),
	'section'             => 'blogslog_pagination',
	'on_off_label' 		=> blogslog_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[pagination_type]', array(
	'sanitize_callback'   => 'blogslog_sanitize_select',
	'default'             => $options['pagination_type'],
) );

$wp_customize->add_control( 'blogslog_theme_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'blogslog' ),
	'section'             => 'blogslog_pagination',
	'type'                => 'select',
	'choices'			  => blogslog_pagination_options(),
	'active_callback'	  => 'blogslog_is_pagination_enable',
) );
