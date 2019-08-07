<?php
	
require_once('peak.php');
require_once('route.php');
require_once('fields.php');
require_once('plan.php');
require_once('report.php');

class CachedItem {
	public $value;
	
	public function __construct($value) {
		$this->value = $value;
	}
}

abstract class PostEntity {
	public $post;
	private $fields;
	private $thumbnails; // Array<string, string>
	
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
	
	protected function getEntitiesFromField($field) {
		$parentIds = $this->getPostMeta($field);
		$answer = array();
		if ($parentIds) {
			foreach ($parentIds as $id) {
				$answer[] = PostEntity::get(get_post($id));
			}
		}
		return $answer;
	}
	
	protected function getEntityFromField($field) {
		$parentId = $this->getPostMeta($field);
		if ($parentId) {
			return PostEntity::get(get_post($parentId));
		}
		return null;
	}
	
	protected function getPostMeta($key) {
		$answer = get_post_meta($this->post->ID, $key, true);
		if (is_array($answer) || strlen($answer) > 0) {
			return $answer;
		}
		return false;
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
	
	// Returns string or false
	public function getThumbnailUrl($size = 'post-thumbnail') {
		if (!$this->thumbnails || !array_key_exists($size, $this->thumbnails)) {
			if (!$this->thumbnails) {
				$this->thumbnails = array();
			}
			$this->thumbnails[$size] = $this->getThumbnailUrlNoCache($size);
		}
		return $this->thumbnails[$size];
	}
	
	protected function getThumbnailUrlNoCache($size = 'post-thumbnail') {
		return get_the_post_thumbnail_url($this->post, $size);
	}
	
	// Title for the list view
	public function getListTitle() {
		return $this->post->post_title;
	}
	
	// Title for when displayed as a child of a parent
	public function getChildListTitle() {
		return $this->post->post_title;
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