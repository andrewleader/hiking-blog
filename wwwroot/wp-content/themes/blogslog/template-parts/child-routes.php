<?php
/**
 * Template part for displaying child routes
 */
?>

<?php

	// https://www.advancedcustomfields.com/resources/querying-relationship-fields/
	$routes = get_posts(array(
		'post_type' => 'routes',
		'numberposts' => 20,
		'meta_query' => array(
			array(
				'key' => 'peak',
				'value' => get_the_ID()
			)
		)
	));
?>

<h2>Routes</h2>
<?php if ($routes): ?>
	<div class="archive-blog-wrapper blog-posts clear">
	<?php
	$originalPost = $post;
	$GLOBALS['displayingChild'] = true;
	foreach( $routes as $route ) {
		$post = $route;
		get_template_part( 'template-parts/content' );
	}
	
	$post = $originalPost;
	$GLOBALS['displayingChild'] = false;
	?>
	</div>
<?php else: ?>
<p>There are no routes for this peak. Add some!</p>
<? endif ?>