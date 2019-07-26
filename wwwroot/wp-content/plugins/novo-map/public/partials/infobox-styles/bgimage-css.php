<style>
    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> {
        width: <?php echo $this->width() ?>px;
        height: <?php echo $this->height() ?>px;
        max-width: 90%;
        overflow-y: auto;
    }

    /*close button*/
    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> img:first-child {
        float: right;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .infobox-content-wrap {
        height: <?php echo $this->height() ?>px;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .infobox-content-wrap img:first-child {
        position: absolute;
        z-index: -1;
        top: 0;
        left: 0;
        width: 100%;
        height:100%;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .infobox-content {
        width: 100%;
        min-height: 100%;
        background-color: <?php echo $this->background_color() ?>;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .title {
        display: block;
        width: 100%;
        font-size: 20px;
        font-weight: 700;
        text-align: center;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .description {
        color: <?php echo $this->text_color() ?>;
        display: block;
        width: 100%;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .description a {
        color: <?php echo $this->text_color() ?>;
        font-weight: bold;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .description a:hover {
        text-decoration: underline;
    }

</style>