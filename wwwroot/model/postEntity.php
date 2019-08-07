<?php
	
require_once('peak.php');
require_once('route.php');
require_once('fields.php');
require_once('plan.php');
require_once('report.php');

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
	
	protected function getChildPostsWithManyRelationship($childPostType, $childField) {
		$answer = get_posts(array(
			'post_type' => $childPostType,
			'numberposts' => 100,
			'meta_query' => array(
				array(
					'key' => $childField,
					'value' => $this->post->ID,
					'compare' => 'LIKE'
				)
			)
		));
		
		if ($answer) {
			return $answer;
		} else {
			return array();
		}
	}
	
	protected function addEntitiesIfNotExists($array, $entities) {
		foreach ($entities as $entity) {
			$this->addEntityIfNotExists($array, $entity);
		}
	}
	
	protected function addEntityIfNotExists($array, $entity) {
		foreach ($array as $existing) {
			if ($existing->post->ID == $entity->post->ID) {
				return;
			}
		}
		
		$array[] = $entity;
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
				
			case "reports":
				return new Report($post);
				
			default:
				echo "Unknown type " . $post->post_type;
				return null;
		}
	}
}	
	
?>