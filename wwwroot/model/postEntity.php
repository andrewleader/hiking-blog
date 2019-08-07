<?php
	
require_once('peak.php');
require_once('route.php');
require_once('fields.php');
require_once('plans.php');

abstract class PostEntity {
	public $post;
	private $fields;
	
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
	
	public function getFields() {
		if (!$this->fields) {
			$this->fields = Fields::get($this->post);
		}
		return $this->fields;
	}
	
	public static function get($post) {
		switch ($post->post_type) {
			case "peaks":
				return new Peak($post);
				
			case "routes":
				return new Route($post);
				
			case "plans":
				return new Plan($post);
				
			default:
				return null;
		}
	}
}	
	
?>