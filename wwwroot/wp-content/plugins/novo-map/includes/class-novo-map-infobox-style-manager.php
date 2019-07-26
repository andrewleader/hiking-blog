<?php
/**
 * The file that manage database connections for the infobox style class class
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 */

class Infobox_Style_Manager {
    private $db;
    private static $table_name = 'options';

    /**
     * Infobox_Style_Manager constructor.
     *
     * @param $db
     * @since    1.0.0
     */
    public function __construct($db) {
        $this->set_db($db);
    }

    /**
     * return an infobox object from it's option name
     *
     * @param $slug
     * @return Infobox_Style
     * @since    1.0.0
     */
    public function get($slug) {
        $infobox_style_array = get_option($slug);
        return new Infobox_Style($infobox_style_array);
    }

    /**
     * return a list of all Infobox Style objects
     *
     * @return array
     * @since    1.0.0
     */
    public function get_all_infobox_styles() {
        $table_name = $this->db->prefix . self::$table_name;
        $style_list = array();

        $list = $this->db->get_results(
            "
            SELECT option_value 
            FROM ".$table_name."
            WHERE option_name LIKE 'novo-map_infobox_style%'
            ",
            ARRAY_A
        );

        foreach ($list as $style){
            $style_array = unserialize($style['option_value']);
            $style_list[$style_array['slug']] = new Infobox_Style($style_array);
        }

        return $style_list;
    }

    /**
     * get a list of the infobox styles necessary for map based on the marker list
     *
     * @since   1.0.0
     * @param   $markers
     * @return  array
     */
    public function get_infobox_styles_from_marker($markers) {
        $infobox_style_name_list = array();
        foreach ($markers as $marker) {
            if(!in_array($marker->infobox_style(), $infobox_style_name_list)){
                $infobox_style_name_list[] = $marker->infobox_style();
            }
        }

        $infobox_style_list = array();
        foreach ($infobox_style_name_list as $infobox_style_name) {
            $infobox_style_list[$infobox_style_name] = new Infobox_Style(get_option($infobox_style_name));
        }

        return $infobox_style_list;
    }

    /**
     * set the db on construct
     *
     * @param wpdb $db
     * @since    1.0.0
     */
    public function set_db(wpdb $db) {
        $this->db = $db;
    }
}