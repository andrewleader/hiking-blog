'<div class="infobox-content">
    <a href="<?php echo get_permalink($marker->post_id()) ?>">
        <div class="title">
            <?php esc_attr_e($marker->title()) ?>
        </div>
    </a>
    <?php if($marker->infobox_image() != -1 and $marker->infobox_image() != 0) { ?>
        <img src="<?php
        $wp_attachment_image_src = wp_get_attachment_image_src($marker->infobox_image());
        echo $wp_attachment_image_src[0] ?>">
    <?php } ?>
    <div class="description">
        <?php echo addslashes($marker->infobox_description()) ?>
    </div>
</div>'