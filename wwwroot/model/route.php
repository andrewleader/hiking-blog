<?php
	
require_once('postEntity.php');
	
class Route extends PostEntity {
	private $plans; // Array of Plan
	private $reports; // Array of Report
	private $parent; // CachedItem<Area>
	
	public function __construct($post) {
		parent::__construct($post);
	}
	
	public function getPlans() {
		if (!$this->plans) {
			$this->plans = array();
		
			foreach ($this->getChildPostsWithManyRelationship('plans', 'destinations') as $planPost) {
				$this->plans[] = new Plan($planPost);
			}
		}
		return $this->plans;
	}
	
	public function getReports() {
		if (!$this->reports) {
			$this->reports = array();
		
			foreach ($this->getChildPostsWithManyRelationship('reports', 'destinations') as $reportPost) {
				$this->reports[] = new Report($reportPost);
			}
			
			foreach ($this->getPlans() as $plan) {
				$this->addEntitiesIfNotExists($this->reports, $plan->getReports());
			}
		}
		return $this->reports;
	}
	
	public function getArea() {
		if (!$this->area) {
			$this->area = new CachedItem($this->getEntityFromField('parent'));
		}
		return $this->area->value;
	}
	
	public function getThumbnailUrlNoCache($size = 'post-thumbnail') {
		$answer = parent::getThumbnailUrlNoCache($size);
		if ($answer) {
			return $answer;
		}
		$area = $this->getArea();
		if ($area) {
			return $area->getThumbnailUrl($size);
		}
		return false;
	}
	
	// Title for the list view
	public function getListTitle() {
		$area = $this->getArea();
		if ($area) {
			return $area->post->post_title . ' - ' . $this->post->post_title;
		}
		return $this->post->post_title;
	}
}
	
?>