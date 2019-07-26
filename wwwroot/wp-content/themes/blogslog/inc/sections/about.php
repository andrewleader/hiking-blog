<?php
/**
 * About section
 *
 * This is the template for the content of about section
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */
if ( ! function_exists( 'blogslog_add_about_section' ) ) :
    /**
    * Add about section
    *
    *@since BlogSlog 1.0.0
    */
    function blogslog_add_about_section() {
        $options = blogslog_get_theme_options();
        // Check if about is enabled on frontpage
        $about_enable = apply_filters( 'blogslog_section_status', true, 'about_section_enable' );

        if ( true !== $about_enable ) {
            return false;
        }
        // Get about section details
        $section_details = array();
        $section_details = apply_filters( 'blogslog_filter_about_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render about section now.
        blogslog_render_about_section( $section_details );
    }
endif;

if ( ! function_exists( 'blogslog_get_about_section_details' ) ) :
    /**
    * about section details.
    *
    * @since BlogSlog 1.0.0
    * @param array $input about section details.
    */
    function blogslog_get_about_section_details( $input ) {
        $options = blogslog_get_theme_options();
        $content = array();
        $post_id = ! empty( $options['about_content_post'] ) ? $options['about_content_post'] : '';
        $args = array(
            'post_type'         => 'post',
            'p'                 => $post_id,
            'posts_per_page'    => 1,
            'ignore_sticky_posts' => true,
            );

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['author']    = blogslog_author();
                $page_post['excerpt']   = blogslog_trim_content( 30 );
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'large' ) : '';

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
        endif;
        wp_reset_postdata();
            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// about section content details.
add_filter( 'blogslog_filter_about_section_details', 'blogslog_get_about_section_details' );


if ( ! function_exists( 'blogslog_render_about_section' ) ) :
  /**
   * Start about section
   *
   * @return string about content
   * @since BlogSlog 1.0.0
   *
   */
   function blogslog_render_about_section( $content_details = array() ) {
        $options = blogslog_get_theme_options();
        $readmore = ! empty( $options['about_btn_title'] ) ? $options['about_btn_title'] : esc_html__( 'Read More', 'blogslog' );

        if ( empty( $content_details ) ) {
            return;
        } 

        foreach ( $content_details as $content ) : ?>

            <div id="about-us" class="relative page-section blog-posts">
                <div class="wrapper">
                    <article class="<?php echo ! empty( $content['image'] ) ? 'has' : 'no'; ?>-post-thumbnail">
                        <?php if ( ! empty( $content['image'] ) ) : ?>
                            <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');">
                                <a href="<?php echo esc_url( $content['url'] ); ?>" class="post-thumbnail-link"></a>
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <span class="cat-links">
                                <?php the_category( '', '', $content['id'] ); ?>
                            </span><!-- .cat-links -->

                            <?php if ( ! empty( $content['title'] ) ) : ?>
                                <div class="entry-header">
                                    <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                </div>
                            <?php endif;

                            if ( ! empty( $content['excerpt'] ) ) : ?>
                                <div class="entry-content">
                                    <p><?php echo wp_kses_post( $content['excerpt'] ); ?></p>
                                </div><!-- .entry-content -->
                            <?php endif; ?>

                            <div class="entry-meta">
                                <?php 
                                    blogslog_posted_on( $content['id'] ); 
                                    echo wp_kses_post( $content['author'] );
                                ?>  
                            </div><!-- .entry-meta -->

                            <div class="read-more">
                                <a href="<?php echo esc_url( $content['url'] ); ?>" class="btn"><?php echo esc_html( $readmore ); ?></a>
                            </div><!-- .read-more -->
                        </div><!-- .entry-container -->
                    </article>
                </div><!-- .wrapper -->
            </div><!-- #about-us -->

        <?php endforeach;
    }
endif;