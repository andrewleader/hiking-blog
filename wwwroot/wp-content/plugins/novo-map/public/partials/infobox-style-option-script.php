var infoboxStyleOptions_<?php echo esc_js(alphanumeric_string($this->slug())) ?> = {
    disableAutoPan: false,
    boxClass: "<?php echo esc_js($this->slug())?> infobox",
    maxWidth: 0,
    pixelOffset: new google.maps.Size(<?php echo esc_js($this->popup_position_x()) ?>,<?php echo esc_js($this->popup_position_y()) ?>),
    zIndex: null,
    closeBoxMargin: "4px 4px 4px 4px",
    closeBoxURL: "<?php echo plugin_dir_url(dirname( __FILE__ )).'assets/images/infobox-styles/button_close.svg' ?>",
    infoBoxClearance: new google.maps.Size(1, 1),
    isHidden: false,
    pane: "floatPane",
    enableEventPropagation: false
};