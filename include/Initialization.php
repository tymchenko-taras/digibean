<?php
require_once BEAN_PROJECT_DIR . '/include/Object.php';
require_once BEAN_PROJECT_DIR . '/include/Config.php';
require_once BEAN_PROJECT_DIR . '/include/System.php';
require_once BEAN_PROJECT_DIR . '/include/Factory.php';

class Initialization {

    public static function loader($name){
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

	public static function errorHandler($number, $string, $file, $line, array $context) {
		$string .= ' in file ' . $file . ':' . $line;
		Factory::service('Error') -> handle(new Exception($string, $number));
	}
}

set_error_handler('Initialization::errorHandler');
spl_autoload_register('Initialization::loader');
























