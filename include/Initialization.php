<?php
require_once BEAN_PROJECT_DIR . '/include/Object.php';
require_once BEAN_PROJECT_DIR . '/include/Config.php';
require_once BEAN_PROJECT_DIR . '/include/System.php';
require_once BEAN_PROJECT_DIR . '/include/Factory.php';

class Initialization {


    public static function loader3($name){
		$words	= array_filter(preg_split('/(?=[A-Z])/', $name));
		$parts	= explode('_', $name);
		$id		= end($words);
		$file	= array_pop($parts);
		$result	= BEAN_PROJECT_DIR . '/';

		if ( in_array($id, array('Model', 'Service', 'Controller', 'Repository', 'Application', 'Validator')) ){
			$result .= 'module/'.strtolower(reset($parts)) .'/'. strtolower($id) .'/'. $file;
		}
		elseif ( in_array($id, array('Util', 'Entity', 'Dependency')) ){
			$result .= implode('/', array_filter(array('include', 'class', strtolower($id), strtolower(implode('/', $parts)), $file)));
		}

		require_once $result . '.php';
	}

    public static function loader2($name){
		$parts = array_filter(preg_split('/(?=[A-Z])/', $name));

		if ( in_array(end($parts), array('Model', 'Service', 'Controller', 'Repository')) ){
			$file = implode('/', explode('_', strtolower($name)));
		}
		elseif ( in_array(reset($parts), array('Util', 'Entity', 'Validator', 'Core', 'Factory', 'Dependency')) ){
			$file = 'include/class/'.strtolower(reset($parts)) .'/'. $name;
		}
		elseif ( in_array(reset($parts), array('Core', 'Factory')) ){
			$file = 'include/'. $name;
		}

	}

    public static function loader($name){
        $arr = array_filter(preg_split('/(?=[A-Z])/', $name));
		$id = array_shift($arr);
        $file = BEAN_PROJECT_DIR . '/';

		switch($id){
			case in_array($id, System::modules()):
				$module = strtolower($id);
				$type = strtolower(end($arr));
				$file .= implode(DIRECTORY_SEPARATOR, array_filter(array('module', $module, $type, implode($arr))));
				break;
			case 'Core':
			case 'Factory':
				$file .= 'include/'. $name;
				break;

			case 'Util':
				$file .= 'include/util/'. $name;
				break;
		}
		switch (end($arr)){
			case 'Validator':
				$file .= 'include/class/validator/'. $name;
				break;
			case 'Entity':
				$file .= 'include/class/entity/'. $name;
				break;
		}

        if (is_file($file .= '.php')){
            require_once $file;
        } else {
            return false;
        }
    }

	public static function errorHandler($number, $string, $file, $line, array $context) {
		if (0 === error_reporting()) {
			return false;
		}

        System::Exception(new Exception($string));
		exit;
	}
}

set_error_handler('Initialization::errorHandler');
spl_autoload_register('Initialization::loader3');