<?php
/*
Plugin Name: Leader Map
*/

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

    $answer = '<div id="leaderMap"></div><script>initLeaderMap();</script>';
    return $answer;
}

add_action( 'init', 'leadermap_init' );