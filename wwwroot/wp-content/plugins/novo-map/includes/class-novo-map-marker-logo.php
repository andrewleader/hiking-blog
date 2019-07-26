<?php
/**
 * The file that defines the Marker Logo functionality
 *
 * A class that defines the marker logo object which are
 * the image you can associate to every Marker object
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 */
class Marker_Logo {
    /**
     * Unique id of the Marker Logo object
     *
     * @access   private
     * @var      int
     * @since    1.0.0
     */
    private $id;

    /**
     * url of the image
     *
     * @access   private
     * @var      string
     * @since    1.0.0
     */
    private $url;


    /**
     * width on the image in px
     *
     * @access   private
     * @var      int
     * @since    1.0.0
     */
    private $width = 45;

    /**
     * width on the image in px
     *
     * @access   private
     * @var      int
     * @since    1.0.0
     */
    private $height = 45;

    /**
     * x position of the anchor
     *
     * @access   private
     * @var      float
     * @since    1.0.0
     */
    private $anchor_x = 22.5;

    /**
     * y position of the anchor
     *
     * @access   private
     * @var      float
     * @since    1.0.0
     */
    private $anchor_y = 45;

    /**
     * status of the marker (default or smth else)
     *
     * @var string
     * @since    1.0.0
     */
    private $status = 'user';

    /**
     * Marker_Logo constructor.
     *
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
            if (substr( $key, 0, 21 ) === 'novo-map-marker-logo-') {
                $key = str_replace('novo-map-marker-logo-','',$key);
            }
            $method = 'set_'.$key;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * All getters and setters for the Marker Logo class
     *
     * Data validation should occur in the setters
     */

    public function id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = (int)$id;
    }

    public function url() {
        if(!empty($this->url)) {
            $parsed = parse_url($this->url);
            if(is_ssl()) {
                $parsed['scheme'] = 'https';
            }
            else {
                $parsed['scheme'] = 'http';
            }
            return $parsed['scheme'].'://'.$parsed['host'].$parsed['path'];
        }
        else{
            return $this->url;
        }
    }

    public function set_url($url) {
        $this->url = (string)$url;
    }

    public function width() {
        return $this->width;
    }

    public function set_width($width) {
        $this->width = (int)$width;
    }

    public function height() {
        return $this->height;
    }

    public function set_height($height) {
        $this->height = (int)$height;
    }

    public function anchor_x() {
        return $this->anchor_x;
    }

    public function anchor_x_text() {
        if ($this->anchor_x == 0) {
            return 'left';
        }
        elseif ($this->anchor_x == $this->width / 2) {
            return 'middle';
        }
        elseif ($this->anchor_x == $this->width) {
            return 'right';
        }
        else {
            return 'middle';
        }

        return $this->anchor_y;
    }

    public function set_anchor_x($anchor_x) {
        if ($anchor_x == 'left') {
            $this->anchor_x = (float)0;
        }
        elseif ($anchor_x == 'middle') {
            $this->anchor_x = (float)$this->width / 2;
        }
        elseif ($anchor_x == 'right') {
            $this->anchor_x = (float)$this->width;
        }
        else {
            $this->anchor_x = (float)$anchor_x;
        }
    }

    public function anchor_y() {
        return $this->anchor_y;
    }

    public function anchor_y_text() {
        if ($this->anchor_y == 0) {
            return 'top';
        }
        elseif ($this->anchor_y == $this->height / 2) {
            return 'middle';
        }
        elseif ($this->anchor_y == $this->height) {
            return 'bottom';
        }
        else {
            return 'top';
        }

        return $this->anchor_y;
    }

    public function set_anchor_y($anchor_y) {
        if ($anchor_y == 'top') {
            $this->anchor_y = (float)0;
        }
        elseif ($anchor_y == 'middle') {
            $this->anchor_y = (float)$this->height / 2;
        }
        elseif ($anchor_y == 'bottom') {
            $this->anchor_y = (float)$this->height;
        }
        else {
            $this->anchor_y = (float)$anchor_y;
        }
    }

    public function status() {
        return $this->status;
    }

    public function set_status($status) {
        $this->status = (string)$status;
    }

    /**
     * generate the marker logo part of the script
     *
     * @since    1.0.0
     */
    public function generate_script() {
        //generate the script from template
        ob_start();
        include( plugin_dir_path(dirname( __FILE__ )) .'public/partials/marker-logo-script.php' );
        $marker_logo_script = ob_get_contents();
        ob_end_clean();
        echo fn_minify_js($marker_logo_script);
    }
}