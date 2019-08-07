<?php
/**
 * Template part for displaying posts. This is the single page full post.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */
$options = blogslog_get_theme_options();

require_once('children.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/postEntity.php');

global $entity;
$entity = PostEntity::get($post);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear' ); ?>>

	<div class="custom-fields">
		<?php get_template_part( 'template-parts/content-fields' ); ?>
	</div>

	<div class="entry-meta">
        <?php if ( ! $options['single_post_hide_date'] ) : 
        	blogslog_posted_on();
        endif; ?>
    </div><!-- .entry-meta -->

	<div class="entry-container">
		<div class="entry-content">
			<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'blogslog' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
				
				if ($entity instanceof Peak) {
					displayChildEntities("Routes", $entity->getRoutes());
				} else {
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blogslog' ),
						'after'  => '</div>',
					) );
				}
			?>
		</div><!-- .entry-content -->
	</div><!-- .entry-container -->
	
	<div class="entry-meta">
		<?php 
			if ( ! $options['single_post_hide_author'] ) : 
	        	echo blogslog_author(); 
	        endif; 
			blogslog_single_categories();
			blogslog_entry_footer(); 
		?>
	</div>
</article><!-- #post-## -->
