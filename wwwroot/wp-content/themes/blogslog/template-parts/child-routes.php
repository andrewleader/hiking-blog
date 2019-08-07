<?php
/**
 * Template part for displaying child routes
 */
?>

<?php

	// https://www.advancedcustomfields.com/resources/querying-relationship-fields/
	$routes = get_posts(array(
		'post_type' => 'routes',
		'meta_query' => array(
			array(
				'key' => 'peak',
				'value' => '"' . get_the_ID() . '"',
				'compare' => 'LIKE'
			)
		)
	));
?>

<?php if ($routes): ?>
	<h2>Routes</h2>
	<ul>
	<?php foreach( $routes as $route ): ?>
		<li>
			<a href="<?php echo get_permalink( $route->ID ); ?>">
				<?php echo get_the_title( $route->ID ); ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
<? endif ?>