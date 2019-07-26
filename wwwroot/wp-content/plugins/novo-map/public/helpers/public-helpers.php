<?php
/**
 * The public-specific helpers functions
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/public
 * @author     novo-media <contact@novo-media.ch>
 */

/**
 * remove everything but text and numbers in a string
 *
 * @since   1.0.0
 * @param   $string
 * @return  mixed
 */
function alphanumeric_string($string) {
    $string = preg_replace('/[^\w]/', '', $string);
    return $string;
}

/**
 * get a list of all marker logo ids that are necessary to build a map script
 *
 * @since   1.0.0
 * @param   $gmap
 * @param   $markers
 * @return  array
 */
function get_marker_logo_ids_from_map_marker($gmap, $markers) {
    $marker_logo_id_list = array();
    if($gmap->pin_clustering()) {
        if(!in_array((int)$gmap->clustering_marker_logo_id_small(), $marker_logo_id_list)){
            $marker_logo_id_list[]=(int)$gmap->clustering_marker_logo_id_small();
        }
        if(!in_array((int)$gmap->clustering_marker_logo_id_medium(), $marker_logo_id_list)){
            $marker_logo_id_list[]=(int)$gmap->clustering_marker_logo_id_medium();
        }
        if(!in_array((int)$gmap->clustering_marker_logo_id_big(), $marker_logo_id_list)){
            $marker_logo_id_list[]=(int)$gmap->clustering_marker_logo_id_big();
        }
    }
    if($gmap->additional_marker()) {
        $marker_logo_id_list[]=(int)$gmap->additional_marker_logo_id();
    }
    foreach ($markers as $marker) {
        if(!in_array((int)$marker->marker_logo_id(), $marker_logo_id_list)){
            $marker_logo_id_list[]=(int)$marker->marker_logo_id();
        }
    }
    return $marker_logo_id_list;
}

/**
 * generate random string
 * @param int $length
 * @return string
 */
function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    return $random_string;
}