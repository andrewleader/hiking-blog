<?php

/**
 * The file that defines the Infobox style object
 *
 * A class the defines different styles for the gmap infoboxes
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 */
class Infobox_Style {
    /**
     * unique name of the infobox style object
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $name;

    /**
     * slug of the infobox style object
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $slug;

    /**
     * name of the infobox css template
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $css_template;

    /**
     * name of the infobox html template
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $html_template;

    /**
     * width of the infobox in px
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $width;

    /**
     * height of the infobox in px
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $height;

    /**
     * horizontal popup position of the infobox in px
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $popup_position_x;

    /**
     * vertical popup position of the infobox in px
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $popup_position_y;

    /**
     * background color and opacity in rgba notation
     *
     * @since    1.0.0
     * @access   private
     * @var      int
     */
    private $background_color;

    /**
     * title color
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $title_color;

    /**
     * text color
     *
     * @since    1.0.0
     * @access   private
     * @var      string
     */
    private $text_color;

    /**
     * Infobox_Style constructor.
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
            if (substr( $key, 0, 23 ) === 'novo-map-infobox-style-') {
                $key = str_replace('novo-map-infobox-style-','',$key);
            }
            $method = 'set_'.$key;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * All getters and setters for the Infobox_Style class
     *
     * Data validation should occur in the setters
     */

    public function name() {
        return $this->name;
    }

    public function set_name($name) {
        $this->name = (string)$name;
    }

    public function slug() {
        return $this->slug;
    }

    public function set_slug($slug) {
        $this->slug = (string)$slug;
    }

    public function css_template() {
        return $this->css_template;
    }

    public function set_css_template($css_template) {
        $this->css_template = (string)$css_template;
    }

    public function html_template() {
        return $this->html_template;
    }

    public function set_html_template($html_template) {
        $this->html_template = (string)$html_template;
    }

    public function width() {
        return $this->width;
    }

    public function set_width($width) {
        $this->width = $width;
    }

    public function height() {
        return $this->height;
    }

    public function set_height($height) {
        $this->height = $height;
    }

    public function popup_position_x() {
        return $this->popup_position_x;
    }

    public function set_popup_position_x($popup_position_x) {
        $this->popup_position_x = $popup_position_x;
    }

    public function popup_position_y() {
        return $this->popup_position_y;
    }

    public function set_popup_position_y($popup_position_y) {
        $this->popup_position_y = $popup_position_y;
    }

    public function background_color() {
        return $this->background_color;
    }

    public function set_background_color($background_color) {
        $this->background_color = $background_color;
    }

    public function title_color() {
        return $this->title_color;
    }

    public function set_title_color($title_color) {
        $this->title_color = $title_color;
    }

    public function text_color() {
        return $this->text_color;
    }

    public function set_text_color($text_color) {
        $this->text_color = $text_color;
    }

    /**
     * generate the option part of the infobox style script (once per map)
     *
     * @since 1.0.0
     */
    public function generate_option_script() {
        require_once plugin_dir_path(dirname( __FILE__ )) . 'public/helpers/public-helpers.php';

        //generate the script from template
        ob_start();
        include( plugin_dir_path(dirname( __FILE__ )) .'public/partials/infobox-style-option-script.php' );
        $infobox_style_options = ob_get_contents();
        ob_end_clean();
        echo $infobox_style_options;
    }

    /**
     * generate the infobox script per marker
     *
     * @param $marker
     * @param $gmap_name
     * @since 1.0.0
     */
    public function generate_infobox_script($marker, $gmap_name) {
        require_once plugin_dir_path(dirname( __FILE__ )) . 'public/helpers/public-helpers.php';

        //generate the script from template
        ob_start();
        include( plugin_dir_path(dirname( __FILE__ )) .'public/partials/infobox-style-script.php' );
        $infobox_style = ob_get_contents();
        ob_end_clean();
        echo $infobox_style;
    }

    /**
     * enqueue unique css for the infoboxes of a maè
     *
     * @param $gmap_name
     * @since 1.0.0
     */
    public function add_css($gmap_name) {
        //generate the css from template
        ob_start();
        include( plugin_dir_path(dirname( __FILE__ )) .'public/partials/infobox-styles/'.$this->css_template() );
        $infobox_css = ob_get_contents();
        ob_end_clean();
        echo fn_minify_css($infobox_css);
    }
}