<?php
/**
 * Archive options
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'blogslog_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive','blogslog' ),
	'description'       => esc_html__( 'Archive section options.', 'blogslog' ),
	'panel'             => 'blogslog_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'blogslog_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'blogslog' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'blogslog' ),
	'section'           => 'blogslog_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'blogslog_is_latest_posts'
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[hide_date]', array(
	'default'           => $options['hide_date'],
	'sanitize_callback' => 'blogslog_sanitize_switch_control',
) );

$wp_customize->add_control( new BlogSlog_Switch_Control( $wp_customize, 'blogslog_theme_options[hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'blogslog' ),
	'section'           => 'blogslog_archive_section',
	'on_off_label' 		=> blogslog_hide_options(),
) ) );

// Archive author category setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[hide_category]', array(
	'default'           => $options['hide_category'],
	'sanitize_callback' => 'blogslog_sanitize_switch_control',
) );

$wp_customize->add_control( new BlogSlog_Switch_Control( $wp_customize, 'blogslog_theme_options[hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'blogslog' ),
	'section'           => 'blogslog_archive_section',
	'on_off_label' 		=> blogslog_hide_options(),
) ) );

// Archive author meta setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[hide_author]', array(
	'default'           => $options['hide_author'],
	'sanitize_callback' => 'blogslog_sanitize_switch_control',
) );

$wp_customize->add_control( new BlogSlog_Switch_Control( $wp_customize, 'blogslog_theme_options[hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'blogslog' ),
	'section'           => 'blogslog_archive_section',
	'on_off_label' 		=> blogslog_hide_options(),
) ) );
