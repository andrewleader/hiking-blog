<?php

/**
 * The file that manage database connections for the gmap class
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 */

class Gmap_Manager {
    private static $table_name = 'novomap_gmap';
    private $db;

    /**
     * Gmap_Manager constructor.
     *
     * @param $db
     * @since    1.0.0
     */
    public function __construct($db) {
      $this->set_db($db);
    }

    /**
     * Create gmap table. Should be called on plugin activation
     *
     * @since    1.0.0
     */
    public function create() {
        $charset_collate = $this->db->get_charset_collate();
        $table_name = $this->db->prefix . 'novomap_gmap';

        $sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  name tinytext NOT NULL,
		  width tinytext NOT NULL,
		  height tinytext NOT NULL,
		  latitude float(9) NOT NULL,
		  longitude float(9) NOT NULL,
		  zoom tinyint(3) NOT NULL,
		  category mediumint(9),
		  tag mediumint(9),
		  type_menu tinyint(3) NOT NULL,
		  type_menu_position tinytext NOT NULL,
		  zoom_button tinyint(3) NOT NULL,
		  zoom_button_position tinytext NOT NULL,
		  infobox_style tinytext NOT NULL,
		  pin_clustering tinyint(3) NOT NULL,
		  clustering_grid_size tinyint(3) NOT NULL,
		  clustering_text_color tinytext NOT NULL,
		  clustering_marker_logo_id_small mediumint(9) NOT NULL,
		  clustering_text_size_small tinyint(3) NOT NULL,
		  clustering_text_align_x_small tinyint(3) NOT NULL,
		  clustering_text_align_y_small tinyint(3) NOT NULL,
		  clustering_marker_logo_id_medium mediumint(9) NOT NULL,
		  clustering_text_size_medium tinyint(3) NOT NULL,
		  clustering_text_align_x_medium tinyint(3) NOT NULL,
		  clustering_text_align_y_medium tinyint(3) NOT NULL,
		  clustering_marker_logo_id_big mediumint(9) NOT NULL,
		  clustering_text_size_big tinyint(3) NOT NULL,
		  clustering_text_align_x_big tinyint(3) NOT NULL,
		  clustering_text_align_y_big tinyint(3) NOT NULL,
		  additional_marker tinyint(3) NOT NULL,
		  additional_marker_latitude float(9),
		  additional_marker_longitude float(9),
		  additional_marker_logo_id mediumint(9),
		  additional_marker_title text,
		  load_scripts tinyint(3) NOT NULL,
		  style text NOT NULL,
		  UNIQUE KEY id (id)
	    ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    /**
     * Add Gmap object in the database and return the id of the new object
     *
     * @param Gmap $gmap
     * @return mixed
     * @since    1.0.0
     */
    public function add (Gmap $gmap) {
        $this->db->insert(
            $this->db->prefix . self::$table_name,
            array(
                'time' => current_time( 'mysql' ),
                'name' => $gmap->name(),
                'width' => $gmap->width(),
                'height' => $gmap->height(),
                'zoom' => $gmap->zoom(),
                'latitude' => $gmap->latitude(),
                'longitude' => $gmap->longitude(),
                'category' => $gmap->category(),
                'tag' => $gmap->tag(),
                'type_menu' => $gmap->type_menu(),
                'type_menu_position' => $gmap->type_menu_position(),
                'zoom_button' => $gmap->zoom_button(),
                'zoom_button_position' => $gmap->zoom_button_position(),
                'infobox_style' => $gmap->infobox_style(),
                'pin_clustering' => $gmap->pin_clustering(),
                'clustering_grid_size' => $gmap->clustering_grid_size(),
                'clustering_text_color' => $gmap->clustering_text_color(),
                'clustering_marker_logo_id_small' => $gmap->clustering_marker_logo_id_small(),
                'clustering_text_size_small' => $gmap->clustering_text_size_small(),
                'clustering_text_align_x_small' => $gmap->clustering_text_align_x_small(),
                'clustering_text_align_y_small' => $gmap->clustering_text_align_y_small(),
                'clustering_marker_logo_id_medium' => $gmap->clustering_marker_logo_id_medium(),
                'clustering_text_size_medium' => $gmap->clustering_text_size_medium(),
                'clustering_text_align_x_medium' => $gmap->clustering_text_align_x_medium(),
                'clustering_text_align_y_medium' => $gmap->clustering_text_align_y_medium(),
                'clustering_marker_logo_id_big' => $gmap->clustering_marker_logo_id_big(),
                'clustering_text_size_big' => $gmap->clustering_text_size_big(),
                'clustering_text_align_x_big' => $gmap->clustering_text_align_x_big(),
                'clustering_text_align_y_big' => $gmap->clustering_text_align_y_big(),
                'additional_marker' => $gmap->additional_marker(),
                'additional_marker_latitude' => $gmap->additional_marker_latitude(),
                'additional_marker_longitude' => $gmap->additional_marker_longitude(),
                'additional_marker_logo_id' => $gmap->additional_marker_logo_id(),
                'additional_marker_title' => $gmap->additional_marker_title(),
                'load_scripts' => $gmap->load_scripts(),
                'style' => $gmap->style()
            )
        );

        return $this->db->insert_id;
    }

    /**
     * Delete Gmap object from the database
     *
     * @param Gmap $gmap
     * @since    1.0.0
     */
    public function delete(Gmap $gmap) {
        $this->db->delete(
            $this->db->prefix . self::$table_name,
            array(
                'id' => $gmap->id()
            )
        );
    }

    /**
     * Update data of a Gmap object
     *
     * @param Gmap $gmap
     * @since    1.0.0
     */
    public function update(Gmap $gmap) {
        $this->db->update(
            $this->db->prefix . self::$table_name,
            array(
                'time' => current_time( 'mysql' ),
                'name' => $gmap->name(),
                'width' => $gmap->width(),
                'height' => $gmap->height(),
                'zoom' => $gmap->zoom(),
                'latitude' => $gmap->latitude(),
                'longitude' => $gmap->longitude(),
                'category' => $gmap->category(),
                'tag' => $gmap->tag(),
                'type_menu' => $gmap->type_menu(),
                'type_menu_position' => $gmap->type_menu_position(),
                'zoom_button' => $gmap->zoom_button(),
                'zoom_button_position' => $gmap->zoom_button_position(),
                'infobox_style' => $gmap->infobox_style(),
                'pin_clustering' => $gmap->pin_clustering(),
                'clustering_grid_size' => $gmap->clustering_grid_size(),
                'clustering_text_color' => $gmap->clustering_text_color(),
                'clustering_marker_logo_id_small' => $gmap->clustering_marker_logo_id_small(),
                'clustering_text_size_small' => $gmap->clustering_text_size_small(),
                'clustering_text_align_x_small' => $gmap->clustering_text_align_x_small(),
                'clustering_text_align_y_small' => $gmap->clustering_text_align_y_small(),
                'clustering_marker_logo_id_medium' => $gmap->clustering_marker_logo_id_medium(),
                'clustering_text_size_medium' => $gmap->clustering_text_size_medium(),
                'clustering_text_align_x_medium' => $gmap->clustering_text_align_x_medium(),
                'clustering_text_align_y_medium' => $gmap->clustering_text_align_y_medium(),
                'clustering_marker_logo_id_big' => $gmap->clustering_marker_logo_id_big(),
                'clustering_text_size_big' => $gmap->clustering_text_size_big(),
                'clustering_text_align_x_big' => $gmap->clustering_text_align_x_big(),
                'clustering_text_align_y_big' => $gmap->clustering_text_align_y_big(),
                'additional_marker' => $gmap->additional_marker(),
                'additional_marker_latitude' => $gmap->additional_marker_latitude(),
                'additional_marker_longitude' => $gmap->additional_marker_longitude(),
                'additional_marker_logo_id' => $gmap->additional_marker_logo_id(),
                'additional_marker_title' => $gmap->additional_marker_title(),
                'load_scripts' => $gmap->load_scripts(),
                'style' => $gmap->style()
            ),
            array('id'=>$gmap->id())
        );
    }


    /**
     * Get a specific Gmap object
     *
     * @param $id
     * @return Gmap
     * @since    1.0.0
     */
    public function get($id) {
        $id = (int) $id;
        $table_name = $this->db->prefix . self::$table_name;

        $gmap = $this->db->get_row(
            "
            SELECT * 
            FROM ".$table_name." 
            WHERE id = $id",
            ARRAY_A
        );

        if (empty($gmap)) {
            return false;
        }
        else {
            return new Gmap($gmap);
        }
    }

    /**
     * Get a list of all Gmap objects in an array
     *
     * @return array
     * @since    1.0.0
     */
    public function get_list() {
        $table_name = $this->db->prefix . self::$table_name;
        $gmap_list = array();

        $list = $this->db->get_results(
            "
            SELECT * 
            FROM ".$table_name,
            ARRAY_A
        );

        foreach ($list as $gmap){
            $gmap_list[$gmap['id']] = new Gmap($gmap);
        }

        return $gmap_list;
    }

    /**
     * Get a list of all Gmap objects that have a specific marker for cluster
     *
     * @return array
     * @since    1.0.0
     */
    public function get_list_with_marker($marker_id) {
        $table_name = $this->db->prefix . self::$table_name;
        $gmap_list = array();

        $list = $this->db->get_results($this->db->prepare(
            "
            SELECT * 
            FROM ".$table_name."
            WHERE %d IN (clustering_marker_logo_id_small, clustering_marker_logo_id_medium, clustering_marker_logo_id_big)",
            $marker_id
        ),
            ARRAY_A
        );

        foreach ($list as $gmap){
            $gmap_list[$gmap['id']] = new Gmap($gmap);
        }

        return $gmap_list;
    }

    /**
     * Get a list of all Gmap objects that have a specific value for category
     *
     * @return array
     * @since    1.0.0
     */
    public function get_list_category($category_id) {
        $table_name = $this->db->prefix . self::$table_name;
        $gmap_list = array();

        $list = $this->db->get_results($this->db->prepare(
            "
            SELECT * 
            FROM ".$table_name."
            WHERE category = %d",
            $category_id
        ),
            ARRAY_A
        );

        foreach ($list as $gmap){
            $gmap_list[$gmap['id']] = new Gmap($gmap);
        }

        return $gmap_list;
    }

    /**
     * Get a list of all Gmap objects that have a specific value for tag
     *
     * @return array
     * @since    1.0.0
     */
    public function get_list_tag($tag_id) {
        $table_name = $this->db->prefix . self::$table_name;
        $gmap_list = array();

        $list = $this->db->get_results($this->db->prepare(
            "
            SELECT * 
            FROM ".$table_name."
            WHERE tag = %d",
            $tag_id
        ),
            ARRAY_A
        );

        foreach ($list as $gmap){
            $gmap_list[$gmap['id']] = new Gmap($gmap);
        }

        return $gmap_list;
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