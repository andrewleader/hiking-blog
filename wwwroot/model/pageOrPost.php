<?php
	
require_once('postEntity.php');
	
class PageOrPost extends PostEntity {
	
	public function __construct($post) {
		parent::__construct($post);
	}
}
	
?>