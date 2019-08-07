<?php
	
class Plan extends PostEntity {
	private $destinations; // Array of Peak or Route
	private $reports; // Array of Report
	
	public function __construct($post) {
		parent::__construct($post);
	}
	
	public function getReports() {
		if (!$this->reports) {
			$this->reports = array();
		
			foreach($this->getChildPosts('reports', 'trip_plan') as $reportPost) {
				$this->reports[] = new Report($reportPost);
			}
		}
		return $this->reports;
	}
	
	public function getDestinations() {
		if (!$this->destinations) {
			$this->destinations = $this->getEntitiesFromField('destinations');
		}
		return $this->destinations;
	}
	
	public function getThumbnailUrlNoCache($size = 'post-thumbnail') {
		$answer = parent::getThumbnailUrlNoCache($size);
		if ($answer) {
			return $answer;
		}
		foreach ($this->getDestinations() as $destination) {
			$answer = $destination->getThumbnailUrl($size);
			if ($answer) {
				return $answer;
			}
		}
		return false;
	}
}
	
?>