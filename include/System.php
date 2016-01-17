<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 25.10.14
 * Time: 21:06
 */
class System {
    private static $cache = array();

    public static function app($name = null){
        if (empty(static::$cache[ 'application' ])){
            static::$cache[ 'application' ] = $name ? Factory::application($name.'_Application') : null;
        }

        return static::$cache[ 'application' ];
    }

	public static function isProduction(){
		return 0;
	}
}