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

<article class="map-details">
    
    <?php if (sizeof($routes) == 1) : ?>
    
        <?php $featuredThumbnail = $routes[0]->getThumbnailUrl('post-thumbnail'); ?>
        
        <?php if ($featuredThumbnail) : ?>
    
            <a target="_blank" href="<?php echo esc_url($link) ?>"><img class="map-details-hero-img" src="<?php echo esc_url($routes[0]->getThumbnailUrl('post-thumbnail')) ?>"/></a>
        
        <?php endif; ?>
    
    <?php endif; ?>

    <h4 class="map-details-title"><a target="_blank" href="<?php echo $link; ?>"><?php echo $title; ?></a></h4>
    
    <?php if (sizeof($routes) > 1) : ?>
    
        <!-- List of routes -->
        <div class="map-details-routes">
    
            <?php foreach ($routes as $route) : ?>
            
                <?php 
                    $routeTitle = $route->getChildListTitle();
                    $routeLink = get_permalink($route->post);
                    $routeSubtitle = $route->getFields()->createListSubtitle(); ?>
        
                <div class="map-details-route">
                    
                    <a target="_blank" href="<?php echo esc_url($routeLink) ?>"><img src="<?php echo esc_url($route->getThumbnailUrl('post-thumbnail')) ?>"/></a>
                    
                    <div class="map-details-route-text">
                        <h5><a target="_blank" href="<?php echo esc_url($routeLink) ?>"><?php echo $routeTitle ?></a></h5>
                        <h6><?php echo $routeSubtitle ?></h6>
                    </div>
                    
                </div>
            
            <?php endforeach; ?>
        
        </div>
    
    <?php else : ?>
    
        <?php if (sizeof($routes) > 0) : ?>
            <h6><?php echo $routes[0]->getFields()->createListSubtitle(); ?></h6>
        
            <p><?php echo get_the_excerpt($routes[0]->post); ?></p>
        <?php endif; ?>
    
    <?php endif; ?>

</article>
