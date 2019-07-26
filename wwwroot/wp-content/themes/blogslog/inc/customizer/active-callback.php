<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

if ( ! function_exists( 'blogslog_is_loader_enable' ) ) :
	/**
	 * Check if loader is enabled.
	 *
	 * @since BlogSlog 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function blogslog_is_loader_enable( $control ) {
		return $control->manager->get_setting( 'blogslog_theme_options[loader_enable]' )->value();
	}
endif;

if ( ! function_exists( 'blogslog_is_breadcrumb_enable' ) ) :
	/**
	 * Check if breadcrumb is enabled.
	 *
	 * @since BlogSlog 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function blogslog_is_breadcrumb_enable( $control ) {
		return $control->manager->get_setting( 'blogslog_theme_options[breadcrumb_enable]' )->value();
	}
endif;

if ( ! function_exists( 'blogslog_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since BlogSlog 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function blogslog_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'blogslog_theme_options[pagination_enable]' )->value();
	}
endif;

/**
 * Front Page Active Callbacks
 */

/**
 * Check if banner section is enabled.
 *
 * @since BlogSlog 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function blogslog_is_banner_section_enable( $control ) {
	return ( $control->manager->get_setting( 'blogslog_theme_options[banner_section_enable]' )->value() );
}

/**
 * Check if about section is enabled.
 *
 * @since BlogSlog 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function blogslog_is_about_section_enable( $control ) {
	return ( $control->manager->get_setting( 'blogslog_theme_options[about_section_enable]' )->value() );
}

/**
 * Check if list_articles section is enabled.
 *
 * @since BlogSlog 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function blogslog_is_list_articles_section_enable( $control ) {
	return ( $control->manager->get_setting( 'blogslog_theme_options[list_articles_section_enable]' )->value() );
}

/**
 * Check if blog section is enabled.
 *
 * @since BlogSlog 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function blogslog_is_blog_section_enable( $control ) {
	return ( $control->manager->get_setting( 'blogslog_theme_options[blog_section_enable]' )->value() );
}

/**
 * Check if blog section content type is category.
 *
 * @since BlogSlog 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function blogslog_is_blog_section_content_category_enable( $control ) {
	$content_type = $control->manager->get_setting( 'blogslog_theme_options[blog_content_type]' )->value();
	return blogslog_is_blog_section_enable( $control ) && ( 'category' == $content_type );
}

/**
 * Check if blog section content type is recent.
 *
 * @since BlogSlog 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function blogslog_is_blog_section_content_recent_enable( $control ) {
	$content_type = $control->manager->get_setting( 'blogslog_theme_options[blog_content_type]' )->value();
	return blogslog_is_blog_section_enable( $control ) && ( 'recent' == $content_type );
}
