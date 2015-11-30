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

	protected function getCurrentUrl(){
		$temp = UrlUtil::parse($_SERVER['REQUEST_URI']);
		return $temp['path'];
	}

	protected function getUglyByPretty($pretty){
		return $pretty;
	}

	protected function getRouteByUgly($ugly){

		$result = null;
		$urls = System::config(array('url', 'routes'), array());
		if(!empty($urls[ $ugly ])){
			$result = $urls[ $ugly ];
		}

		if (!$result){
			$ulyParts = explode('/', trim($ugly, '/'));
			$uglyCount = count($ulyParts);
			foreach($urls as $item => $route){
				if( strpos($item, '<') !== false ){
					$itemParts = explode('/', trim($item, '/'));
					if (count($itemParts) != $uglyCount) continue;

					$matched = false;
					$params = array();
					foreach($itemParts as $i => $part){
						if(strpos($part, '<') !== false){
							$part = '#'. trim($part, '><') .'#';
							if($matched = preg_match($part, $ulyParts[ $i ])){ // TODO test it, maybe need to add trim($part, '<>')
								$params[] = $ulyParts[ $i ];
							} else {
								break;
							}
						} else {
							if ($matched = ($part == $ulyParts[ $i ])){

							} else {
								break;
							}
						}
					}
					if ($matched){
						$this -> params = $params;
						$result = $route;
						break;
					}
				}
			}
		}

		return $result;
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
			$this -> getRouteByUgly(
				$this -> getUglyByPretty(
					$this -> getCurrentUrl()
				)
			)
		);
	}

	public function getController(){
		if(!$this -> controllerName){
			throw new Exception(404);
		}
		if (!$this -> actionName){
			throw new Exception();
		}

		return Factory::controller($this -> controllerName);
	}

	public function run(){
		$this -> parseUrl();
		call_user_func_array(array($this -> getController(), $this -> actionName), $this -> params);
	}
}