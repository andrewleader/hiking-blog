<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 * @return array An array of default values
 */

function blogslog_get_default_theme_options() {
	$blogslog_default_options = array(
		// Color Options
		'header_title_color'			=> '#fff',
		'header_tagline_color'			=> '#fff',
		'header_txt_logo_extra'			=> 'show-all',

		// breadcrumb
		'breadcrumb_enable'				=> true,
		'breadcrumb_separator'			=> '/',
		
		// layout 
		'site_layout'         			=> 'wide',
		'sidebar_position'         		=> 'right-sidebar',
		'post_sidebar_position' 		=> 'right-sidebar',
		'page_sidebar_position' 		=> 'right-sidebar',

		// pagination options
		'pagination_enable'         	=> true,
		'pagination_type'         		=> 'default',

		// footer options
		'copyright_text'           		=> sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'blogslog' ), '[the-year]', '[site-link]' ),
		'scroll_top_visible'        	=> true,

		// reset options
		'reset_options'      			=> false,
		
		// homepage options
		'enable_frontpage_content' 		=> false,

		// homepage sections sortable
		'sortable' 						=> 'Banner,About,List Articles,Recent Articles,Popular Articles,Blog',

		// blog/archive options
		'your_latest_posts_title' 		=> esc_html__( 'Blogs', 'blogslog' ),
		'hide_date' 					=> false,
		'hide_category'					=> false,
		'hide_author'					=> false,

		// single post theme options
		'single_post_hide_date' 		=> false,
		'single_post_hide_author'		=> false,
		'single_post_hide_category'		=> false,
		'single_post_hide_tags'			=> false,

		/* Front Page */

		// Banner
		'banner_section_enable'			=> true,
		'banner_search_enable'			=> true,

		// about
		'about_section_enable' 			=> true,
		'about_btn_title'				=> esc_html__( 'Read More', 'blogslog' ), 

		// list_articles
		'list_articles_section_enable' 	=> true,
		'list_articles_readmore'		=> esc_html__( 'Continue Reading', 'blogslog' ), 

		// blog
		'blog_section_enable'			=> true,
		'blog_content_type'				=> 'recent',
		'blog_title'					=> esc_html__( 'Popuar Posts', 'blogslog' ),

	);

	$output = apply_filters( 'blogslog_default_theme_options', $blogslog_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}