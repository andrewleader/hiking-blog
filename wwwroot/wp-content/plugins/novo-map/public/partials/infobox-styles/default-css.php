<style>
    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> {
        width: <?php echo $this->width() ?>px;
        height: <?php echo $this->height() ?>px;
        background-color: <?php echo $this->background_color() ?>;
        max-width: 90%;
        overflow-y: auto;
    }

    /*close button*/
    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> img:first-child {
        float: left;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .title {
        display: block;
        width: 100%;
        font-size: 20px;
        font-weight: 700;
        text-align: center;
        color: <?php echo $this->title_color() ?>;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> a:hover {
        color: <?php echo $this->title_color() ?>;
        text-decoration: underline;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .infobox-content img {
        float: right;
        margin-left:12px;
        margin-bottom: 6px;
        width: 120px;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .description {
        color: <?php echo $this->text_color() ?>;
        font-size: 13px;
        padding-left: 6px;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .description a {
        color: <?php echo $this->text_color() ?>;
        font-weight: bold;
    }

    #<?php echo $gmap_name ?> .<?php echo $this->slug() ?> .description a:hover {
        text-decoration: underline;
    }

</style>