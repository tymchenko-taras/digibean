<?php
class Base_Application {
	protected $moduleName = '';
	protected $controllerName = '';
	protected $actionName = '';
	protected $controllerInstance = null;

	protected $params = array();

	public function getModule(){
		return $this -> module;
	}

	protected function getUrl(){
		$temp = UrlUtil::parse($_SERVER['REQUEST_URI']);
		return $temp['path'];
	}

	protected function getRouteByUrl($url){
		return System::config(array('url', 'routes', $url));
	}

	protected function getMcaByRoute($route){
		// MCA = module/controller/action
		$path = explode('/', $route);
		if (count($path) == 3){
			$this -> moduleName		= ucfirst($path[0]);
			$this -> controllerName	= $this -> moduleName .'_'. ucfirst($path[1]) .'Controller';
			$this -> actionName		= 'action'. ucfirst($path[2]);
		}
	}

	protected function parseUrl(){
		// TODO rename and pretty urls
		$this -> getMcaByRoute(
			$this -> getRouteByUrl(
				$this -> getUrl()
			)
		);
	}

	public function getController(){
		return Factory::controller($this -> controllerName);
	}

	public function run(){
		$this -> parseUrl();
		call_user_func_array(array($this -> getController(), $this -> actionName), $this -> params);
	}
}