<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 22.10.14
 * Time: 13:51
 * To change this template use File | Settings | File Templates.
 */

class Factory{
    private static $cache = array();

	protected static function get($name, $type = null){

        if (empty(static::$cache[ $type ][ $name ])){
			if (!$class = System::config(array($type, $name))){
				$class = $name;
			}

			static::$cache[ $type ][ $name ] = new $class;
		}
		return static::$cache[ $type ][ $name ];
	}

	public static function application($name){
		return static::get( $name, 'application' );
	}

	public static function controller($name){
		return static::get( $name );
	}

	public static function repository($name){
		return static::get( $name, 'repositories');
	}

    public static function service($name){
		return static::get( $name, 'services');
	}

    public static function model($name){
		return static::get( $name, 'models');
	}

	public static function validator($name){
		return static::get( $name, 'validators');
	}

    public static function entity($name){
		return static::get( $name, 'entity');
	}

}