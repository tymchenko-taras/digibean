<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 08.11.14
 * Time: 21:30
 */
class Base_Validator{
    protected $errors = array();

    public function validate($value){

    }

	public function getErrors(){
		return $this -> errors;
    }

	public function __construct($params = null){
		if (!is_null($params)){
			$this -> setParams($params);
		}
	}

	public function setParams($params){
		foreach($params as $key => $value){

			if (property_exists($this, $key)){
				$this -> $key = $value;
			} else {
				throw new Exception('Unknown param `'. $key .'` for validator `'. get_class($this) .'`');
			}
		}
	}

}