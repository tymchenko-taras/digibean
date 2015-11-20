<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 07.11.14
 * Time: 15:54
 * To change this template use File | Settings | File Templates.
 */
class Util {

	public static function splitByCamel($string){
		return array_filter(preg_split('/(?=[A-Z])/', $string));
	}

    public static function arrayExtend($a, $b) {
        foreach($b as $k=>$v){
            if(is_integer($k)){
                $a[]=$v;
            } else if (is_array($v) && isset($a[$k]) && is_array($a[$k])){
                $a[$k]=self::arrayExtend($a[$k],$v);
            } else {
                $a[$k]=$v;
            }
        }
        return $a;
    }
}