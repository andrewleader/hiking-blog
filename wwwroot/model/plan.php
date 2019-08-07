<?php
	
class Plan extends PostEntity {
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
}
	
?>