<div id="<?php echo $this->plugin_name.'-marker-logo-folder-images' ?>">
    <div class="marker-logo-wrap">
        <span id="<?php echo $this->plugin_name.'-marker-logo-folder-images-close' ?>">
            <img src="<?php echo $this->plugin_dir_url. 'admin/assets/images/close.svg' ?>">
        </span>
        <div>
            <?php
            foreach ($markers_paths as $marker_path) {
                echo '<img src="'.$markers_dir_url.$marker_path.'">';
            }
            ?>
        </div>
    </div>
</div>
<div class="wrap <?php echo $this->plugin_name.'-marker-logo-admin-menu' ?>">
    <h2><?php esc_html_e(get_admin_page_title())?></h2>
    <h3><?php _e('Default Markers', $this->plugin_name) ?></h3>
    <?php
    foreach ($default_marker_logos as $default_marker) {
        echo '<img src="'.esc_attr($default_marker->url()).'" width="'.esc_attr($default_marker->width()).'" height="'.esc_attr($default_marker->height()).'">';
    }
    ?>
    <h3><?php _e('Add you own Markers', $this->plugin_name) ?></h3>
    <form method="post" action="admin.php?page=<?php echo $this->plugin_name ?>-marker-logo">
        <?php wp_nonce_field( $this->plugin_name.'-marker-logo_admin_menu', $this->plugin_name.'-marker-logo_admin_menu_nonce' ) ?>
        <img id="<?php echo $this->plugin_name.'-marker-logo-image' ?>" src="<?php esc_attr_e($marker_logo_url) ?>" />
        <div id="<?php echo $this->plugin_name.'-marker-logo-select-folder' ?>" class="button"><?php _e( 'Choose from list', $this->plugin_name ) ?></div>
        <div id="<?php echo $this->plugin_name.'-marker-logo-media-upload' ?>" class="button"><?php _e( 'Add your own', $this->plugin_name ) ?></div>

        <div class="novo-map-form-grid">
            <label for="<?php echo $this->plugin_name.'-marker-logo-width' ?>"><?php _e( 'width (px)', $this->plugin_name ) ?></label>
            <input id="<?php echo $this->plugin_name.'-marker-logo-width' ?>" type="number" step="1" name="<?php echo $this->plugin_name.'-marker-logo-width' ?>" value="<?php esc_attr_e( $marker_logo->width() )?>" />
        </div>
        <div class="novo-map-form-grid">
            <label for="<?php echo $this->plugin_name.'-marker-logo-height' ?>"><?php _e( 'height (px)', $this->plugin_name ) ?></label>
            <input id="<?php echo $this->plugin_name.'-marker-logo-height' ?>" type="number" step="1" name="<?php echo $this->plugin_name.'-marker-logo-height' ?>" value="<?php esc_attr_e( $marker_logo->height() )?>" />
        </div>
        <div class="novo-map-form-grid">
            <label for="<?php echo $this->plugin_name.'-marker-logo-anchor_x' ?>"><?php _e( 'horizontal align', $this->plugin_name ) ?></label>
            <select name="<?php echo $this->plugin_name; ?>-marker-logo-anchor_x">
                <?php
                $cats = array(
                    __( 'left', $this->plugin_name )=>'left',
                    __( 'middle', $this->plugin_name )=>'middle',
                    __( 'right', $this->plugin_name )=>'right'
                );
                foreach($cats as $text => $value)
                {
                    $selected = ($value == $marker_logo->anchor_x_text()) ? ' selected="selected"' : '';
                    echo '<option value="'.esc_attr($value).'"'.$selected.'>'.esc_html($text).'</option>';
                }
                ?>
            </select>
        </div>
        <div class="novo-map-form-grid">
            <label for="<?php echo $this->plugin_name.'-marker-logo-anchor_y' ?>"><?php _e( 'vertical align', $this->plugin_name ) ?></label>
            <select name="<?php echo $this->plugin_name ?>-marker-logo-anchor_y">
                <?php
                $cats = array(
                    __( 'bottom', $this->plugin_name )=>'bottom',
                    __( 'middle', $this->plugin_name )=>'middle',
                    __( 'top', $this->plugin_name )=>'top'
                );
                foreach($cats as $text => $value)
                {
                    $selected = ($value == $marker_logo->anchor_y_text()) ? ' selected="selected"' : '';
                    echo '<option value="'.esc_attr($value).'"'.$selected.'>'.esc_html($text).'</option>';
                }
                ?>
            </select>
        </div>
        <div id="<?php echo $this->plugin_name.'-marker-logo-add-update' ?>">
            <input type="hidden" id="<?php echo $this->plugin_name.'-marker-logo-id' ?>" name="<?php echo $this->plugin_name.'-marker-logo-id' ?>" value="<?php esc_attr_e($marker_logo->id()) ?>" />
            <input type="hidden" id="<?php echo $this->plugin_name.'-marker-logo-url' ?>" name="<?php echo $this->plugin_name.'-marker-logo-url' ?>" value="<?php esc_attr_e($marker_logo_url) ?>" />
            <input type="hidden" id="<?php echo $this->plugin_name.'-marker-logo-status' ?>" name="<?php echo $this->plugin_name.'-marker-logo-status' ?>" value="user" />
            <?php
            if (isset($_GET['edit'])) {
                echo '<button type="submit" class="button button-primary button-large" name="'.$this->plugin_name.'-marker-logo-update" value="update">'.__( 'Update marker', $this->plugin_name ).'</button>';
                echo '<a type="submit" class="button button-primary button-large" href="admin.php?page='.$this->plugin_name.'-marker-logo">'.__( 'Add new', $this->plugin_name ).'</a>';
            }
            else {
                echo '<button type="submit" class="button button-primary button-large" name="'.$this->plugin_name.'-marker-logo-add" value="add">'.__( 'Add marker', $this->plugin_name ).'</button>';
            }
            ?>
        </div>
    </form>
    <?php
    foreach ($user_marker_logos as $user_marker) { ?>
        <div class="<?php echo $this->plugin_name.'-marker-logo-user' ?>">
            <img src="<?php echo $user_marker->url() ?>" width="<?php esc_attr_e($user_marker->width()) ?>" height="<?php esc_attr_e($user_marker->height()) ?>">
            <div>
                <div><?php _e('w:', $this->plugin_name) ?> <?php  esc_html_e($user_marker->width()) ?> px</div>
                <div><?php _e('h:', $this->plugin_name) ?> <?php esc_html_e($user_marker->height()) ?> px</div>
            </div>
            <div class="<?php echo $this->plugin_name.'-marker-logo-user-edit-delete' ?>">
                <a href="<?php echo add_query_arg(array('edit'=>1, 'id'=>$user_marker->id())) ?>" class="button"><?php esc_html_e('Edit', $this->plugin_name) ?></a>
                <a href="<?php echo add_query_arg(array('delete'=>1, 'id'=>$user_marker->id())) ?>" id="<?php echo $this->plugin_name.'-marker-logo-delete' ?>" class="button"><?php esc_html_e('Delete', $this->plugin_name) ?></a>
            </div>
        </div>
    <?php } ?>
</div>