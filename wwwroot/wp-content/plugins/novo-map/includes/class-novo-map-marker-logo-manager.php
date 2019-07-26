<?php

/**
 * The file that manage database connections for the marker Logo class
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/includes
 */

class Marker_Logo_Manager {
    private static $table_name = 'novomap_marker_logo';
    private $db;

    /**
     * Marker_Logo_Manager constructor.
     *
     * @param $db
     * @since    1.0.0
     */
    public function __construct($db) {
        $this->set_db($db);
    }

    /**
     * create the marker logo db. Should be called on plugin activation
     *
     * @since 1.0.0
     */
    public function create() {
        $charset_collate = $this->db->get_charset_collate();
        $table_name = $this->db->prefix . 'novomap_marker_logo';

        $sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  url text NOT NULL,
		  width mediumint(9) NOT NULL,
		  height mediumint(9) NOT NULL,
		  anchor_x float(9) NOT NULL,
		  anchor_y float(9) NOT NULL,
		  status tinytext NOT NULL,
		  UNIQUE KEY id (id)
	    ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    /**
     * add Marker_logo in the db
     *
     * @param Marker_Logo $marker_logo
     * @return mixed
     * @since 1.0.0
     */
    public function add (Marker_Logo $marker_logo) {
        $this->db->insert(
            $this->db->prefix . self::$table_name,
            array(
                'time' => current_time( 'mysql' ),
                'url' => $marker_logo->url(),
                'width' => $marker_logo->width(),
                'height' => $marker_logo->height(),
                'anchor_x' => $marker_logo->anchor_x(),
                'anchor_y' => $marker_logo->anchor_y(),
                'status' => $marker_logo->status(),
            )
        );

        return $this->db->insert_id;
    }

    /**
     * Delete Marker Logo object from the database
     *
     * @param int $id
     * @since 1.0.0
     */
    public function delete($id) {
        $this->db->delete(
            $this->db->prefix . self::$table_name,
            array(
                'id' => $id
            )
        );
    }

    /**
     * Update data of a Marker Logo object
     *
     * @param Marker_Logo $marker_logo
     * @since 1.0.0
     */
    public function update(Marker_Logo $marker_logo) {
        $this->db->update(
            $this->db->prefix . self::$table_name,
            array(
                'url' => $marker_logo->url(),
                'width' => $marker_logo->width(),
                'height' => $marker_logo->height(),
                'anchor_x' => $marker_logo->anchor_x(),
                'anchor_y' => $marker_logo->anchor_y(),
                'status' => $marker_logo->status(),
            ),
            array('id'=>$marker_logo->id())
        );
    }

    /**
     * Get a specific Marker Logo object
     *
     * @param $id
     * @return Marker_Logo
     * @since 1.0.0
     */
    public function get($id) {
        $id = (int) $id;
        $table_name = $this->db->prefix . self::$table_name;

        $marker_logo = $this->db->get_row(
            "
            SELECT * 
            FROM ".$table_name." 
            WHERE id = $id
        ",
            ARRAY_A
        );

        return new Marker_logo($marker_logo);
    }

    /**
     * Get a list of all Marker Logo objects in an array
     *
     * @return array
     * @since 1.0.0
     */
    public function get_list() {
        $table_name = $this->db->prefix . self::$table_name;
        $marker_logo_list = array();

        $list = $this->db->get_results(
            "
            SELECT * 
            FROM ".$table_name."
        ",
            ARRAY_A
        );

        foreach ($list as $marker_logo){
            $marker_logo_list[$marker_logo['id']] = new Marker_logo($marker_logo);
        }

        return $marker_logo_list;
    }

    /**
     * Get a list of all Marker Logo objects in an array
     *
     * @param string $status
     * @return array
     * @since 1.0.0
     */
    public function get_list_status($status) {
        $table_name = $this->db->prefix . self::$table_name;
        $marker_logo_list = array();

        $list = $this->db->get_results($this->db->prepare(
            "
            SELECT * 
            FROM ".$table_name."
            WHERE status = %s",
            $status
        ),
            ARRAY_A
        );

        foreach ($list as $marker_logo){
            $marker_logo_list[$marker_logo['id']] = new Marker_logo($marker_logo);
        }

        return $marker_logo_list;
    }

    /**
     * Get a list of all Marker Logo objects in an array
     *
     * @param string $ids_list
     * @return array
     * @since 1.0.0
     */
    public function get_list_from_ids_list($ids_list) {
        $table_name = $this->db->prefix . self::$table_name;
        $marker_logo_list = array();
        $cache_id = implode($ids_list);
        if(!empty($ids_list)) {
            $list = $this->db->get_results($this->db->prepare(
                "
            SELECT * 
            FROM ".$table_name."
            WHERE id IN (".implode(', ', array_fill(0, count($ids_list), '%d')).")",
                $ids_list
            ),
                ARRAY_A
            );

            foreach ($list as $marker_logo){
                $marker_logo_list[$marker_logo['id']] = new Marker_logo($marker_logo);
            }
        }
        return $marker_logo_list;
    }

    /**
     * set the db on construct
     *
     * @param wpdb $db
     * @since 1.0.0
     */
    public function set_db(wpdb $db) {
        $this->db = $db;
    }
}