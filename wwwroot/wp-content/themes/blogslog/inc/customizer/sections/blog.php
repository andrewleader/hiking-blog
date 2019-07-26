<?php
/**
 * Blog Section options
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

// Add Blog section
$wp_customize->add_section( 'blogslog_blog_section', array(
	'title'             => esc_html__( 'Blog','blogslog' ),
	'description'       => esc_html__( 'Blog Section options.', 'blogslog' ),
	'panel'             => 'blogslog_front_page_panel',
) );

// Blog content enable control and setting
$wp_customize->add_setting( 'blogslog_theme_options[blog_section_enable]', array(
	'default'			=> 	$options['blog_section_enable'],
	'sanitize_callback' => 'blogslog_sanitize_switch_control',
) );

$wp_customize->add_control( new BlogSlog_Switch_Control( $wp_customize, 'blogslog_theme_options[blog_section_enable]', array(
	'label'             => esc_html__( 'Blog Section Enable', 'blogslog' ),
	'section'           => 'blogslog_blog_section',
	'on_off_label' 		=> blogslog_switch_options(),
) ) );

// blog title setting and control
$wp_customize->add_setting( 'blogslog_theme_options[blog_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['blog_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'blogslog_theme_options[blog_title]', array(
	'label'           	=> esc_html__( 'Title', 'blogslog' ),
	'section'        	=> 'blogslog_blog_section',
	'active_callback' 	=> 'blogslog_is_blog_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'blogslog_theme_options[blog_title]', array(
		'selector'            => '#popular-posts .section-header h2.section-title',
		'settings'            => 'blogslog_theme_options[blog_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'blogslog_blog_title_partial',
    ) );
}

// Blog content type control and setting
$wp_customize->add_setting( 'blogslog_theme_options[blog_content_type]', array(
	'default'          	=> $options['blog_content_type'],
	'sanitize_callback' => 'blogslog_sanitize_select',
) );

$wp_customize->add_control( 'blogslog_theme_options[blog_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'blogslog' ),
	'section'           => 'blogslog_blog_section',
	'type'				=> 'select',
	'active_callback' 	=> 'blogslog_is_blog_section_enable',
	'choices'			=> array( 
		'category' 	=> esc_html__( 'Category', 'blogslog' ),
		'recent' 	=> esc_html__( 'Recent', 'blogslog' ),
	),
) );

// Add dropdown category setting and control.
$wp_customize->add_setting(  'blogslog_theme_options[blog_content_category]', array(
	'sanitize_callback' => 'blogslog_sanitize_single_category',
) ) ;

$wp_customize->add_control( new BlogSlog_Dropdown_Taxonomies_Control( $wp_customize,'blogslog_theme_options[blog_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'blogslog' ),
	'description'      	=> esc_html__( 'Note: Latest selected no of posts will be shown from selected category', 'blogslog' ),
	'section'           => 'blogslog_blog_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'blogslog_is_blog_section_content_category_enable'
) ) );

// Add dropdown categories setting and control.
$wp_customize->add_setting( 'blogslog_theme_options[blog_category_exclude]', array(
	'sanitize_callback' => 'blogslog_sanitize_category_list',
) ) ;

$wp_customize->add_control( new BlogSlog_Dropdown_Category_Control( $wp_customize,'blogslog_theme_options[blog_category_exclude]', array(
	'label'             => esc_html__( 'Select Excluding Categories', 'blogslog' ),
	'description'      	=> esc_html__( 'Note: Select categories to exclude. Press Shift key select multilple categories.', 'blogslog' ),
	'section'           => 'blogslog_blog_section',
	'type'              => 'dropdown-categories',
	'active_callback'	=> 'blogslog_is_blog_section_content_recent_enable'
) ) );
