<p>
    <label for="<?php echo $this->get_field_name( 'gmap_id' ) ?>"><?php _e( 'Choose a map', 'novo-map' ) ?></label>
    <select class="widefat" name="<?php echo $this->get_field_name( 'gmap_id' ) ?>">
        <?php
        $selected = ('' == $gmap_id) ? ' selected="selected"' : '';
        echo '<option value=""'.$selected.'></option>';
        foreach($gmap_list as $map)
        {
            $selected = ($map->id() == $gmap_id) ? ' selected="selected"' : '';
            echo '<option value="'.esc_attr($map->id()).'"'.$selected.'>'.esc_html($map->name()).'</option>';
        }
        ?>
    </select>
</p>