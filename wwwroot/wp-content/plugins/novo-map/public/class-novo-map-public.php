<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/public
 * @author     novo-media <contact@novo-media.ch>
 */

class Novo_Map_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
     * The url of the plugin dir
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_dir_url    The current url of the plugin dir.
     */
    private $plugin_dir_url;

    /**
     * The url of the plugin path
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_dir_path    The current path of the plugin dir.
     */
    private $plugin_dir_path;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->plugin_dir_url = plugin_dir_url(dirname( __FILE__ ));
        $this->plugin_dir_path = plugin_dir_path( dirname( __FILE__ ) );
        require_once $this->plugin_dir_path . 'public/helpers/public-helpers.php';

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/novo-map-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/novo-map-public.js', array( 'jquery' ), $this->version, false );
	}

    /**
     * Add the Novo-map shortcode on the site
     *
     * @since    1.0.0
     * @param    $atts
     * @param    $content
     * @return   string
     */
	public function novo_map_shortcode($atts, $content) {
        require_once $this->plugin_dir_path . 'includes/class-novo-map-gmap.php';
        require_once $this->plugin_dir_path . 'includes/class-novo-map-gmap-manager.php';
        global $wpdb;

        $html   = array();
        $html[] = $content;

	    $atts = shortcode_atts(
            array(
                'id' => '',
                'name' => '',
                'width' => '',
                'height' => '',
                'category' => '',
                'tag' => '',
                'latitude' => '',
                'longitude' => '',
                'zoom' => '',
            ),
            $atts
        );

        $gmap_manager = new Gmap_Manager($wpdb);
        $gmap = $gmap_manager->get($atts['id']);

        if($gmap) {
            //add random shortcode suffix to the map for unique name
            $gmap->set_name($gmap->name().generate_random_string());

            // overwrite map attr if defined in the shortcode
            foreach($atts as $key => $value) {
                $method = 'set_'.$key;
                if (method_exists($gmap, $method) and $value != '') {
                    $gmap->$method($value);
                }
            }

            ob_start();
            include( 'partials/novo-map-shortcode.php' );
            $shortcode_html = ob_get_contents();
            ob_end_clean();
            $html[] = $shortcode_html;

            $gmap->enqueue_map($this->plugin_name);
        }
        else {
            $html[] = _e('<strong>This Gmap id is not defined</strong>', $this->plugin_name);
        }

        return implode( '', $html );
    }

}
