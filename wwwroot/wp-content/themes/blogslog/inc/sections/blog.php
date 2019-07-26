<?php
/**
 * Blog section
 *
 * This is the template for the content of blog section
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */
if ( ! function_exists( 'blogslog_add_blog_section' ) ) :
    /**
    * Add blog section
    *
    *@since BlogSlog 1.0.0
    */
    function blogslog_add_blog_section() {
    	$options = blogslog_get_theme_options();
        // Check if blog is enabled on frontpage
        $blog_enable = apply_filters( 'blogslog_section_status', true, 'blog_section_enable' );

        if ( true !== $blog_enable ) {
            return false;
        }
        // Get blog section details
        $section_details = array();
        $section_details = apply_filters( 'blogslog_filter_blog_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render blog section now.
        blogslog_render_blog_section( $section_details );
    }
endif;

if ( ! function_exists( 'blogslog_get_blog_section_details' ) ) :
    /**
    * blog section details.
    *
    * @since BlogSlog 1.0.0
    * @param array $input blog section details.
    */
    function blogslog_get_blog_section_details( $input ) {
        $options = blogslog_get_theme_options();

        // Content type.
        $blog_content_type  = $options['blog_content_type'];
        
        $content = array();
        switch ( $blog_content_type ) {
        	
            case 'category':
                $cat_id = ! empty( $options['blog_content_category'] ) ? $options['blog_content_category'] : '';
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 4,
                    'cat'               => absint( $cat_id ),
                    'ignore_sticky_posts'   => true,
                    );                    
            break;

            case 'recent':
                $cat_ids = ! empty( $options['blog_category_exclude'] ) ? $options['blog_category_exclude'] : array();
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 4,
                    'category__not_in'  => ( array ) $cat_ids,
                    'ignore_sticky_posts'   => true,
                    );                    
            break;

            default:
            break;
        }


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = blogslog_trim_content( 25 );
                $page_post['author']    = blogslog_author();
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : '';

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
// blog section content details.
add_filter( 'blogslog_filter_blog_section_details', 'blogslog_get_blog_section_details' );


if ( ! function_exists( 'blogslog_render_blog_section' ) ) :
  /**
   * Start blog section
   *
   * @return string blog content
   * @since BlogSlog 1.0.0
   *
   */
   function blogslog_render_blog_section( $content_details = array() ) {
        $options = blogslog_get_theme_options();
        $blog_content_type  = $options['blog_content_type'];
        $i = 0;

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="popular-posts" class="relative page-section blog-posts">
                <div class="wrapper">
                    <?php if ( ! empty( $options['blog_title'] ) ) : ?>
                        <div class="section-header clear">
                            <h2 class="section-title"><?php echo esc_html( $options['blog_title'] ); ?></h2>
                        </div><!-- .section-header -->
                    <?php endif; ?>

                    <div class="section-content clear">
                        <?php foreach ( $content_details as $content ) : ?>
                            <article class="<?php echo ! empty( $content['image'] ) ? 'has' : 'no'; ?>-post-thumbnail <?php echo ( ( 0 == $i ) || ( $i%4 == 0 ) ) ? 'full-width' : ''; ?>">
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
                                </div><!-- .entry-container -->
                            </article>
                        <?php $i++; endforeach; ?>
                    </div><!-- .section-content -->

                </div><!-- .wrapper -->
            </div><!-- #popular-posts -->

    <?php }
endif;