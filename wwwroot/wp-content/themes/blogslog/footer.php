<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */

/**
 * blogslog_footer_primary_content hook
 *
 * @hooked blogslog_add_subscribe_section -  10
 *
 */
do_action( 'blogslog_footer_primary_content' );

/**
 * blogslog_content_end_action hook
 *
 * @hooked blogslog_content_end -  10
 *
 */
do_action( 'blogslog_content_end_action' );

/**
 * blogslog_content_end_action hook
 *
 * @hooked blogslog_footer_start -  10
 * @hooked BlogSlog_Footer_Widgets->add_footer_widgets -  20
 * @hooked blogslog_footer_site_info -  40
 * @hooked blogslog_footer_end -  100
 *
 */
do_action( 'blogslog_footer' );

/**
 * blogslog_page_end_action hook
 *
 * @hooked blogslog_page_end -  10
 *
 */
do_action( 'blogslog_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
