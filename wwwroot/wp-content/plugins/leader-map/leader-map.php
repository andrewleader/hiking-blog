<?php
/*
Plugin Name: Leader Map
*/

require_once($_SERVER['DOCUMENT_ROOT'].'/model/peak.php');

function leadermap_init() {
    
    add_shortcode('leadermap', 'leadermap_handler');
    
    wp_enqueue_style(
        'leader-map-css',
        plugins_url('leader-map.css', __FILE__),
        array(), // dependencies
        filemtime(dirname(__FILE__) . '/leader-map.css') // version number
    );
    
    wp_enqueue_script(
        'leader-map-js',
        plugins_url('leader-map.js', __FILE__),
        array(), // dependencies
        filemtime(dirname(__FILE__) . '/leader-map.js') // version number
    );
    
    wp_enqueue_script(
        'leader-map-js-google',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyAouPWaETNwNjBoDgzqp18lGcf-7AdZlMc&callback=googleMapJsReady',
        array() // dependencies
    );
 
}

function leadermap_handler($attrs, $content, $tag) {
    // https://kinsta.com/blog/wordpress-shortcodes/
    // attrs -> Array of attributes or an empty string
    // content -> the enclosed content (available for enclosing shortcodes like [gist]5698283[/gist] only)
    // tag -> the name of the shortcode, useful for shared callback functions
    // Must return a string of HTML
    
    $peaks = get_posts(array(
			'post_type' => 'routes',
			'numberposts' => 10000
		));
        
    $jsData = array();
    global $post;
    $originalPost = $post;
    foreach ($peaks as $peak) {
        $peak = new Route($peak);
        if ($peak->getFields()->summit->hasValue()) {
            $post = $peak->post;
            ob_start();
            require $_SERVER['DOCUMENT_ROOT']."/wp-content/themes/blogslog/template-parts/content.php";
            $htmlPreview = ob_get_clean();
            $jsData[] = array(
                'name' => $peak->post->post_title,
                'position' => array(
                    'lat' => floatval($peak->getFields()->summit->value['lat']),
                    'lng' => floatval($peak->getFields()->summit->value['lng'])
                ),
                'htmlPreview' => $htmlPreview
            );
        }
    }
    $post = $originalPost;
    
    $jsDataJson = json_encode($jsData);

    $answer = '<div id="leaderMap"></div><script>initLeaderMap('.$jsDataJson.');</script>';
    return $answer;
}

add_action( 'init', 'leadermap_init' );