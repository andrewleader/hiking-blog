<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage BlogSlog
	 * @since BlogSlog 1.0.0
	 */

	/**
	 * blogslog_doctype hook
	 *
	 * @hooked blogslog_doctype -  10
	 *
	 */
	do_action( 'blogslog_doctype' );

?>
<head>
<?php
	/**
	 * blogslog_before_wp_head hook
	 *
	 * @hooked blogslog_head -  10
	 *
	 */
	do_action( 'blogslog_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
<?php
	/**
	 * blogslog_page_start_action hook
	 *
	 * @hooked blogslog_page_start -  10
	 *
	 */
	do_action( 'blogslog_page_start_action' ); 

	/**
	 * blogslog_loader_action hook
	 *
	 * @hooked blogslog_loader -  10
	 *
	 */
	do_action( 'blogslog_before_header' );

	/**
	 * blogslog_header_action hook
	 *
	 * @hooked blogslog_header_start -  10
	 * @hooked blogslog_site_branding -  20
	 * @hooked blogslog_site_navigation -  30
	 * @hooked blogslog_header_end -  50
	 *
	 */
	do_action( 'blogslog_header_action' );

	/**
	 * blogslog_content_start_action hook
	 *
	 * @hooked blogslog_content_start -  10
	 *
	 */
	do_action( 'blogslog_content_start_action' );

	/**
	 * blogslog_header_image_action hook
	 *
	 * @hooked blogslog_header_image -  10
	 *
	 */
	do_action( 'blogslog_header_image_action' );

    if ( blogslog_is_frontpage() ) {

    	$sections = blogslog_sortable_sections();
		foreach ( $sections as $section => $value ) {
			add_action( 'blogslog_primary_content', 'blogslog_add_'. $section .'_section', blogslog_sort( $section ) );
		}
		do_action( 'blogslog_primary_content' );
	}