<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */
function blogslog_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'blogslog' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}

/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function blogslog_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'blogslog' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}

if ( ! function_exists( 'blogslog_site_layout' ) ) :
    /**
     * Site Layout
     * @return array site layout options
     */
    function blogslog_site_layout() {
        $blogslog_site_layout = array(
            'wide'  => get_template_directory_uri() . '/assets/images/full.png',
            'boxed-layout' => get_template_directory_uri() . '/assets/images/boxed.png',
            'frame-layout' => get_template_directory_uri() . '/assets/images/framed.png',
        );

        $output = apply_filters( 'blogslog_site_layout', $blogslog_site_layout );
        return $output;
    }
endif;

if ( ! function_exists( 'blogslog_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function blogslog_selected_sidebar() {
        $blogslog_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'blogslog' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar', 'blogslog' ),
        );

        $output = apply_filters( 'blogslog_selected_sidebar', $blogslog_selected_sidebar );

        return $output;
    }
endif;


if ( ! function_exists( 'blogslog_global_sidebar_position' ) ) :
    /**
     * Global Sidebar position
     * @return array Global Sidebar positions
     */
    function blogslog_global_sidebar_position() {
        $blogslog_global_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'blogslog_global_sidebar_position', $blogslog_global_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'blogslog_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function blogslog_sidebar_position() {
        $blogslog_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
            'no-sidebar-content'   => get_template_directory_uri() . '/assets/images/boxed.png',
        );

        $output = apply_filters( 'blogslog_sidebar_position', $blogslog_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'blogslog_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function blogslog_pagination_options() {
        $blogslog_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'blogslog' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'blogslog' ),
        );

        $output = apply_filters( 'blogslog_pagination_options', $blogslog_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'blogslog_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function blogslog_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'blogslog' ),
            'off'       => esc_html__( 'Disable', 'blogslog' )
        );
        return apply_filters( 'blogslog_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'blogslog_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function blogslog_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'blogslog' ),
            'off'       => esc_html__( 'No', 'blogslog' )
        );
        return apply_filters( 'blogslog_hide_options', $arr );
    }
endif;

if ( ! function_exists( 'blogslog_sortable_sections' ) ) :
    /**
     * List of sections Control options
     * @return array List of Sections control options.
     */
    function blogslog_sortable_sections() {
        $sections = array(
            'banner'    => esc_html__( 'Banner', 'blogslog' ),
            'about'     => esc_html__( 'About', 'blogslog' ),
            'list_articles' => esc_html__( 'List Articles', 'blogslog' ),
            'blog'      => esc_html__( 'Blog', 'blogslog' ),
        );
        return apply_filters( 'blogslog_sortable_sections', $sections );
    }
endif;


