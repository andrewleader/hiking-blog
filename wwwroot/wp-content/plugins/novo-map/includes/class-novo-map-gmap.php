<?php

/**
 * The file that defines the google map functionality
 *
 * A class the defines the map object with its properties
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 */
class Gmap {

    /**
     * unique id of a gmap
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $id;

    /**
     * name of the gmap object
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $name = 'Your New Map';

    /**
     * width of the map in px or in %
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $width = '100%';

    /**
     * height of the map in px
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $height = '300px';

    /**
     * latitude of the center of the map
     *
     * @since    1.0.0
     * @access   private
     * @var      float
     */
    private $latitude = 0;

    /**
     * longitude of the center of the map
     *
     * @since    1.0.0
     * @access   private
     * @var      float
     */
    private $longitude = 0;

    /**
     * default zoom of the map
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $zoom = 2;

    /**
     * filter markers with a category
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $category;

    /**
     * filter markers with a tag
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $tag;

    /**
     * If the gmap type menu is displayed or no
     *
     * @since    1.0.0
     * @access   private
     * @var      boolean
     */
    private $type_menu = false;

    /**
     * if type menu is displayed, choose the position of the menu
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $type_menu_position = 'TOP_RIGHT';

    /**
     * If the map display a Zoom button or not
     *
     * @since    1.0.0
     * @access   private
     * @var      boolean
     */
    private $zoom_button = true;

    /**
     * If the zoom button is displayed, choose the position of the button
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $zoom_button_position = 'TOP_LEFT';

    /**
     * if defined, apply the same infobox style (name of the style) to all markers of the map
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $infobox_style = 'no';

    /**
     * If the pin clustering is activated or not
     *
     * @since    1.0.0
     * @access   private
     * @var      boolean
     */
    private $pin_clustering = false;

    /**
     * the size of one square where pins are clustered together
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $clustering_grid_size = 25;

    /**
     * color of the number that is displayed in the pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $clustering_text_color = '#ffffff';

    /**
     * id of the marker that is used for small amount of pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var int
     */
    private $clustering_marker_logo_id_small = 3;

    /**
     * text size of the small pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $clustering_text_size_small = 12;

    /**
     * x alignment of small pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $clustering_text_align_x_small = 0;

    /**
     * y alignment of small pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $clustering_text_align_y_small = 10;

    /**
     * id of the marker that is used for medium amount of pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var int
     */
    private $clustering_marker_logo_id_medium = 4;

    /**
     * text size of the medium pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $clustering_text_size_medium = 14;

    /**
     * x alignment of medium pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $clustering_text_align_x_medium = 0;

    /**
     * y alignment of medium pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $clustering_text_align_y_medium = 11;

    /**
     * id of the marker that is used for big amount of pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var int
     */
    private $clustering_marker_logo_id_big = 5;

    /**
     * text size of the small pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $clustering_text_size_big = 16;

    /**
     * x alignment of small pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $clustering_text_align_x_big = 0;

    /**
     * y alignment of small pin clustering
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $clustering_text_align_y_big = 12;

    /**
     * add an special marker for this map
     *
     * @since    1.0.0
     * @access   private
     * @var      bool
     */
    private $additional_marker = false;

    /**
     * latitude of the additionl marker
     *
     * @since    1.0.0
     * @access   private
     * @var      float
     */
    private $additional_marker_latitude;

    /**
     * longitude of the additional marker
     *
     * @since    1.0.0
     * @access   private
     * @var      float
     */
    private $additional_marker_longitude;

    /**
     * marker logo id for the additional marker
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $additional_marker_logo_id = 1;

    /**
     * title of the additional marker
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $additional_marker_title;

    /**
     * load the map scripts automatically or not
     *
     * @since    1.0.0
     * @access   private
     * @var      bool
     */
    private $load_scripts = true;

    /**
     * Define the look and colors of the map
     *
     * @since 1.0.0
     * @acess private
     * @var string
     */
    private $style = '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"color":"#f2f2f2"}]},{"featureType":"landscape","elementType":"labels.icon","stylers":[{"color":"#c9c9c9"},{"weight":1.5}]},{"featureType":"landscape","elementType":"labels.text.fill","stylers":[{"color":"#484747"}]},{"featureType":"landscape","elementType":"labels.text.stroke","stylers":[{"visibility":"simplified"}]},{"featureType":"road","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"color":"#0076a7"},{"visibility":"on"}]}]';

    /**
     * Gmap constructor.
     *
     * @param array $data
     */
    public function __construct(array $data) {
        $this->hydrate($data);
    }

    /**
     * Hydrate the objects on construct with the given values.
     * The provided array should have the right structure
     *
     * @param array $data
     */
    public function hydrate(array $data){
        foreach ($data as $key => $value) {
            //check if the key starts with novo-map- for unique names in wp admin
            if (substr( $key, 0, 14 ) === 'novo-map-gmap-') {
                $key = str_replace('novo-map-gmap-','',$key);
            }
            $method = 'set_'.$key;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * All getters and setters for the Gmap class
     *
     * Data validation should occur in the setters
     */
    public function id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = (int)$id;
    }

    public function name() {
        return $this->name;
    }

    public function set_name($name) {
        $this->name = sanitize_text_field($name);
    }

    public function width() {
        return $this->width;
    }

    public function set_width($width) {
        if (preg_match('/(\d*)(px|%)/', $width)){
            $this->width = $width;
        }
        else {
            _e('<div class="notice notice-error is-dismissible"><p>only valid width in % or px are allowed like : 100%</p></div>');
            exit;
        }
    }

    public function height() {
        return $this->height;
    }

    public function set_height($height) {
        if (preg_match('/(\d*)(px)/', $height)){
            $this->height = $height;
        }
        else {
            _e('<div class="notice notice-error is-dismissible"><p>only valid height in px is allowed like: 300px </p></div>');
            exit;
        }
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

    public function zoom() {
        return $this->zoom;
    }

    public function set_zoom($zoom) {
        $this->zoom = (int)$zoom;
    }

    public function category() {
        return $this->category;
    }

    public function set_category($category) {
        $this->category = (int)$category;
    }

    public function tag() {
        return $this->tag;
    }

    public function set_tag($tag) {
        $this->tag = (int)$tag;
    }

    public function type_menu() {
        return $this->type_menu;
    }

    public function set_type_menu($type_menu) {
        $this->type_menu = (bool)$type_menu;
    }

    public function type_menu_position() {
        return $this->type_menu_position;
    }

    public function set_type_menu_position($type_menu_position) {
        $this->type_menu_position = (string)$type_menu_position;
    }

    public function zoom_button() {
        return $this->zoom_button;
    }

    public function set_zoom_button($zoom_button) {
        $this->zoom_button = (bool)$zoom_button;
    }

    public function zoom_button_position() {
        return $this->zoom_button_position;
    }

    public function set_zoom_button_position($zoom_button_position) {
        $this->zoom_button_position = (string)$zoom_button_position;
    }

    public function infobox_style() {
        return $this->infobox_style;
    }

    public function set_infobox_style($infobox_style) {
        $this->infobox_style = (string)$infobox_style;
    }

    public function pin_clustering() {
        return $this->pin_clustering;
    }

    public function set_pin_clustering($pin_clustering) {
        $this->pin_clustering = (bool)$pin_clustering;
    }

    public function clustering_grid_size() {
        return $this->clustering_grid_size;
    }

    public function set_clustering_grid_size($clustering_grid_size) {
        $this->clustering_grid_size = (int)$clustering_grid_size;
    }

    public function clustering_text_color() {
        return $this->clustering_text_color;
    }

    public function set_clustering_text_color($clustering_text_color) {
        if (preg_match('/^#[a-f0-9]{6}$/', $clustering_text_color)){
            $this->clustering_text_color = $clustering_text_color;
        }
        else {
            _e('<div class="notice notice-error is-dismissible"><p>The color has not the right HEX format</p></div>');
            exit;
        }
    }

    public function clustering_marker_logo_id_small() {
        return $this->clustering_marker_logo_id_small;
    }

    public function set_clustering_marker_logo_id_small($clustering_marker_logo_id_small) {
        $this->clustering_marker_logo_id_small = (int)$clustering_marker_logo_id_small;
    }

    public function clustering_text_size_small() {
        return $this->clustering_text_size_small;
    }

    public function set_clustering_text_size_small($clustering_text_size_small){
        $this->clustering_text_size_small = (int)$clustering_text_size_small;
    }

    public function clustering_text_align_x_small() {
        return $this->clustering_text_align_x_small;
    }

    public function set_clustering_text_align_x_small($clustering_text_align_x_small){
        $this->clustering_text_align_x_small = (int)$clustering_text_align_x_small;
    }

    public function clustering_text_align_y_small() {
        return $this->clustering_text_align_y_small;
    }

    public function set_clustering_text_align_y_small($clustering_text_align_y_small){
        $this->clustering_text_align_y_small = (int)$clustering_text_align_y_small;
    }

    public function clustering_marker_logo_id_medium() {
        return $this->clustering_marker_logo_id_medium;
    }

    public function set_clustering_marker_logo_id_medium($clustering_marker_logo_id_medium) {
        $this->clustering_marker_logo_id_medium = (int)$clustering_marker_logo_id_medium;
    }

    public function clustering_text_size_medium() {
        return $this->clustering_text_size_medium;
    }

    public function set_clustering_text_size_medium($clustering_text_size_medium){
        $this->clustering_text_size_medium = (int)$clustering_text_size_medium;
    }

    public function clustering_text_align_x_medium() {
        return $this->clustering_text_align_x_medium;
    }

    public function set_clustering_text_align_x_medium($clustering_text_align_x_medium){
        $this->clustering_text_align_x_medium = (int)$clustering_text_align_x_medium;
    }

    public function clustering_text_align_y_medium() {
        return $this->clustering_text_align_y_medium;
    }

    public function set_clustering_text_align_y_medium($clustering_text_align_y_medium){
        $this->clustering_text_align_y_medium = (int)$clustering_text_align_y_medium;
    }

    public function clustering_marker_logo_id_big() {
        return $this->clustering_marker_logo_id_big;
    }

    public function set_clustering_marker_logo_id_big($clustering_marker_logo_id_big) {
        $this->clustering_marker_logo_id_big = (int)$clustering_marker_logo_id_big;
    }

    public function clustering_text_size_big() {
        return $this->clustering_text_size_big;
    }

    public function set_clustering_text_size_big($clustering_text_size_big){
        $this->clustering_text_size_big = (int)$clustering_text_size_big;
    }

    public function clustering_text_align_x_big() {
        return $this->clustering_text_align_x_big;
    }

    public function set_clustering_text_align_x_big($clustering_text_align_x_big){
        $this->clustering_text_align_x_big = (int)$clustering_text_align_x_big;
    }

    public function clustering_text_align_y_big() {
        return $this->clustering_text_align_y_big;
    }

    public function set_clustering_text_align_y_big($clustering_text_align_y_big){
        $this->clustering_text_align_y_big = (int)$clustering_text_align_y_big;
    }

    public function additional_marker() {
        return $this->additional_marker;
    }

    public function set_additional_marker($additional_marker) {
        $this->additional_marker = (bool)$additional_marker;
    }

    public function additional_marker_latitude() {
        return $this->additional_marker_latitude;
    }

    public function set_additional_marker_latitude($additional_marker_latitude) {
        $this->additional_marker_latitude = (float)$additional_marker_latitude;
    }

    public function additional_marker_longitude() {
        return $this->additional_marker_longitude;
    }

    public function set_additional_marker_longitude($additional_marker_longitude) {
        $this->additional_marker_longitude = (float)$additional_marker_longitude;
    }

    public function additional_marker_logo_id() {
        return $this->additional_marker_logo_id;
    }

    public function set_additional_marker_logo_id($additional_marker_logo_id) {
        $this->additional_marker_logo_id = (int)$additional_marker_logo_id;
    }

    public function additional_marker_title() {
        return $this->additional_marker_title;
    }

    public function set_additional_marker_title($additional_marker_title) {
        $this->additional_marker_title = sanitize_text_field($additional_marker_title);
    }

    public function load_scripts() {
        return $this->load_scripts;
    }

    public function set_load_scripts($load_scripts) {
        $this->load_scripts = (bool)$load_scripts;
    }

    public function style() {
        return $this->style;
    }

    public function set_style($style) {
        $result = json_decode($style);

        if (json_last_error() === JSON_ERROR_NONE) {
            $this->style = $style;
        }
        else{
            _e('<div class="notice notice-error is-dismissible"><p>JSON style has not the right format </p></div>');
            exit;
        }
    }

    /**
     * Enqueue necessary script to generate the gmap
     *
     * @param $plugin_name
     * @since    1.0.0
     */
    public function enqueue_map($plugin_name) {
        // enqueue necessary stuff
        wp_enqueue_script( $plugin_name.'-gmap-api', 'https://maps.googleapis.com/maps/api/js?v=3.37&key=' . esc_attr(get_option($plugin_name.'_gmap_api_key')) . '', array(), null, true );
        wp_enqueue_script( $plugin_name.'-infobox', plugins_url( $plugin_name) .'/public/assets/js/infobox.js', array( $plugin_name.'-gmap-api' ) );
        if($this->pin_clustering()) {
            wp_enqueue_script( $plugin_name.'-markerclusterer', plugins_url( $plugin_name) .'/public/assets/js/markerclusterer.js', array( $plugin_name.'-gmap-api' ) );
        }

        // generate and enqueue map script
        add_action( 'wp_print_footer_scripts', array( $this, 'generate_script'), 15 );
    }

    /**
     * function that generate the gmap specific part of the script
     *
     * @since    1.0.0
     */
    public function generate_script() {
        //get the necessary classes
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-marker.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-marker-manager.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-marker-logo.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-marker-logo-manager.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-infobox-style.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-infobox-style-manager.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/helpers/php-html-css-js-minifier.php';
        global $wpdb;
        $marker_logo_manager = new Marker_Logo_Manager($wpdb);
        $marker_manager = new Marker_Manager($wpdb);
        $infobox_style_manager = new Infobox_Style_Manager($wpdb);

        //alphanumeric gmap name to avoid problems with gmap api (name has to be unique)
        $gmap_name = alphanumeric_string($this->name());

        //get all markers to display
        $category = $this->category();
        $tag = $this->tag();
        if(empty($category) and empty($tag)) {
            $marker_list = $marker_manager->get_list();
        }
        elseif (! empty($category)) {
            $marker_list = $marker_manager->get_list_category($this->category());
        }
        elseif (! empty($tag)) {
            $marker_list = $marker_manager->get_list_tag($this->tag());
        }

        //get additional marker if defined
        if($this->additional_marker()) {
            $additional_marker_array = array(
                'latitude' => $this->additional_marker_latitude(),
                'longitude' => $this->additional_marker_longitude(),
                'title' => $this->additional_marker_title(),
                'marker_logo_id' => $this->additional_marker_logo_id(),
                'infobox_style' => '',
            );
            $additional_marker = new Marker($additional_marker_array);
        }

        //get only the necessary marker logo for this map
        $marker_logo_id_list = get_marker_logo_ids_from_map_marker($this, $marker_list);
        $marker_logo_list = $marker_logo_manager->get_list_from_ids_list($marker_logo_id_list);

        //get the necessary infobox styles for this map
        if ($this->infobox_style()!=='no') {
            $infobox_style_list[$this->infobox_style()] = $infobox_style_manager->get($this->infobox_style());
        }
        else {
            $infobox_style_list = $infobox_style_manager->get_infobox_styles_from_marker($marker_list);
        }

        //add custom styles for necessary infoboxes
        foreach ($infobox_style_list as $infobox_style) {
            $infobox_style->add_css($gmap_name);
        }

        //generate the script from template
        ob_start();
        include( plugin_dir_path(dirname( __FILE__ )) .'public/partials/gmap-script.php' );
        $gmap_script = ob_get_contents();
        ob_end_clean();
        //echo a minified version of the js
        echo fn_minify_js($gmap_script);
    }

    /**
     * generate map script for the admin side (post menu and gmap menu)
     *
     * @since    1.0.0
     */
    public function generate_script_admin() {
        //get the necessary classes
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-marker.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-marker-manager.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-marker-logo.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-marker-logo-manager.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-infobox-style.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-novo-map-infobox-style-manager.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/helpers/php-html-css-js-minifier.php';
        global $wpdb;
        $marker_logo_manager = new Marker_Logo_Manager($wpdb);
        $marker_manager = new Marker_Manager($wpdb);
        $infobox_style_manager = new Infobox_Style_Manager($wpdb);

        //alphanumeric gmap name to avoid problems with gmap api (name has to be unique)
        $gmap_name = alphanumeric_string($this->name());

        if($gmap_name == 'postmenumap') {
            $marker_list = $marker_manager->get_list_row_value('post_id', get_the_ID());
        }
        else {
            //get all markers to display
            $category = $this->category();
            $tag = $this->tag();
            if(empty($category) and empty($tag)) {
                $marker_list = $marker_manager->get_list();
            }
            elseif (! empty($category)) {
                $marker_list = $marker_manager->get_list_category($this->category());
            }
            elseif (! empty($tag)) {
                $marker_list = $marker_manager->get_list_tag($this->tag());
            }
        }


        //get additional marker if defined
        if($this->additional_marker()) {
            $additional_marker_array = array(
                'latitude' => $this->additional_marker_latitude(),
                'longitude' => $this->additional_marker_longitude(),
                'title' => $this->additional_marker_title(),
                'marker_logo_id' => $this->additional_marker_logo_id(),
                'infobox_style' => '',
            );
            $additional_marker = new Marker($additional_marker_array);
        }

        //get only the necessary marker logo for this map
        $marker_logo_id_list = get_marker_logo_ids_from_map_marker($this, $marker_list);
        $marker_logo_list = $marker_logo_manager->get_list_from_ids_list($marker_logo_id_list);

        //get the necessary infobox styles for this map
        if ($this->infobox_style()!=='no') {
            $infobox_style_list[$this->infobox_style()] = $infobox_style_manager->get($this->infobox_style());
        }
        else {
            $infobox_style_list = $infobox_style_manager->get_infobox_styles_from_marker($marker_list);
        }

        //add custom styles for necessary infoboxes
        foreach ($infobox_style_list as $infobox_style) {
            $infobox_style->add_css($gmap_name);
        }

        //generate the script from template
        ob_start();
        include( plugin_dir_path(dirname( __FILE__ )) .'admin/partials/gmap-admin-script.php' );
        $gmap_script = ob_get_contents();
        ob_end_clean();
        //echo a minified version of the js
        echo fn_minify_js($gmap_script);
    }
}