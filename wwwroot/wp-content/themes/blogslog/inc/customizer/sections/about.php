<?php
/**
 * About Section options
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

// Add About section
$wp_customize->add_section( 'blogslog_about_section', array(
	'title'             => esc_html__( 'About Us','blogslog' ),
	'description'       => esc_html__( 'About Section options.', 'blogslog' ),
	'panel'             => 'blogslog_front_page_panel',
) );

// About content enable control and setting
$wp_customize->add_setting( 'blogslog_theme_options[about_section_enable]', array(
	'default'			=> 	$options['about_section_enable'],
	'sanitize_callback' => 'blogslog_sanitize_switch_control',
) );

$wp_customize->add_control( new BlogSlog_Switch_Control( $wp_customize, 'blogslog_theme_options[about_section_enable]', array(
	'label'             => esc_html__( 'About Section Enable', 'blogslog' ),
	'section'           => 'blogslog_about_section',
	'on_off_label' 		=> blogslog_switch_options(),
) ) );

// about posts drop down chooser control and setting
$wp_customize->add_setting( 'blogslog_theme_options[about_content_post]', array(
	'sanitize_callback' => 'blogslog_sanitize_page',
) );

$wp_customize->add_control( new BlogSlog_Dropdown_Chooser( $wp_customize, 'blogslog_theme_options[about_content_post]', array(
	'label'             => esc_html__( 'Select Post', 'blogslog' ),
	'section'           => 'blogslog_about_section',
	'choices'			=> blogslog_post_choices(),
	'active_callback'	=> 'blogslog_is_about_section_enable',
) ) );

// about btn title setting and control
$wp_customize->add_setting( 'blogslog_theme_options[about_btn_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['about_btn_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'blogslog_theme_options[about_btn_title]', array(
	'label'           	=> esc_html__( 'Button Label', 'blogslog' ),
	'section'        	=> 'blogslog_about_section',
	'active_callback' 	=> 'blogslog_is_about_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'blogslog_theme_options[about_btn_title]', array(
		'selector'            => '#about-us a.btn',
		'settings'            => 'blogslog_theme_options[about_btn_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'blogslog_about_btn_title_partial',
    ) );
}
