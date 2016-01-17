<?php
class Base_Application {
	protected $moduleName = '';
	protected $controllerName = '';
	protected $actionName = '';
	protected $controllerInstance = null;
    // List of modules required for work(should be overridden in your endpoint module )
	protected $modules = array();
    protected static $config = null;

	protected $params = array();

    public function config($path = array(), $default = null){
        $result = static::$config;
        if (is_null ($result)){
            foreach($this -> modules as $module){
                $result = Util::arrayExtend(
                    $result,
                    require BEAN_PROJECT_DIR .'/module/'. strtolower($module) . '/config/config.php'
                );
            }
            static::$config = $result;
        }

        if (!empty($path)){
            $result = static::$config;
            foreach($path as $key){
                if (!empty($result[ $key ])){
                    $result = $result[ $key ];
                } else {
                    $result = $default;
                    break;
                }
            }
        }

        return $result;
    }

	protected function getCurrentUrl(){
		$temp = UrlUtil::parse($_SERVER['REQUEST_URI']);
		return $temp['path'];
	}

	protected function getUglyByPretty($pretty){
		return $pretty;
	}

	protected function getRouteByUgly($ugly){
		$ugly = trim($ugly, '/');
		$result = $ugly;
		$urls = $this -> config(array('url', 'routes'), array());

		if(!empty($urls[ $ugly ])){
			$result = $urls[ $ugly ];
		} else {
			$ulyParts = explode('/', $ugly);
			$uglyCount = count($ulyParts);
			foreach($urls as $item => $route){
				if( strpos($item, '<') !== false ){
					$itemParts = explode('/', trim($item, '/'));
					if (count($itemParts) != $uglyCount) continue;

					$matched = false;
					$params = array();
					foreach($itemParts as $i => $part){
						if(strpos($part, '<') !== false){
							$part = '#^'. trim($part, '><') .'$#';
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
			throw new Exception('Controller could not be found');
		}
		if (!$this -> actionName){
			throw new Exception('Action could not be found');
		}

		return Factory::controller($this -> controllerName);
	}

	public function run(){
		$this -> parseUrl();
		call_user_func_array(array($this -> getController(), $this -> actionName), $this -> params);
	}
}