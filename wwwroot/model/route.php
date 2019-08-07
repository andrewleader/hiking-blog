<?php
	
require_once('postEntity.php');
	
class Route extends PostEntity {
	private $plans; // Array of Plan
	private $reports; // Array of Report
	private $peak; // CachedItem<Peak>
	
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
	
	public function getPeak() {
		if (!$this->peak) {
			$this->peak = new CachedItem($this->getEntityFromField('peak'));
		}
		return $this->peak->value;
	}
	
	public function getThumbnailUrlNoCache($size = 'post-thumbnail') {
		$answer = parent::getThumbnailUrlNoCache($size);
		if ($answer) {
			return $answer;
		}
		$peak = $this->getPeak();
		if ($peak) {
			return $peak->getThumbnailUrl($size);
		}
		return false;
	}
}
	
?>