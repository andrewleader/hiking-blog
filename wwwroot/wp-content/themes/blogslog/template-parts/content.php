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
 
require_once($_SERVER['DOCUMENT_ROOT'].'/model/postEntity.php');

global $entity;
$entity = PostEntity::get($post);
 
$fields = $entity->getFields();

if (!$GLOBALS['displayingChild']) {
    $title = $entity->getListTitle();
} else {
    $title = $entity->getChildListTitle();
}

$subtitle = $fields->createListSubtitle();
$thumbnail = $entity->getThumbnailUrl( 'post-thumbnail' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( $thumbnail ) : ?>
        <div class="featured-image" style="background-image: url('<?php echo esc_url($thumbnail) ?>');">
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
            if ($entity instanceof Peak || $entity instanceof Route) {
                $includeMeta = false;
            }

            if ($includeMeta) { ?>

                <div class="entry-meta">
                    <?php
                        
                        if ($entity instanceof Plan) {
                            $dateText = $fields->getDateString();
                            ?>
                                <span class="posted-on">
                                    <span class="screen-reader-text">Planned for</span>
                                    <span><?php echo htmlspecialchars($dateText); ?></span>
                                </span>
                            <?php
                        } else {
                            blogslog_posted_on();
                        }

                        echo blogslog_author();
                    ?>
                </div><!-- .entry-meta -->


            <?php }
        ?>
    </div><!-- .entry-container -->

</article><!-- #post-## -->
