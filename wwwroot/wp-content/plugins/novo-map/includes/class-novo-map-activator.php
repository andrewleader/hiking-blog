<?php

/**
 * Fired during plugin activation
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 * @author     novo-media <contact@novo-media.ch>
 */
class Novo_Map_Activator {

	/**
	 * fuction that runs on plugin activation
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

	    self::create_gmap_db();
        self::create_marker_db();
        self::create_marker_logo_db();
        self::prefill_marker_logo_db();
        self::create_infobox_styles();
	}

    /**
     * create the gmap table for the gmap class
     *
     * @since    1.0.0
     */
	public static function create_gmap_db() {
        require_once plugin_dir_path( __FILE__ ) . 'class-novo-map-gmap-manager.php';
        global $wpdb;
        $gmap_manager = new Gmap_Manager($wpdb);
        $gmap_manager->create();
    }

    /**
     * create the marker table for the marker class
     *
     * @since    1.0.0
     */
    public static function create_marker_db() {
        require_once plugin_dir_path( __FILE__ ) . 'class-novo-map-marker-manager.php';
        global $wpdb;
        $marker_manager = new Marker_Manager($wpdb);
        $marker_manager->create();
    }


    /**
     * create the marker logo table for the marker logo class
     *
     * @since    1.0.0
     */
    public static function create_marker_logo_db() {
        require_once plugin_dir_path( __FILE__ ) . 'class-novo-map-marker-logo-manager.php';
        global $wpdb;
        $marker_logo_manager = new Marker_Logo_Manager($wpdb);
        $marker_logo_manager->create();
    }

    /**
     * prefill the Marker Logo database with the 5 default marker logos
     *
     * @since    1.0.0
     */
    public static function prefill_marker_logo_db() {
        require_once plugin_dir_path( __FILE__ ) . 'class-novo-map-marker-logo.php';
        require_once plugin_dir_path( __FILE__ ) . 'class-novo-map-marker-logo-manager.php';
        global $wpdb;
        $manager = new Marker_Logo_Manager($wpdb);

        $marker_logo_1 = array(
            'url'=>plugin_dir_url(dirname( __FILE__ )) .'public/assets/images/markers/icn-map-here.svg',
            'width'=>40,
            'height'=>40,
            'anchor_x'=>'middle',
            'anchor_y'=>'middle',
            'status'=>'default',
        );

        $marker_logo_2 = array(
            'url'=>plugin_dir_url(dirname( __FILE__ )) .'public/assets/images/markers/icn-map-green.svg',
            'width'=>45,
            'height'=>45,
            'anchor_x'=>'middle',
            'anchor_y'=>'bottom',
            'status'=>'default',
        );

        $marker_logo_3 = array(
            'url'=>plugin_dir_url(dirname( __FILE__ )) .'public/assets/images/markers/icn-map-cluster-small.svg',
            'width'=>40,
            'height'=>40,
            'anchor_x'=>'middle',
            'anchor_y'=>'bottom',
            'status'=>'default',
        );

        $marker_logo_4 = array(
            'url'=>plugin_dir_url(dirname( __FILE__ )) .'public/assets/images/markers/icn-map-cluster-medium.svg',
            'width'=>45,
            'height'=>45,
            'anchor_x'=>'middle',
            'anchor_y'=>'bottom',
            'status'=>'default',
        );

        $marker_logo_5 = array(
            'url'=>plugin_dir_url(dirname( __FILE__ )) .'public/assets/images/markers/icn-map-cluster-big.svg',
            'width'=>50,
            'height'=>50,
            'anchor_x'=>'middle',
            'anchor_y'=>'bottom',
            'status'=>'default',
        );

        $marker_logo_6 = array(
            'url'=>plugin_dir_url(dirname( __FILE__ )) .'public/assets/images/markers/icn-map-style1-08.svg',
            'width'=>45,
            'height'=>45,
            'anchor_x'=>'middle',
            'anchor_y'=>'bottom',
            'status'=>'default',
        );

        $marker_logo_7 = array(
            'url'=>plugin_dir_url(dirname( __FILE__ )) .'public/assets/images/markers/icn-map-style2-06.svg',
            'width'=>45,
            'height'=>45,
            'anchor_x'=>'middle',
            'anchor_y'=>'bottom',
            'status'=>'default',
        );

        $marker_logo_8 = array(
            'url'=>plugin_dir_url(dirname( __FILE__ )) .'public/assets/images/markers/icn-map-style1-07.svg',
            'width'=>45,
            'height'=>45,
            'anchor_x'=>'middle',
            'anchor_y'=>'bottom',
            'status'=>'default',
        );

        $marker_logo_9 = array(
            'url'=>plugin_dir_url(dirname( __FILE__ )) .'public/assets/images/markers/icn-map-style1-01.svg',
            'width'=>45,
            'height'=>45,
            'anchor_x'=>'middle',
            'anchor_y'=>'bottom',
            'status'=>'default',
        );

        $default_marker_logos = array(
            $marker_logo_1,
            $marker_logo_2,
            $marker_logo_3,
            $marker_logo_4,
            $marker_logo_5,
            $marker_logo_6,
            $marker_logo_7,
            $marker_logo_8,
            $marker_logo_9
        );

        // if table is empty, prefill with default values
        $marker_logo_list = $manager->get_list();
        if (empty($marker_logo_list)) {
            foreach ($default_marker_logos as $marker_logo) {
                $marker_logo = new Marker_Logo($marker_logo);
                $manager->add($marker_logo);
            }
        }
    }

    /**
     * save infobox styles in WP_OPTION table
     *
     * @since    1.0.0
     */
    public static function create_infobox_styles() {
        $infobox_styles = array(
            'Default' => array(
                'name' => 'Default style',
                'slug' => 'novo-map_infobox_style_default',
                'css_template' => 'default-css.php',
                'html_template' => 'default-html.php',
                'width' => '320',
                'height' => '210',
                'popup_position_x' => '-160',
                'popup_position_y' => '-105',
                'background_color' => 'rgba(0,0,0,0.7)',
                'title_color' => '#ffffff',
                'text_color' => '#ffffff'
        )/*,
            'Bgimage' => [
                'name' => 'Background image',
                'slug' => 'novo-map_infobox_style_bgimage',
                'css_template' => 'bgimage-css.php',
                'html_template' => 'bgimage-html.php',
                'width' => '400',
                'height' => '250',
                'popup_position_x' => '-200',
                'popup_position_y' => '-125',
                'background_color' => 'rgba(0,0,0,0.6)',
                'title_color' => '#ffffff',
                'text_color' => '#ffffff'
            ]*/
        );

        foreach ($infobox_styles as $infobox_style) {
            update_option($infobox_style['slug'], $infobox_style);
        }
    }
}
