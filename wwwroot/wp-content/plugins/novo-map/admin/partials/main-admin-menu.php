<div id="<?php echo $this->plugin_name.'-gmap-marker-logo-folder-images' ?>">
    <div class="gmap-marker-logo-wrap">
        <span id="<?php echo $this->plugin_name.'-gmap-marker-logo-folder-images-close' ?>">
            <img src="<?php echo $this->plugin_dir_url. 'admin/assets/images/close.svg' ?>">
        </span>
        <h4><?php _e('Default Markers', $this->plugin_name) ?></h4>
        <div>
            <?php
            foreach ($default_marker_logos as $default_marker) {
                echo '<img data-src="'.esc_attr($default_marker->id()).'" src="'.esc_attr($default_marker->url()).'" width="'.esc_attr($default_marker->width()).'" height="'.esc_attr($default_marker->height()).'">';
            }
            ?>
        </div>
        <h4><?php _e('User defined Markers', $this->plugin_name) ?></h4>
        <div>
            <?php
            foreach ($user_marker_logos as $user_marker) {
                echo '<img data-src="'.esc_attr($user_marker->id()).'" src="'.esc_attr($user_marker->url()).'" width="'.esc_attr($user_marker->width()).'" height="'.esc_attr($user_marker->height()).'">';
            }
            ?>
        </div>
    </div>
</div>

<div class="wrap <?php echo $this->plugin_name.'-main-admin-menu' ?>">
    <h2><?php esc_html_e(get_admin_page_title())?></h2>
    <ul>
        <li><?php _e( 'If you enjoy the plugin, we would really appreciate if you could <a href="https://wordpress.org/support/plugin/novo-map/reviews/" target="_blank">drop us a review</a> or support us with <a href="https://www.paypal.me/novomedia" target="_blank">a donation</a>', $this->plugin_name ) ?></li>
        <li><?php _e( 'If you find a bug or have any suggestion, create a <a href="https://wordpress.org/support/plugin/novo-map" target="_blank">new topic in the plugin support</a>', $this->plugin_name ) ?></li>
        <li><?php _e( 'If you need detailed information about the plugin, have a look at <a href="https://www.novo-monde.com/novo-map-user-guide/" target="_blank">the user guide</a>', $this->plugin_name ) ?></li>
    </ul>
    <hr>
    <form method="post" action="">
        <?php wp_nonce_field( $this->plugin_name.'-main_admin_menu', $this->plugin_name.'-main_admin_menu_nonce' ) ?>
        <label for="<?php echo $this->plugin_name ?>-gmap-api_key"><?php _e( 'Google Map API Key. If you dont have one, <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">get an API Key</a>', $this->plugin_name ) ?></label>
        <input type="text" name="<?php echo $this->plugin_name ?>-gmap-api_key" value="<?php echo get_option($this->plugin_name.'_gmap_api_key') ?>" required/>
        <input class="button-primary" type="submit" name="<?php echo $this->plugin_name ?>-gmap-save-api-key" value="<?php _e( 'Save API key', $this->plugin_name ) ?>" /><br>
        <label for="<?php echo $this->plugin_name ?>-gmap-delete_duplicate_markers"><?php _e( 'If you happen to have some duplicated markers (due to post revisions), click on this button to delete them', $this->plugin_name ) ?></label>
        <input class="button-primary" type="submit" name="<?php echo $this->plugin_name ?>-gmap-delete-duplicate-markers" value="<?php _e( 'Delete duplicated markers', $this->plugin_name ) ?>" /><br>
        <h4><?php _e('Select an existing Map or create a new one', $this->plugin_name ) ?></h4>
        <select class="<?php echo $this->plugin_name ?>-inline" name="<?php echo $this->plugin_name ?>-gmap-gmap_list" onchange="location = this.value;">
            <option value="admin.php?page=novo-map" selected="selected"></option>
            <?php
            $selected = (isset($_GET['newmap'])) ? ' selected="selected"' : '';
            echo '<option value="admin.php?page=novo-map&newmap=1"'.$selected.'>'.__('Create a new Map', $this->plugin_name).'</option>';
            foreach($gmap_list as $map) {
                $selected = ($map->id() == $gmap->id()) ? ' selected="selected"' : '';
                echo '<option value="'.add_query_arg( 'id', $map->id(), 'admin.php?page=novo-map' ).'"'.$selected.'>'.esc_html($map->name()).'</option>';
            }
            ?>
        </select>
        <?php
        if(isset($_GET['id']) or isset($_GET['newmap'])) {
        ?>
            <fieldset>
                <legend ><?php esc_html_e($gmap->name()) ?></legend>
                <div class="<?php echo $this->plugin_name ?>-gmap-left">
                    <input type="hidden" name="<?php echo $this->plugin_name ?>-gmap-id" value="<?php esc_attr_e($gmap->id()) ?>">
                    <label for="<?php echo $this->plugin_name ?>-gmap-name"><?php _e( 'Map name (has to be unique)', $this->plugin_name ) ?></label>
                    <input type="text" name="<?php echo $this->plugin_name ?>-gmap-name" value="<?php esc_attr_e($gmap->name()) ?>" required/><br>
                    <div class="<?php echo $this->plugin_name ?>-inline">
                        <label for="<?php echo $this->plugin_name ?>-gmap-width"><?php _e( 'Map Width (in px or %)', $this->plugin_name ) ?></label>
                        <input type="text" name="<?php echo $this->plugin_name ?>-gmap-width" value="<?php esc_attr_e($gmap->width()) ?>"/>
                    </div>
                    <div class="<?php echo $this->plugin_name ?>-inline">
                        <label for="<?php echo $this->plugin_name ?>-gmap-height"><?php _e( 'Map Height (only in px)', $this->plugin_name ) ?></label>
                        <input type="text" name="<?php echo $this->plugin_name ?>-gmap-height" value="<?php esc_attr_e($gmap->height()) ?>"/>
                    </div><br>
                    <div class="<?php echo $this->plugin_name ?>-inline <?php echo $this->plugin_name; ?>-small">
                        <label for="<?php echo $this->plugin_name ?>-gmap-latitude"><?php _e( 'Center Latitude', $this->plugin_name ) ?></label>
                        <input id="<?php echo alphanumeric_string($gmap->name()) ?>-latitude" type="number" step="0.000001" name="<?php echo $this->plugin_name ?>-gmap-latitude" value="<?php esc_attr_e($gmap->latitude()) ?>"/>
                    </div>
                    <div class="<?php echo $this->plugin_name ?>-inline <?php echo $this->plugin_name ?>-small">
                        <label for="<?php echo $this->plugin_name ?>-gmap-longitude"><?php _e( 'Center Longitude', $this->plugin_name ) ?></label>
                        <input id="<?php echo alphanumeric_string($gmap->name()) ?>-longitude" type="number" step="0.000001" name="<?php echo $this->plugin_name ?>-gmap-longitude" value="<?php esc_attr_e($gmap->longitude()) ?>"/>
                    </div>
                    <div class="<?php echo $this->plugin_name ?>-inline <?php echo $this->plugin_name ?>-small">
                        <label for="<?php echo $this->plugin_name ?>-gmap-zoom"><?php _e( 'Default zoom', $this->plugin_name ) ?></label>
                        <input type="number" step="1" name="<?php echo $this->plugin_name; ?>-gmap-zoom" value="<?php esc_attr_e($gmap->zoom()) ?>"/>
                    </div>
                    <div><strong><?php _e('Click on the Map to prefill latitude and longitude', $this->plugin_name) ?></strong></div><br>
                    <div class="<?php echo $this->plugin_name ?>-inline">
                        <label for="<?php echo $this->plugin_name ?>-gmap-type_menu"><?php _e( 'Add map type control menu', $this->plugin_name ) ?></label>
                        <select name="<?php echo $this->plugin_name ?>-gmap-type_menu">
                            <?php
                            $cats = array(
                                __( 'Yes', $this->plugin_name )=>1,
                                __( 'No', $this->plugin_name )=>0
                            );
                            foreach($cats as $text => $value)
                            {
                                $selected = ($value == $gmap->type_menu()) ? ' selected="selected"' : '';
                                echo '<option value="'.esc_attr($value).'"'.$selected.'>'.esc_html($text).'</option>';
                            }
                            ?>
                        </select>
                        <select name="<?php echo $this->plugin_name ?>-gmap-type_menu_position">
                            <?php
                            $cats = array(
                                __( 'Top right corner', $this->plugin_name )=>'TOP_RIGHT',
                                __( 'Top left corner', $this->plugin_name )=>'TOP_LEFT',
                                __( 'Bottom right corner', $this->plugin_name )=>'RIGHT_BOTTOM',
                                __( 'Bottom left corner', $this->plugin_name )=>'LEFT_BOTTOM',
                                __( 'Centered on the right', $this->plugin_name )=>'RIGHT_CENTER',
                                __( 'Centered on the left', $this->plugin_name )=>'LEFT_CENTER'
                            );
                            foreach($cats as $text => $value)
                            {
                                $selected = ($value == $gmap->type_menu_position()) ? ' selected="selected"' : '';
                                echo '<option value="'.esc_attr($value).'"'.$selected.'>'.esc_html($text).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="<?php echo $this->plugin_name ?>-inline">
                        <label for="<?php echo $this->plugin_name ?>-gmap-zoom_button"><?php _e( 'Add a button to zoom', $this->plugin_name ) ?></label>
                        <select name="<?php echo $this->plugin_name ?>-gmap-zoom_button">
                            <?php
                            $cats = array(
                                __( 'Yes', $this->plugin_name )=>1,
                                __( 'No', $this->plugin_name )=>0
                            );
                            foreach($cats as $text => $value)
                            {
                                $selected = ($value == $gmap->zoom_button()) ? ' selected="selected"' : '';
                                echo '<option value="'.esc_attr($value).'"'.$selected.'>'.esc_html($text).'</option>';
                            }
                            ?>
                        </select>
                        <select name="<?php echo $this->plugin_name ?>-gmap-zoom_button_position">
                            <?php
                            $cats = array(
                                __( 'Top right corner', $this->plugin_name )=>'TOP_RIGHT',
                                __( 'Top left corner', $this->plugin_name )=>'TOP_LEFT',
                                __( 'Bottom right corner', $this->plugin_name )=>'RIGHT_BOTTOM',
                                __( 'Bottom left corner', $this->plugin_name )=>'LEFT_BOTTOM',
                                __( 'Centered on the right', $this->plugin_name )=>'RIGHT_CENTER',
                                __( 'Centered on the left', $this->plugin_name )=>'LEFT_CENTER'
                            );
                            foreach($cats as $text => $value)
                            {
                                $selected = ($value == $gmap->zoom_button_position()) ? ' selected="selected"' : '';
                                echo '<option value="'.esc_attr($value).'"'.$selected.'>'.esc_html($text).'</option>';
                            }
                            ?>
                        </select>
                    </div><br><hr>
                    <div class="<?php echo $this->plugin_name ?>-inline">
                        <label for="<?php echo $this->plugin_name ?>-gmap-category"><?php _e( 'You can filter markers per category', $this->plugin_name ) ?></label>
                        <select name="<?php echo $this->plugin_name; ?>-gmap-category" id="<?php echo $this->plugin_name ?>-gmap-category">
                            <?php
                            $selected = ('' == $gmap->category()) ? ' selected="selected"' : '';
                            echo '<option value=""'.$selected.'></option>';
                            foreach($categories as $category)
                            {
                                $selected = ($category->term_id == $gmap->category()) ? ' selected="selected"' : '';
                                echo '<option value="'.esc_attr($category->term_id).'"'.$selected.'>'.esc_html($category->name).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="<?php echo $this->plugin_name ?>-inline">
                        <label for="<?php echo $this->plugin_name ?>-gmap-tag"><?php _e( 'or tag', $this->plugin_name ) ?></label>
                        <select name="<?php echo $this->plugin_name ?>-gmap-tag" id="<?php echo $this->plugin_name ?>-gmap-tag">
                            <?php
                            $selected = ('' == $gmap->tag()) ? ' selected="selected"' : '';
                            echo '<option value=""'.$selected.'></option>';
                            foreach($tags as $tag)
                            {
                                $selected = ($tag->term_id == $gmap->tag()) ? ' selected="selected"' : '';
                                echo '<option value="'.esc_attr($tag->term_id).'"'.$selected.'>'.esc_html($tag->name).'</option>';
                            }
                            ?>
                        </select>
                    </div><br><hr>
                    <!--<label for="<?php /*echo $this->plugin_name */?>-gmap-infobox_style"><?php /*_e( 'Apply the same infobox style to all markers of this map ?', $this->plugin_name ) */?></label>
                    <select name="<?php /*echo $this->plugin_name */?>-gmap-infobox_style" id="<?php /*echo $this->plugin_name */?>-gmap-infobox_style">
                        <?php
/*                        $selected = ('no' == $gmap->infobox_style()) ? ' selected="selected"' : '';
                        echo '<option value="no"'.$selected.'>No</option>';
                        foreach($infobox_style_list as $infobox_style)
                        {
                            $selected = ($infobox_style->slug() == $gmap->infobox_style()) ? ' selected="selected"' : '';
                            echo '<option value="'.esc_attr($infobox_style->slug()).'"'.$selected.'>'.esc_html($infobox_style->name()).'</option>';
                        }
                        */?>
                    </select>
                    <br><hr>-->
                    <label for="<?php echo $this->plugin_name ?>-gmap-style"><?php _e('You can easily create your own style with <a href="https://snazzymaps.com/" target="_blank">Snazzy Maps</a> or <a href="https://mapstyle.withgoogle.com/" target="_blank">google mapstyle</a> and paste the code here', $this->plugin_name) ?></label><br>
                    <textarea name="<?php echo $this->plugin_name ?>-gmap-style" /><?php echo esc_textarea( $gmap->style() )?></textarea>
                </div>
                <div class="<?php echo $this->plugin_name ?>-gmap-right">
                    <p><strong>Map Preview</strong></p>
                    <div id="<?php esc_attr_e(alphanumeric_string($gmap->name())) ?>" class="<?php echo $this->plugin_name ?>-gmap-menu-map"></div>
                </div>
            </fieldset>
            <fieldset>
                <legend><?php _e('Pin Clustering', $this->plugin_name) ?>:</legend>
                <label for="<?php echo $this->plugin_name ?>-gmap-pin_clustering"><?php _e('Do you want to turn on the pin clustering ?', $this->plugin_name) ?></label>
                <?php if ( $gmap->pin_clustering() == 1 ) { ?>
                    <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-pin_clustering" value="1" checked> <?php _e( 'Yes', $this->plugin_name ) ?>
                    <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-pin_clustering" value="0"> <?php _e( 'No', $this->plugin_name ) ?><br>
                <?php } ?>
                <?php if ( $gmap->pin_clustering() == 0 ) { ?>
                    <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-pin_clustering" value="1"> <?php _e( 'Yes', $this->plugin_name ) ?>
                    <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-pin_clustering" value="0" checked> <?php _e( 'No', $this->plugin_name ) ?><br>
                <?php } ?>
                <div class="<?php echo $this->plugin_name ?>-inline">
                    <label for="<?php echo $this->plugin_name ?>-gmap-clustering_grid_size"><?php _e('Grid size for the pin clustering', $this->plugin_name) ?></label>
                    <input type="number" name="<?php echo $this->plugin_name ?>-gmap-clustering_grid_size" value="<?php esc_attr_e( $gmap->clustering_grid_size()) ?>" />
                </div>
                <div class="<?php echo $this->plugin_name ?>-inline">
                    <label for="<?php echo $this->plugin_name ?>-gmap-clustering_text_color"><?php _e('Color of the text in pin clustering', $this->plugin_name) ?></label>
                    <input class="<?php echo $this->plugin_name ?>-color-field" name="<?php echo $this->plugin_name ?>-gmap-clustering_text_color" value="<?php esc_attr_e( $gmap->clustering_text_color()) ?>">
                </div>
                <div class="<?php echo $this->plugin_name ?>-fieldset-line">
                    <fieldset class="nested">
                        <legend><?php _e('Small amount of pins clustered', $this->plugin_name) ?></legend>
                        <span id="<?php echo $this->plugin_name ?>-gmap-marker-logo-id-small" class="button"><?php _e('Select Marker', $this->plugin_name) ?></span>
                        <img src="<?php esc_attr_e($cluster_marker_small->url()) ?>" width="<?php esc_attr_e($cluster_marker_small->width()) ?>" height="<?php esc_attr_e($cluster_marker_small->height()) ?>">
                        <input type="hidden" name="<?php echo $this->plugin_name ?>-gmap-clustering_marker_logo_id_small" value="<?php esc_attr_e( $gmap->clustering_marker_logo_id_small() )?>">
                        <label for="<?php echo $this->plugin_name ?>-gmap-clustering_text_size_small"><?php _e('Text size (small)', $this->plugin_name) ?></label>
                        <input type="number" name="<?php echo $this->plugin_name ?>-gmap-clustering_text_size_small" value="<?php esc_attr_e( $gmap->clustering_text_size_small() )?>">
                        <div class="<?php echo $this->plugin_name ?>-inline <?php echo $this->plugin_name ?>-small">
                            <label for="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_x_small"><?php _e('Align x', $this->plugin_name) ?></label>
                            <input type="number" name="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_x_small" value="<?php esc_attr_e( $gmap->clustering_text_align_x_small() )?>">
                        </div>
                        <div class="<?php echo $this->plugin_name ?>-inline <?php echo $this->plugin_name; ?>-small">
                            <label for="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_y_small"><?php _e('Align y', $this->plugin_name) ?></label>
                            <input type="number" name="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_y_small" value="<?php esc_attr_e( $gmap->clustering_text_align_y_small() )?>">
                        </div>
                    </fieldset>
                    <fieldset class="nested">
                        <legend><?php _e('Medium amount of pins clustered', $this->plugin_name) ?></legend>
                        <span id="<?php echo $this->plugin_name ?>-gmap-marker-logo-id-medium" class="button"><?php _e('Select Marker', $this->plugin_name) ?></span>
                        <img src="<?php esc_attr_e($cluster_marker_medium->url()) ?>" width="<?php esc_attr_e($cluster_marker_medium->width()) ?>" height="<?php esc_attr_e($cluster_marker_medium->height()) ?>">
                        <input type="hidden" name="<?php echo $this->plugin_name ?>-gmap-clustering_marker_logo_id_medium" value="<?php esc_attr_e( $gmap->clustering_marker_logo_id_medium() )?>">
                        <label for="<?php echo $this->plugin_name ?>-gmap-clustering_text_size_medium"><?php _e('Text size (medium)', $this->plugin_name) ?></label>
                        <input type="number" name="<?php echo $this->plugin_name ?>-gmap-clustering_text_size_medium" value="<?php esc_attr_e( $gmap->clustering_text_size_medium() )?>">
                        <div class="<?php echo $this->plugin_name ?>-inline <?php echo $this->plugin_name; ?>-small">
                            <label for="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_x_medium"><?php _e('Align x', $this->plugin_name) ?></label>
                            <input type="number" name="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_x_medium" value="<?php esc_attr_e( $gmap->clustering_text_align_x_medium() )?>">
                        </div>
                        <div class="<?php echo $this->plugin_name ?>-inline <?php echo $this->plugin_name; ?>-small">
                            <label for="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_y_medium"><?php _e('Align y', $this->plugin_name) ?></label>
                            <input type="number" name="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_y_medium" value="<?php esc_attr_e( $gmap->clustering_text_align_y_medium() )?>">
                        </div>
                    </fieldset>
                    <fieldset class="nested">
                        <legend><?php _e('Big amount of pins clustered', $this->plugin_name) ?></legend>
                        <span id="<?php echo $this->plugin_name ?>-gmap-marker-logo-id-big" class="button"><?php _e('Select Marker', $this->plugin_name) ?></span>
                        <img src="<?php esc_attr_e($cluster_marker_big->url()) ?>" width="<?php esc_attr_e($cluster_marker_big->width()) ?>" height="<?php esc_attr_e($cluster_marker_big->height()) ?>">
                        <input type="hidden" name="<?php echo $this->plugin_name ?>-gmap-clustering_marker_logo_id_big" value="<?php esc_attr_e( $gmap->clustering_marker_logo_id_big() )?>">
                        <label for="<?php echo $this->plugin_name ?>-gmap-clustering_text_size_big"><?php _e('Text size (big)', $this->plugin_name) ?></label>
                        <input type="number" name="<?php echo $this->plugin_name ?>-gmap-clustering_text_size_big" value="<?php esc_attr_e( $gmap->clustering_text_size_big() )?>">
                        <div class="<?php echo $this->plugin_name ?>-inline <?php echo $this->plugin_name ?>-small">
                            <label for="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_x_big"><?php _e('Align x', $this->plugin_name) ?></label>
                            <input type="number" name="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_x_big" value="<?php esc_attr_e( $gmap->clustering_text_align_x_big() )?>">
                        </div>
                        <div class="<?php echo $this->plugin_name ?>-inline <?php echo $this->plugin_name ?>-small">
                            <label for="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_y_big"><?php _e('Align y', $this->plugin_name) ?></label>
                            <input type="number" name="<?php echo $this->plugin_name ?>-gmap-clustering_text_align_y_big" value="<?php esc_attr_e( $gmap->clustering_text_align_y_big() )?>">
                        </div>
                    </fieldset>
                </div>
            </fieldset>
            <fieldset>
                <legend><?php _e('Additional Marker', $this->plugin_name) ?>:</legend>
                <div class="<?php echo $this->plugin_name ?>-gmap-left">
                    <label for="<?php echo $this->plugin_name; ?>-gmap-additional_marker"><?php _e('Do you want to add an additional marker (to indicate your current position or whatever you like)', $this->plugin_name ) ?></label>
                    <?php if ( $gmap->additional_marker() == 1 ) { ?>
                        <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-additional_marker" value="1" checked> <?php _e( 'Yes', $this->plugin_name ) ?>
                        <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-additional_marker" value="0"> <?php _e( 'No', $this->plugin_name ) ?><br>
                    <?php } ?>
                    <?php if ( $gmap->additional_marker() == 0 ) { ?>
                        <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-additional_marker" value="1"> <?php _e( 'Yes', $this->plugin_name ) ?>
                        <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-additional_marker" value="0" checked> <?php _e( 'No', $this->plugin_name ) ?><br>
                    <?php } ?>
                    <div class="<?php echo $this->plugin_name ?>-inline">
                        <label for="<?php echo $this->plugin_name ?>-gmap-additional_marker_title"><?php _e('Additional marker Title', $this->plugin_name); ?></label>
                        <input type="text" name="<?php echo $this->plugin_name ?>-gmap-additional_marker_title" value="<?php esc_attr_e( $gmap->additional_marker_title() )?>" />
                    </div>
                    <div class="<?php echo $this->plugin_name ?>-inline" id="<?php echo $this->plugin_name ?>-gmap-additional-marker-logo">
                        <label for="<?php echo $this->plugin_name ?>-gmap-additional_marker_logo_id"><?php _e('Additional marker Image', $this->plugin_name); ?></label>
                        <span id="<?php echo $this->plugin_name ?>-gmap-additional-marker-logo-id" class="button"><?php _e('Select Marker', $this->plugin_name) ?></span>
                        <img src="<?php esc_attr_e($additional_marker->url()) ?>" width="<?php esc_attr_e( $additional_marker->width()) ?>" height="<?php esc_attr_e($additional_marker->height()) ?>">
                        <input type="hidden" name="<?php echo $this->plugin_name ?>-gmap-additional_marker_logo_id" value="<?php esc_attr_e( $gmap->additional_marker_logo_id() )?>">
                    </div><br>
                    <div class="<?php echo $this->plugin_name ?>-inline">
                        <label for="<?php echo $this->plugin_name ?>-gmap-additional_marker_latitude"><?php _e('Additional marker Latitude', $this->plugin_name); ?></label>
                        <input id="<?php esc_attr_e(alphanumeric_string($gmap_small_map->name())) ?>-latitude" type="number" step="0.000001" name="<?php echo $this->plugin_name ?>-gmap-additional_marker_latitude" value="<?php esc_attr_e( $gmap->additional_marker_latitude() )?>" />
                    </div>
                    <div class="<?php echo $this->plugin_name ?>-inline">
                        <label for="<?php echo $this->plugin_name ?>-gmap-additional_marker_longitude"><?php _e('Additional marker Longitude', $this->plugin_name); ?></label>
                        <input id="<?php esc_attr_e(alphanumeric_string($gmap_small_map->name())) ?>-longitude" type="number" step="0.000001" name="<?php echo $this->plugin_name ?>-gmap-additional_marker_longitude" value="<?php esc_attr_e( $gmap->additional_marker_longitude() )?>" />
                    </div>
                    <div><strong><?php _e('Click on the Map to prefill latitude and longitude', $this->plugin_name) ?></strong></div>
                </div>
                <div class="<?php echo $this->plugin_name ?>-gmap-right">
                    <div id="<?php esc_attr_e(alphanumeric_string($gmap_small_map->name())) ?>" class="<?php echo $this->plugin_name ?>-gmap-menu-map-small"></div>
                </div>
            </fieldset>
            <fieldset>
                <legend><?php _e('Additional Options', $this->plugin_name) ?>:</legend>
                <label for="<?php echo $this->plugin_name ?>-gmap-load_scripts"><?php _e( 'Load the map scripts automatically (set it to "No" only if you know what you are doing!!!)', $this->plugin_name ); ?></label>
                <?php if ( $gmap->load_scripts() == 1 ) { ?>
                    <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-load_scripts" value="1" checked> <?php _e( 'Yes', $this->plugin_name ) ?>
                    <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-load_scripts" value="0"> <?php _e( 'No', $this->plugin_name ) ?><br>
                <?php } ?>
                <?php if ( $gmap->load_scripts() == 0 ) { ?>
                    <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-load_scripts" value="1"> <?php _e( 'Yes', $this->plugin_name ) ?>
                    <input type="radio" name="<?php echo $this->plugin_name ?>-gmap-load_scripts" value="0" checked> <?php _e( 'No', $this->plugin_name ) ?><br>
                <?php } ?>
            </fieldset>
            <?php
            $gmap_id = $gmap->id();
            if (! empty($gmap_id)) {?>
            <fieldset>
                <legend><?php _e('Shortcode for this map', $this->plugin_name) ?>:</legend>
                <p><?php _e('You can use this shortcode to display this map wherever you like', $this->plugin_name) ?></p>
                <code>[novo-map id=<?php esc_html_e($gmap->id()) ?>]</code>
            </fieldset>
            <?php } ?>
            <hr>
            <?php
            if (isset($get_id)) {
                echo '<input class="button-primary" type="submit" name="'.$this->plugin_name.'-gmap-update" value="'. __( 'Update Map', $this->plugin_name  ).'" />';
                echo '<input class="button-primary" type="submit" name="'.$this->plugin_name.'-gmap-delete" value="'. __( 'Delete Map', $this->plugin_name  ).'" />';
            }
            else {
                echo '<input class="button-primary" type="submit" name="'.$this->plugin_name.'-gmap-create" value="'. __( 'Create Map', $this->plugin_name  ).'" />';
            }
            ?>
        <?php
        }
        ?>
    </form>
</div>
