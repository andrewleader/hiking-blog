'<div class="infobox-content-wrap">
    <?php if($marker->infobox_image() != -1) { ?>
        <?php echo wp_get_attachment_image($marker->infobox_image(), 'medium') ?>
    <?php } ?>
    <div class="infobox-content">
        <a href="<?php echo get_permalink($marker->post_id()) ?>">
            <div class="title">
                <?php esc_attr_e($marker->title()) ?>
            </div>
        </a>
        <div class="description">
            <?php echo addslashes($marker->infobox_description()) ?>
        </div>
    </div>
</div>'