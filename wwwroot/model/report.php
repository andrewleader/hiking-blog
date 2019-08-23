<?php
	
require_once('postEntity.php');
	
class Report extends PostEntity {
	private $destinations; // Array of Area or Route
	private $tripPlan; //CachedItem<Plan>
	
	public function __construct($post) {
		parent::__construct($post);
	}
	
	// Note that we do NOT inherit thumbnail, since trip report thumbnails should be of the actual trip
	
	public function getDestinations() {
		if (!$this->destinations) {
			$this->destinations = $this->getEntitiesFromField('destinations');
		}
		return $this->destinations;
	}
	
	public function getTripPlan() {
		if (!$this->tripPlan) {
			$this->tripPlan = new CachedItem($this->getEntityFromField('trip_plan'));
		}
		return $this->tripPlan->value;
	}
}
	
?>