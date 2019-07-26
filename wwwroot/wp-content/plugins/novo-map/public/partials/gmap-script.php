<script type="text/javascript">
    function initialize_<?php echo esc_js($gmap_name) ?>() {
        var centerLatlng = new google.maps.LatLng(<?php echo esc_js($this->latitude()) ?>,<?php echo esc_js($this->longitude()) ?>);
        var mapSettings = {
            zoom: <?php echo esc_js($this->zoom()) ?>,
            center: centerLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl: false,
            panControl: false,
            mapTypeControl: <?php echo $this->type_menu() ? 'true' : 'false' ?>,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                position: google.maps.ControlPosition.<?php echo esc_js($this->type_menu_position()) ?>},
            zoomControl: <?php echo $this->zoom_button() ? 'true' : 'false' ?>,
            zoomControlOptions: {
                position: google.maps.ControlPosition.<?php echo esc_js($this->zoom_button_position()) ?>}
        };
        var <?php echo esc_js($gmap_name) ?> =
        new google.maps.Map(document.getElementById("<?php echo esc_js($gmap_name) ?>"), mapSettings);

        // pin clustering options
        <?php
        if( $this->pin_clustering()){
        ?>
        var clusterMarkers = [];
        var cmStyles = [{
            url: '<?php echo esc_js($marker_logo_list[$this->clustering_marker_logo_id_small()]->url()) ?>',
            width: <?php echo esc_js($marker_logo_list[$this->clustering_marker_logo_id_small()]->width()) ?>,
            height: <?php echo esc_js($marker_logo_list[$this->clustering_marker_logo_id_small()]->height()) ?>,
            textColor: '<?php echo esc_js($this->clustering_text_color()) ?>',
            textSize: <?php echo esc_js($this->clustering_text_size_small()) ?>,
            anchor: [<?php echo esc_js($this->clustering_text_align_y_small()) ?>, <?php echo esc_js($this->clustering_text_align_x_small()) ?>]
        }, {
            url: '<?php echo esc_js($marker_logo_list[$this->clustering_marker_logo_id_medium()]->url()) ?>',
            width: <?php echo esc_js($marker_logo_list[$this->clustering_marker_logo_id_medium()]->width()) ?>,
            height: <?php echo esc_js($marker_logo_list[$this->clustering_marker_logo_id_medium()]->height()) ?>,
            textColor: '<?php echo esc_js($this->clustering_text_color()) ?>',
            textSize: <?php echo esc_js($this->clustering_text_size_medium()) ?>,
            anchor: [<?php echo esc_js($this->clustering_text_align_y_medium()) ?>, <?php echo esc_js($this->clustering_text_align_x_medium()) ?>]
        }, {
            url: '<?php echo esc_js($marker_logo_list[$this->clustering_marker_logo_id_big()]->url()) ?>',
            width: <?php echo esc_js($marker_logo_list[$this->clustering_marker_logo_id_big()]->width()) ?>,
            height: <?php echo esc_js($marker_logo_list[$this->clustering_marker_logo_id_big()]->height()) ?>,
            textColor: '<?php echo esc_js($this->clustering_text_color()) ?>',
            textSize: <?php echo esc_js($this->clustering_text_size_big()) ?>,
            anchor: [<?php echo esc_js($this->clustering_text_align_y_big()) ?>, <?php echo esc_js($this->clustering_text_align_x_big()) ?>]
        }];
        var mcOptions = {gridSize: <?php echo esc_js( $this->clustering_grid_size() ) ?>, styles: cmStyles};

        <?php
        }
        ?>

        //map style
        var styles = <?php echo $this->style() ?>;
        <?php echo esc_js($gmap_name) ?>.setOptions({styles: styles});

        // loop through necessary marker logos and generate them
        <?php
        foreach ($marker_logo_list as $id => $marker_logo) {
            $marker_logo->generate_script();
        }

        // generate option for the different infobox styles
        foreach ($infobox_style_list as $option_name => $infobox_style) {
            $infobox_style->generate_option_script();
        }

        // generate all markers and attached infoboxes
        foreach ($marker_list as $id => $marker) {
            if (get_post_status($marker->post_id()) == 'publish') {
                $marker->generate_script($this, $gmap_name, $infobox_style_list);
            }
        }

        //activate pin clustering if necessary
        if($this->pin_clustering()) { ?>
        var mc = new MarkerClusterer(<?php echo esc_js($gmap_name) ?>, clusterMarkers, mcOptions);
        <?php
        }

        //add additional marker if necessary
        if($this->additional_marker()) {
            $additional_marker->generate_script($this, $gmap_name, '');
        }
        ?>
    }
    //define prev infobox to close the infobox on new infobox click
    var prevInfobox = false;
    <?php
    if($this->load_scripts()) {
    ?>
    google.maps.event.addDomListener(window, 'load', initialize_<?php echo esc_js($gmap_name) ?>);
    <?php
    }
    ?>
</script>