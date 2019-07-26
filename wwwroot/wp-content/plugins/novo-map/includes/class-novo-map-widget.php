<?php
/**
 * The file that defines the the novo-map widget
 *
 * A class the extends the wp widget class to define the novo-map widget
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 */

class Novo_Map_Widget extends WP_Widget {

    public function __construct() {

        $widget_options = array(
            'classname' => 'Novo_Map_Widget',
            'description' => 'Add your posts on a custom google map',
        );

        parent::__construct(
            'Novo_Map_Widget',
            'Novo-Map',
            $widget_options );
    }

    /**
     * generate the public part of the widget
     *
     * @param array $args
     * @param array $instance
     * @since 1.0.0
     */
    public function widget( $args, $instance ) {
        require_once plugin_dir_path( __FILE__ ) . 'class-novo-map-gmap-manager.php';
        require_once plugin_dir_path( __FILE__ ) . 'class-novo-map-gmap.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/helpers/public-helpers.php';
        global $wpdb;
        $gmap_manager = new Gmap_Manager($wpdb);
        $gmap = $gmap_manager->get($instance['gmap_id']);

        //add random widget suffix to the map for unique name
        $gmap->set_name($gmap->name().generate_random_string());
        //enqueue map script and generate the map
        $gmap->enqueue_map('novo-map');

        echo $args['before_widget'];

        ob_start();
        include(plugin_dir_path(dirname( __FILE__ )) .'public/partials/novo-map-widget.php');
        $widget_html = ob_get_contents();
        ob_end_clean();
        echo $widget_html;

        echo $args['after_widget'];

    }

    /**
     * Generate the admin part of the menu
     *
     * @param array $instance
     * @since 1.0.0
     */
    public function form( $instance ) {
        require_once plugin_dir_path( __FILE__ ) . 'class-novo-map-gmap-manager.php';
        require_once plugin_dir_path( __FILE__ ) . 'class-novo-map-gmap.php';
        global $wpdb;
        $gmap_manager = new Gmap_Manager($wpdb);

        $gmap_list = $gmap_manager->get_list();
        $gmap_id = isset( $instance['gmap_id'] ) ? $instance['gmap_id'] : '';

        ob_start();
        include(plugin_dir_path(dirname( __FILE__ )) .'admin/partials/novo-map-widget.php');
        $widget_admin_html = ob_get_contents();
        ob_end_clean();
        echo $widget_admin_html;
    }
}