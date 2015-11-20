<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 25.10.14
 * Time: 21:06
 */
class System {
    private static $cache = array();
    private static $modules = array();
    private static $config = null;

    public static function modules($modules = null){
        if (is_null($modules)){
            return static::$modules;
        } else {
            static::$modules = $modules;
        }
    }

    public static function config($path = array(), $default = null){
		$result = static::$config;
		if (is_null ($result)){
            foreach(System::modules() as $module){
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

    public static function Exception(Exception $e){
        ob_end_clean();
		echo '<pre>';
		echo $e -> getMessage(), '<br>';
		echo $e -> getTraceAsString(), '<br>';
		echo '----------------<br>';
		$controller = new Derevbud_ErrorController();
        // TODO: carry controller name, action and module name to config,
        // it allows us configure controller of which module will be used
        // $controller = static::app() -> getController('ErrorController');
         call_user_func_array(array($controller, 'errorHandler'), array($e));
    }

    public static function app($name = null){
        if (empty(static::$cache[ 'application' ])){
            if (is_null($name)){
                throw new Exception('Couldnt create app');
            }
            static::$cache[ 'application' ] = Factory::application($name.'_Application');
        }
        return static::$cache[ 'application' ];
    }

	public static function isProduction(){
		return 1;
	}
}