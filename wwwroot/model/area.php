<?php
	
require_once('postEntity.php');
	
class Area extends PostEntity {
	private $routes; // Array of Route
	private $plans;
	
	public function __construct($post) {
		parent::__construct($post);
	}

	// Returns array of posts, or null if none
	public function getRoutes() {
		
		if (!$this->routes) {
			$this->routes = array();
		
			foreach($this->getChildPosts('routes', 'parent') as $routePost) {
				$this->routes[] = new Route($routePost);
			}
		}
		
		return $this->routes;
	}

	public function getPlans() {
		if (!$this->plans) {
			$this->plans = array();
		
			foreach($this->getChildPostsWithManyRelationship('plans', 'destinations') as $planPost) {
				$this->plans[] = new Plan($planPost);
			}
			
			foreach($this->getRoutes() as $route) {
				$this->addEntitiesIfNotExists($this->plans, $route->getPlans());
			}
		}
		return $this->plans;
	}
}
	
?>