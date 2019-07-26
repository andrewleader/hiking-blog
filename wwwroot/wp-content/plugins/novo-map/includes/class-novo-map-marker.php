<?php
/**
 * The file that defines the Marker functionality
 *
 * A class that defines the marker object which are the pins you can add on the Gmap object
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 */
class Marker {
    /**
     * Unique id of the Marker object
     *
     * @access   private
     * @var      int
     * @since    1.0.0
     */
    private $id;

    /**
     * Id of the post where the marker was defined
     *
     * @access   private
     * @var      int
     * @since    1.0.0
     */
    private $post_id;

    /**
     * define if it is the main pin for a specific post
     * there should be only on main marker per post
     *
     * @access   private
     * @var      boolean
     * @since    1.0.0
     */
    private $is_main=true;

    /**
     * title of the marker
     *
     * @access   private
     * @var      string
     * @since    1.0.0
     */
    private $title;

    /**
     * Should reflect the categories (list of categories id) of the post_id
     *
     * @access   private
     * @var      string
     * @since    1.0.0
     */
    private $categories='';

    /**
     * Should reflect the tags (list og tags id) of the post id
     *
     * @access   private
     * @var      string
     * @since    1.0.0
     */
    private $tags='';

    /**
     * lattitude of the marker
     *
     * @access   private
     * @var      array
     * @since    1.0.0
     */
    private $latitude=0;

    /**
     * longitude of the marker
     *
     * @access   private
     * @var      array
     * @since    1.0.0
     */
    private $longitude=0;

    /**
     * marker_logo object attached to the marker
     *
     * @access   private
     * @var      object
     * @since    1.0.0
     */
    private $marker_logo_id=2;

    /**
     * description that appears in the infobox. Can be HTML
     *
     * @access   private
     * @var      string
     * @since    1.0.0
     */
    private $infobox_descritpion;

    /**
     * image id that should be displayed in the infobox
     * default value should not be changed as it is a small trick used later
     *
     * @access   private
     * @var      int
     * @since    1.0.0
     */
    private $infobox_image = -1;

    /**
     * infobox_style object attached to the marker
     *
     * @access   private
     * @var      string
     * @since    1.0.0
     */
    private $infobox_style='novo-map_infobox_style_default';

    /**
     * Marker constructor.
     * @param array $data
     * @since    1.0.0
     */
    public function __construct(array $data) {
        $this->hydrate($data);
    }

    /**
     * Hydrate the objects on construct with the given values.
     * The provided array should have the right structure
     *
     * @param array $data
     * @since    1.0.0
     */
    public function hydrate(array $data){
        foreach ($data as $key => $value) {
            //check if the key starts with novo-map- for unique names in wp admin
            if (substr( $key, 0, 16 ) === 'novo-map-marker-') {
                $key = str_replace('novo-map-marker-','',$key);
            }
            $method = 'set_'.$key;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * All getters and setters for the Marker class
     *
     * Data validation should occur in the setters
     */

    public function id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = (int)$id;
    }

    public function post_id() {
        return $this->post_id;
    }

    public function set_post_id($post_id) {
        $this->post_id = (int)$post_id;
    }

    public function is_main() {
        return $this->is_main;
    }

    public function set_is_main($is_main) {
        $this->is_main = (bool)$is_main;
    }

    public function title() {
        return $this->title;
    }

    public function set_title($title) {
        $this->title = sanitize_text_field($title);
    }

    public function categories() {
        return $this->categories;
    }

    public function set_categories($categories) {
        $this->categories = (string)$categories;
    }

    public function tags() {
        return $this->tags;
    }

    public function set_tags($tags) {
        $this->tags = (string)$tags;
    }

    public function latitude() {
        return $this->latitude;
    }

    public function set_latitude($latitude) {
        $this->latitude = (float)$latitude;
    }

    public function longitude() {
        return $this->longitude;
    }

    public function set_longitude($longitude) {
        $this->longitude = (float)$longitude;
    }

    public function marker_logo_id() {
        return $this->marker_logo_id;
    }

    public function set_marker_logo_id($marker_logo_id) {
        $this->marker_logo_id = (int)$marker_logo_id;
    }

    public function infobox_description() {
        return $this->infobox_descritpion;
    }

    public function set_infobox_description($infobox_description) {
        $this->infobox_descritpion = wp_kses_post($infobox_description);
    }

    public function infobox_image() {
        return $this->infobox_image;
    }

    public function set_infobox_image($infobox_image) {
        $this->infobox_image = (string)$infobox_image;
    }

    public function infobox_style() {
        return $this->infobox_style;
    }

    public function set_infobox_style($infobox_style) {
        $this->infobox_style = (string)$infobox_style;
    }

    /**
     * generate the marker object part of the gmap script
     *
     * @since    1.0.0
     */
    public function generate_script($gmap, $gmap_name, $infobox_style_list) {
        //generate the script from template
        ob_start();
        include( plugin_dir_path(dirname( __FILE__ )) .'public/partials/marker-script.php' );
        $marker_script = ob_get_contents();
        ob_end_clean();
        echo fn_minify_js($marker_script);
    }
}