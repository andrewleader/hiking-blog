<?php
if ($show_post_admin_menu == false) {
    echo '<div id="'.$this->plugin_name.'-post-unpublished-notice"><strong>'. __( 'The Post must be published to add a Marker', $this->plugin_name ).'</strong></div>';
}
?>
<div id="<?php echo $this->plugin_name.'-post-admin-menu-wrap' ?>" <?php if ($show_post_admin_menu == false) {echo 'style="display: none;"';} ?>>
    <div id="<?php echo $this->plugin_name.'-marker-marker-logo-folder-images' ?>">
        <div class="marker-marker-logo-wrap">
            <span id="<?php echo $this->plugin_name.'-marker-marker-logo-folder-images-close' ?>">
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

    <?php wp_nonce_field( $this->plugin_name.'-post_admin_menu', $this->plugin_name.'-post_admin_menu_nonce' ); ?>
    <div>
        <div class="<?php echo $this->plugin_name.'-post-inline' ?>" id="<?php echo $this->plugin_name.'-post-left' ?>">
            <div class="<?php echo $this->plugin_name.'-inline' ?>" id="<?php echo $this->plugin_name.'-post-marker-title' ?>">
                <label for="<?php echo $this->plugin_name.'-marker-title' ?>"><?php _e( 'Title of the Marker', $this->plugin_name )?></label>
                <input type="text" name="<?php echo $this->plugin_name.'-marker-title' ?>" value="<?php esc_attr_e($marker_title)?>" />
                <br><hr>
                <label for="<?php echo $this->plugin_name ?>-marker-marker_logo_id"><?php _e( 'Select a Marker image', $this->plugin_name ) ?></label>
                <span id="<?php echo $this->plugin_name ?>-marker-marker-logo-id" class="button"><?php esc_html_e('Select', $this->plugin_name) ?></span>
                <img id="<?php echo $this->plugin_name ?>-marker-marker-logo-id-image" src="<?php esc_attr_e( $marker_logo->url() )?>" width="<?php esc_attr_e( $marker_logo->width() )?>" height="<?php esc_attr_e( $marker_logo->height() )?>">
                <input type="hidden" id="<?php echo $this->plugin_name ?>-marker-marker-logo-id-input" name="<?php echo $this->plugin_name ?>-marker-marker_logo_id" value="<?php esc_attr_e( $marker->marker_logo_id() )?>">
            </div>
            <div class="<?php echo $this->plugin_name.'-inline' ?>" id="<?php echo $this->plugin_name.'-post-latlng' ?>">
                <label for="<?php echo $this->plugin_name.'-marker-latitude' ?>"><?php _e( 'Latitude', $this->plugin_name ) ?></label>
                <input id="postmenumap-latitude" type="number" step="0.000001" name="<?php echo $this->plugin_name.'-marker-latitude' ?>" value="<?php esc_attr_e( $marker->latitude() )?>" />
                <label for="<?php echo $this->plugin_name.'-marker-longitude' ?>"><?php _e( 'Longitude', $this->plugin_name ) ?></label>
                <input id="postmenumap-longitude" type="number" step="0.000001" name="<?php echo $this->plugin_name.'-marker-longitude' ?>" value="<?php esc_attr_e( $marker->longitude() )?>" />
                <div><strong><?php esc_html_e('Click on the map to prefill', $this->plugin_name) ?></strong></div>
            </div>
        </div>
        <div class="<?php echo $this->plugin_name.'-post-inline' ?>" id="<?php echo $this->plugin_name.'-post-right' ?>">
            <div id="<?php esc_attr_e(alphanumeric_string($gmap->name())) ?>"></div>
        </div>
    </div>
    <hr>
    <div>
        <div class="<?php echo $this->plugin_name.'-marker-upload-infobox-image' ?>">
            <label for="<?php echo $this->plugin_name ?>-marker-infobox_image"><?php _e( 'Add an image in the Infobox', $this->plugin_name ) ?></label>
            <img data-src="<?php echo $default_upload_image_src ?>" src="<?php echo $upload_image_src ?>" />
            <input type="hidden" name="<?php echo $this->plugin_name.'-marker-infobox_image' ?>" value="<?php esc_attr_e( $marker->infobox_image() ) ?>" />
            <div>
                <div id="<?php echo $this->plugin_name.'-marker-upload-infobox-image' ?>" class="button"><?php _e( 'Upload', $this->plugin_name ) ?></div>
                <div id="<?php echo $this->plugin_name.'-marker-remove-infobox-image' ?>" class="button"><?php _e( 'Remove', $this->plugin_name ) ?></div>
            </div>
        </div>
        <div id="<?php echo $this->plugin_name.'-post-marker-textarea' ?>">
            <label for="<?php echo $this->plugin_name.'-marker-infobox_description' ?>"><?php _e( 'Text description of the Infobox', $this->plugin_name ) ?></label>
            <?php wp_editor( $infobox_description, 'novomap_marker_infobox_description', $texteditor_settings ); ?>
        </div>
        <input type="hidden" name="<?php echo $this->plugin_name.'-marker-id' ?>" value="<?php esc_attr_e($marker->id()) ?>" />
        <input type="hidden" name="<?php echo $this->plugin_name.'-marker-post_id' ?>" value="<?php esc_attr_e(get_the_ID()) ?>" />
    </div>
    <hr>
    <div id="<?php echo $this->plugin_name.'-marker-add-delete' ?>">
        <?php
        if (empty($marker_list)) {
            echo '<div class="button button-primary button-large" id="'.$this->plugin_name.'-marker-add">'. __( 'Add marker', $this->plugin_name ).'</div>';
        }
        else {
            echo '<input type="hidden" class="button button-primary button-large" name="'.$this->plugin_name.'-marker-update" value="update">';
            echo '<div class="button button-primary button-large" id="'.$this->plugin_name.'-marker-delete">'. __( 'Delete marker', $this->plugin_name ).'</div>';
        }
        ?>
    </div>
</div>