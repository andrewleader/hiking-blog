//create the marker
var markerPosition<?php echo esc_js($this->id()) ?> = new google.maps.LatLng(<?php echo esc_js($this->latitude()) ?>, <?php echo esc_js($this->longitude()) ?>);
var marker<?php echo esc_js($this->id()) ?> = new google.maps.Marker({
    position: markerPosition<?php echo esc_js($this->id()) ?>,
    map: <?php echo esc_js($gmap_name) ?>,
    icon: markerLogo<?php echo esc_js($this->marker_logo_id()) ?>,
    title: "<?php echo esc_js($this->title()) ?>"
});
// add the Infobox if it's defined in the map or from the markers
<?php
$this_infobox_style = $this->infobox_style();
$gmap_infobox_style = $gmap->infobox_style();
if(! empty($this_infobox_style) and $gmap_infobox_style != 'no') {
    $infobox_style = $infobox_style_list[$gmap_infobox_style];
    $infobox_style->generate_infobox_script($this, $gmap_name);
}
elseif(! empty($this_infobox_style)) {
    $infobox_style = $infobox_style_list[$this_infobox_style];
    $infobox_style->generate_infobox_script($this, $gmap_name);
}?>
//Push marker to pin clustering if active
<?php
$this_id = $this->id();
if($gmap->pin_clustering() and ! empty($this_id)) { ?>
    clusterMarkers.push(marker<?php echo esc_js($this->id()) ?>);
<?php } ?>