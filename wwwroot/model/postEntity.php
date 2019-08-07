<?php
	
require_once('peak.php');
require_once('route.php');

abstract class PostEntity {
	public $post;
	
	public function __construct($post) {
		$this->post = $post;
	}
	
	protected function getChildPosts($childPostType, $childField) {
		// https://www.advancedcustomfields.com/resources/querying-relationship-fields/
		$answer = get_posts(array(
			'post_type' => $childPostType,
			'numberposts' => 100,
			'meta_query' => array(
				array(
					'key' => $childField,
					'value' => $this->post->ID
				)
			)
		));
		
		if ($answer) {
			return $answer;
		} else {
			return array();
		}
	}
	
	public static function get($post) {
		switch ($post->post_type) {
			case "peaks":
				return new Peak($post);
				
			case "routes":
				return new Route($post);
				
			default:
				return null;
		}
	}
}	
	
?>