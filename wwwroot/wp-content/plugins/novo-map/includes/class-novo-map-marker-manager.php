<?php

/**
 * The file that manage database connections for the marker class
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 */

class Marker_Manager {
    private static $table_name = 'novomap_marker';
    private $db;

    /**
     * Marker_Manager constructor.
     *
     * @param $db
     * @since    1.0.0
     */
    public function __construct($db) {
        $this->set_db($db);
    }

    /**
     * create the marker table. Should be called on plugin activation
     *
     * @since    1.0.0
     */
    public function create() {
        $charset_collate = $this->db->get_charset_collate();
        $table_name = $this->db->prefix . 'novomap_marker';

        $sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  post_id mediumint(9) NOT NULL,
		  is_main tinyint(3) NOT NULL,
		  title text NOT NULL,
		  categories text,
		  tags text,
		  latitude float(9) NOT NULL,
		  longitude float(9) NOT NULL,
		  marker_logo_id mediumint(9) NOT NULL,
		  infobox_description text,
		  infobox_image mediumint(9) NOT NULL,
		  infobox_style tinytext NOT NULL,
		  UNIQUE KEY id (id)
	    ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    /**
     * Add Marker object in the database and return the id of the new object
     *
     * @param Marker $marker
     * @return mixed
     * @since    1.0.0
     */
    public function add (Marker $marker) {
        $this->db->insert(
            $this->db->prefix . self::$table_name,
            array(
                'time' => current_time( 'mysql' ),
                'post_id' => $marker->post_id(),
                'is_main' => $marker->is_main(),
                'title' => $marker->title(),
                'categories' => $marker->categories(),
                'tags' => $marker->tags(),
                'latitude' => $marker->latitude(),
                'longitude' => $marker->longitude(),
                'marker_logo_id' => $marker->marker_logo_id(),
                'infobox_description' => $marker->infobox_description(),
                'infobox_image' => $marker->infobox_image(),
                'infobox_style' => $marker->infobox_style()
            )
        );

        return $this->db->insert_id;
    }

    /**
     * Delete Marker object from the database
     *
     * @param Marker $marker
     * @since    1.0.0
     */
    public function delete(Marker $marker) {
        $this->db->delete(
            $this->db->prefix . self::$table_name,
            array(
                'id' => $marker->id()
            )
        );
    }

    /**
     * Update data of a Marker object
     *
     * @param Marker $marker
     * @since    1.0.0
     */
    public function update(Marker $marker) {
        $this->db->update(
            $this->db->prefix . self::$table_name,
            array(
                'post_id' => $marker->post_id(),
                'is_main' => $marker->is_main(),
                'title' => $marker->title(),
                'categories' => $marker->categories(),
                'tags' => $marker->tags(),
                'latitude' => $marker->latitude(),
                'longitude' => $marker->longitude(),
                'marker_logo_id' => $marker->marker_logo_id(),
                'infobox_description' => $marker->infobox_description(),
                'infobox_image' => $marker->infobox_image(),
                'infobox_style' => $marker->infobox_style()
            ),
            array('id'=>$marker->id())
        );
    }

    /**
     * Get a specific Marker object
     *
     * @param $id
     * @return Marker
     * @since    1.0.0
     */
    public function get($id) {
        $id = (int) $id;
        $table_name = $this->db->prefix . self::$table_name;

        $marker = $this->db->get_row(
            "
            SELECT * 
            FROM ".$table_name." 
            WHERE id = $id
        ",
            ARRAY_A
        );

        return new Marker($marker);
    }

    /**
     * get list of all markers
     *
     * @return array
     * @since    1.0.0
     */
    public function get_list() {
        $table_name = $this->db->prefix . self::$table_name;
        $marker_list = array();

        $list = $this->db->get_results(
            "
            SELECT * 
            FROM ".$table_name."
        ",
            ARRAY_A
        );

        foreach ($list as $marker){
            $marker_list[$marker['id']] = new Marker($marker);
        }

        return $marker_list;
    }

    /**
     * Get a list of all Marker objects associated to an article in an array
     *
     * @return array
     * @since    1.0.0
     */
    public function get_list_row_value($row, $value) {
        $table_name = $this->db->prefix . self::$table_name;
        $marker_list = array();

        $list = $this->db->get_results(
            "
            SELECT * 
            FROM ".$table_name."
            WHERE $row = $value
        ",
            ARRAY_A
        );

        foreach ($list as $marker){
            $marker_list[$marker['id']] = new Marker($marker);
        }

        return $marker_list;
    }

    /**
     * get a list of all marker with a specific category
     *
     * @param $category_id
     * @return array
     * @since    1.0.0
     */
    public function get_list_category($category_id) {
        $table_name = $this->db->prefix . self::$table_name;
        $marker_list = array();

        $list = $this->db->get_results($this->db->prepare(
            "
            SELECT * 
            FROM ".$table_name."
            WHERE categories LIKE %s",
            '%i:'.$category_id.';%'
        ),
            ARRAY_A
        );

        foreach ($list as $marker){
            $marker_list[$marker['id']] = new Marker($marker);
        }

        return $marker_list;
    }

    /**
     * get a list of all marker with a specific tag
     *
     * @param $tag_id
     * @return array
     * @since    1.0.0
     */
    public function get_list_tag($tag_id) {
        $table_name = $this->db->prefix . self::$table_name;
        $marker_list = array();

        $list = $this->db->get_results($this->db->prepare(
            "
            SELECT * 
            FROM ".$table_name."
            WHERE tags LIKE %s",
            '%i:'.$tag_id.';%'
        ),
            ARRAY_A
        );

        foreach ($list as $marker){
            $marker_list[$marker['id']] = new Marker($marker);
        }

        return $marker_list;
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