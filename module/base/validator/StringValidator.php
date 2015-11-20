<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 08.11.14
 * Time: 21:37
 */
class Base_StringValidator extends Base_Validator{
    public $pattern = '';
    public $min = null;
    public $max = null;


    public function validate($value){
		$this -> errors = array();

        if($this -> min || $this -> max){
            $len = mb_strlen($value);
            $this -> errors[] = !is_null($this -> min) && ($this -> min > $len) ? 'min' : '';
            $this -> errors[] = !is_null($this -> max) && ($this -> max < $len) ? 'max' : '';
        }
        if ($this -> pattern){
            $this -> errors[] = preg_match($this -> pattern, $value) ? '' : 'pattern';
        }
		$this -> errors = array_filter($this -> errors);
		return empty($this -> errors);
    }
}