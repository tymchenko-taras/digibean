<?php
class Object {

	public function __set($name, $value){
		$setter = 'set'.ucfirst($name);
		if (method_exists($this, $setter)){
			$this -> $setter($value);
		}
	}

	public function __get($name){
		$getter = 'get'.ucfirst($name);
		if (method_exists($this, $getter)){
			return $this -> $getter();
		} else {
			throw new Exception('Property `'. $name .'` couldnt be found in object of class `'. get_class($this) .'`' );
		}
	}
}