<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 29.10.14
 * Time: 15:49
 * To change this template use File | Settings | File Templates.
 */
class UrlUtil {
	public static function getCurrent(){
		return $_SERVER['REQUEST_URI'];
	}

	/**
	 * return just url - without prams
	 * @param $url
	 * @return string
	 */
	public static function getUrlPath($url){
		$uri = explode('?', $url);
		$path = trim($uri[0], '/');
		return $path;
	}

	/**
	 * return get params - all after question mark as array
	 * @param $url string
	 * @return array
	 */
	public static function getUrlParams($url){
		$uri = explode('?', $url);
		$params = explode('&', empty($uri[1]) ? '' : $uri[1]);
		return $params;
	}

	public static function getRouteByUrl($url){

	}

	public static function parse($url){
		$result = false;
		$data = parse_url($url);
		if ($data !== false){
			$pattern = array(
				'scheme' => '',
				'host' => '',
				'user' => '',
				'pass' => '',
				'path' => '',		// url
				'query' => '',		// after ?
				'fragment' => ''	// after #
			);
			$result = array_merge($pattern, $data);
		}
		return $result;
	}
}