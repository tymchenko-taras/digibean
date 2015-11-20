<?php

class ScssUtil {
	static protected $compiler = null;
	static protected $version = 1;
	static protected $destination = '/styles/css/';

	public static function register(array $scripts, $compress = false){
		$name = BEAN_DOCUMENT_ROOT . static::$destination . static::$version . '.css';
		if ($compress && file_exists( $name )){
			echo static::wrapStyleName($name);
			return;
		}

		$result = array();
		foreach($scripts as $script){
			$result[ $script ] = file_get_contents(BEAN_DOCUMENT_ROOT . $script);
		}

		if ($compress){
			$result = array('/styles/scss/'. static::$version .'.scss' => implode(' ', $result));
		}

		foreach($result as $path => $script){
			$name = preg_replace('#scss#', 'css', $path, 2);
			file_put_contents( BEAN_DOCUMENT_ROOT . $name, static::getCompiler() -> compile($script) );
			echo static::wrapStyleName($name);
		}
	}

	public static function wrapStyleName($name){
		return '<link rel="stylesheet" href="'. $name .'"/>'.PHP_EOL;
	}

	public static function getCompiler(){
		if (is_null(static::$compiler)){
			require BEAN_PROJECT_DIR ."/include/manual/scss.inc.php";
			$scss = new scssc();
			$scss -> setFormatter("scss_formatter_compressed");
			static::$compiler = $scss;
		}
		return static::$compiler;

	}
}
