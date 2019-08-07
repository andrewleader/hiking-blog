<?php
	
class Route extends PostEntity {
	private $plans; // Array of Plan
	
	public function __construct($post) {
		parent::__construct($post);
	}
	
	public function getPlans() {
		if (!$this->plans) {
			$this->plans = array();
		
			foreach($this->getChildPostsWithManyRelationship('plans', 'destinations') as $planPost) {
				$this->plans[] = new Plan($planPost);
			}
		}
		return $this->plans;
	}
}
	
?>