var infoboxContent<?php echo esc_js($marker->id()) ?> = document.createElement("div");
infoboxContent<?php echo esc_js($marker->id()) ?>.innerHTML =
<?php
ob_start();
include(plugin_dir_path(dirname( __FILE__ )).'partials/infobox-styles/'.$this->html_template());
$infobox_innerHtml = ob_get_contents();
ob_end_clean();
echo trim(preg_replace('/\s+/', ' ', $infobox_innerHtml));
?>;
infoboxStyleOptions_<?php echo esc_js(alphanumeric_string($this->slug())) ?>.content = infoboxContent<?php echo esc_js($marker->id()) ?>;
infobox<?php echo esc_js($marker->id()) ?> = new InfoBox(infoboxStyleOptions_<?php echo esc_js(alphanumeric_string($this->slug())) ?>);
google.maps.event.addListener(marker<?php echo esc_js($marker->id()) ?>, 'click', function (e) {
    infobox<?php echo esc_js($marker->id()) ?>.open(<?php echo esc_js( $gmap_name ) ?>, this);

    //close previous infobox on click
    if(prevInfobox && prevInfobox!=infobox<?php echo esc_js($marker->id()) ?>) {
        prevInfobox.close()
    }
    prevInfobox = infobox<?php echo esc_js($marker->id()) ?>

    //responsive pixeloffset to work with max-width: 90% in css
    var mapWidth = document.getElementById(this.map.getDiv().id).offsetWidth;
    if(mapWidth <= <?php echo esc_js($this->width()) ?>*1.1) {
        infobox<?php echo esc_js($marker->id()) ?>.setOptions({'pixelOffset':new google.maps.Size((-mapWidth/2)*0.9, -<?php echo esc_js($this->height()) ?>/2)});
    }

    <?php echo esc_js( $gmap_name ) ?>.setCenter(marker<?php echo esc_js($marker->id()) ?>.getPosition());
});
google.maps.event.addListener(<?php echo esc_js( $gmap_name ) ?>, "click", function(e) {
    infobox<?php echo esc_js($marker->id()) ?>.close();
});
