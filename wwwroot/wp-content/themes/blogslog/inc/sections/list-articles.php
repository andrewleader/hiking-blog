<?php
/**
 * List Articles section
 *
 * This is the template for the content of list articles section
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */
if ( ! function_exists( 'blogslog_add_list_articles_section' ) ) :
    /**
    * Add list articles section
    *
    *@since BlogSlog 1.0.0
    */
    function blogslog_add_list_articles_section() {
    	$options = blogslog_get_theme_options();
        // Check if list articles is enabled on frontpage
        $list_articles_enable = apply_filters( 'blogslog_section_status', true, 'list_articles_section_enable' );

        if ( true !== $list_articles_enable ) {
            return false;
        }
        // Get list articles section details
        $section_details = array();
        $section_details = apply_filters( 'blogslog_filter_list_articles_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render list articles section now.
        blogslog_render_list_articles_section( $section_details );
    }
endif;

if ( ! function_exists( 'blogslog_get_list_articles_section_details' ) ) :
    /**
    * list articles section details.
    *
    * @since BlogSlog 1.0.0
    * @param array $input list articles section details.
    */
    function blogslog_get_list_articles_section_details( $input ) {
        $options = blogslog_get_theme_options();

        $content = array();
        $cat_id = ! empty( $options['list_articles_content_category'] ) ? $options['list_articles_content_category'] : '';
        $args = array(
            'post_type'         => 'post',
            'posts_per_page'    => 2,
            'cat'               => absint( $cat_id ),
            'ignore_sticky_posts'   => true,
            );                    


            // Run The Loop.
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) : 
                while ( $query->have_posts() ) : $query->the_post();
                    $page_post['id']        = get_the_id();
                    $page_post['title']     = get_the_title();
                    $page_post['url']       = get_the_permalink();
                    $page_post['excerpt']   = blogslog_trim_content( 25 );
                    $page_post['author']    = blogslog_author();
                    $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : '';

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
// list articles section content details.
add_filter( 'blogslog_filter_list_articles_section_details', 'blogslog_get_list_articles_section_details' );


if ( ! function_exists( 'blogslog_render_list_articles_section' ) ) :
  /**
   * Start list articles section
   *
   * @return string list articles content
   * @since BlogSlog 1.0.0
   *
   */
   function blogslog_render_list_articles_section( $content_details = array() ) {
        $options = blogslog_get_theme_options();
        $readmore = ! empty( $options['list_articles_readmore'] ) ? $options['list_articles_readmore'] : esc_html__( 'Continue Reading', 'blogslog' );

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="call-to-action" class="relative page-section blog-posts">
            <div class="wrapper">
                <?php foreach ( $content_details as $content ) : ?>
                    <article class="<?php echo ! empty( $content['image'] ) ? 'has' : 'no'; ?>-featured-image">
                        <?php if ( ! empty( $content['image'] ) ) : ?>
                            <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');">
                                <a href="<?php echo esc_url( $content['url'] ); ?>" class="post-thumbnail-link"></a>
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <span class="cat-links">
                                <?php the_category( '', '', $content['id'] ); ?>
                            </span><!-- .cat-links -->

                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                            </header>

                            <div class="entry-content">
                                <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                            </div><!-- .entry-content -->

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
                <?php endforeach; ?>
            </div><!-- .wrapper -->
        </div><!-- #call-to-action -->

    <?php }
endif;