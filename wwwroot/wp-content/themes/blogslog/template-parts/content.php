<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */
 
 require_once('fields.php');
 
 $fields = Fields::get($post);
 
 $title = $post->post_title;
 if (isset($fields->peakPost)) {
     $title = $fields->peakPost->post_title . " - " . $title;
 }
 
 $subtitle = $fields->createListSubtitle();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'post-thumbnail' ) ?>');">
            <a href="<?php the_permalink(); ?>" class="post-thumbnail-link"></a>
        </div><!-- .featured-image -->
    <?php endif; ?>

    <div class="entry-container">
        <span class="cat-links">
            <?php echo blogslog_article_footer_meta(); ?>
        </span><!-- .cat-links -->

        <header class="entry-header">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h2>
            <h3 class="entry-subtitle"><?php echo $subtitle ?></h3>
        </header>

        <div class="entry-content">
            <p><?php the_excerpt(); ?></p>
        </div><!-- .entry-content -->

        <?php

            $includeMeta = true;

            // No meta for these
            switch ($post->post_type) {
                case "peak":
                case "route":
                    $includeMeta = false;
                    break;
            }

            if ($includeMeta) { ?>

                <div class="entry-meta">
                    <?php

                        switch ($post->post_type) {
                            case "trip_plan":
                                $dateText = $fields->getDateString();
                                ?>
                                    <span class="posted-on">
                                        <span class="screen-reader-text">Planned for</span>
                                        <span><?php echo htmlspecialchars($dateText); ?></span>
                                    </span>
                                <?php
                                break;

                            default:
                                blogslog_posted_on();
                                break;
                        }

                        echo blogslog_author();
                    ?>
                </div><!-- .entry-meta -->


            <?php }
        ?>
    </div><!-- .entry-container -->

</article><!-- #post-## -->
