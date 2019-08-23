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

global $entity; // Area or Route
 
$fields = $entity->getFields();

$title = $entity->getListTitle();
$link = get_permalink($entity->post);

$routes = array();
$displayRouteNames = false;

if ($entity instanceof Route) {
    $routes[] = $entity;
} else if ($entity instanceof Area) {
    $routes = $entity->getRoutes();
    if (sizeof($routes) == 1) {
        // Make the title be the route itself
        $title = $routes[0]->getListTitle();
        $link = get_permalink($routes[0]->post);
    } else {
        $displayRouteNames = true;
    }
}

?>

<article class="map-window-preview">

    <h4 class="map-window-preview-title"><a target="_blank" href="<?php echo $link; ?>"><?php echo $title; ?></a></h2>
    
    <?php foreach ($routes as $route) : ?>
    
        <?php if ($displayRouteNames) : ?>
            <h5 class="map-window-preview-route-title"><a target="_blank" href="<?php echo get_permalink($route->post) ?>"><?php echo $route->getChildListTitle() ?></a></h5>
        <?php endif; ?>
        <p><?php echo $route->getFields()->createListSubtitle() ?></p>
    
    <?php endforeach; ?>

</article>
