var markerLogo<?php echo esc_js($this->id()) ?> = {
    url: '<?php echo esc_js($this->url()) ?>',
    scaledSize: new google.maps.Size(<?php echo esc_js($this->width()) ?>,<?php echo esc_js($this->height()) ?>),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(<?php echo esc_js($this->anchor_x()) ?>,<?php echo esc_js($this->anchor_y()) ?>)
};