<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage BlogSlog
* @since BlogSlog 1.0.0
*/

if ( ! function_exists( 'blogslog_about_btn_title_partial' ) ) :
    // about btn title
    function blogslog_about_btn_title_partial() {
        $options = blogslog_get_theme_options();
        return esc_html( $options['about_btn_title'] );
    }
endif;

if ( ! function_exists( 'blogslog_blog_title_partial' ) ) :
    // blog title
    function blogslog_blog_title_partial() {
        $options = blogslog_get_theme_options();
        return esc_html( $options['blog_title'] );
    }
endif;

if ( ! function_exists( 'blogslog_copyright_text_partial' ) ) :
    // blog btn title
    function blogslog_copyright_text_partial() {
        $options = blogslog_get_theme_options();
        return esc_html( $options['copyright_text'] );
    }
endif;

if ( ! function_exists( 'blogslog_powered_by_text_partial' ) ) :
    // blog btn title
    function blogslog_powered_by_text_partial() {
        $options = blogslog_get_theme_options();
        return esc_html( $options['powered_by_text'] );
    }
endif;
