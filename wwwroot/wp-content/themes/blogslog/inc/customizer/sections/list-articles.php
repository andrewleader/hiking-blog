<?php
/**
 * List Articles Section options
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

// Add List Articles section
$wp_customize->add_section( 'blogslog_list_articles_section', array(
	'title'             => esc_html__( 'List Articles','blogslog' ),
	'description'       => esc_html__( 'List Articles Section options.', 'blogslog' ),
	'panel'             => 'blogslog_front_page_panel',
) );

// List Articles content enable control and setting
$wp_customize->add_setting( 'blogslog_theme_options[list_articles_section_enable]', array(
	'default'			=> 	$options['list_articles_section_enable'],
	'sanitize_callback' => 'blogslog_sanitize_switch_control',
) );

$wp_customize->add_control( new BlogSlog_Switch_Control( $wp_customize, 'blogslog_theme_options[list_articles_section_enable]', array(
	'label'             => esc_html__( 'List Articles Section Enable', 'blogslog' ),
	'section'           => 'blogslog_list_articles_section',
	'on_off_label' 		=> blogslog_switch_options(),
) ) );

// Add dropdown category setting and control.
$wp_customize->add_setting(  'blogslog_theme_options[list_articles_content_category]', array(
	'sanitize_callback' => 'blogslog_sanitize_single_category',
) ) ;

$wp_customize->add_control( new BlogSlog_Dropdown_Taxonomies_Control( $wp_customize,'blogslog_theme_options[list_articles_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'blogslog' ),
	'description'      	=> esc_html__( 'Note: Latest two posts will be shown from selected category', 'blogslog' ),
	'section'           => 'blogslog_list_articles_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'blogslog_is_list_articles_section_enable'
) ) );

// list articles readmore text  setting and control
$wp_customize->add_setting( 'blogslog_theme_options[list_articles_readmore]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['list_articles_readmore'],
) );

$wp_customize->add_control( 'blogslog_theme_options[list_articles_readmore]', array(
	'label'           	=> esc_html__( 'Read More Text', 'blogslog' ),
	'section'        	=> 'blogslog_list_articles_section',
	'active_callback' 	=> 'blogslog_is_list_articles_section_enable',
	'type'				=> 'text',
) );
