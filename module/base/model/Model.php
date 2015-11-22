<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 07.11.14
 * Time: 17:15
 * To change this template use File | Settings | File Templates.
 */
class Base_Model{
    protected $errors = array();
    protected $fields = null;

	public function __get($name){
		throw new Exception('Unknown property');
	}

    public function __construct(){
        $this -> getFieldNames();
    }

    public function rules(){
		return array();
	}

    public function validate(){
		foreach($this -> fields as $field){
			$this -> validateField($field);
		}

		foreach($this -> errors as $errors){
			if (!empty($errors)) return false;
		}

		return true;
    }

	protected function getValidator($validator){
		$result = null;
		try {
			$method = new ReflectionMethod($this, $validator);
			if ($method -> isPublic()){
				$result = $validator;
			}

		} catch(Exception $e){}

		if (empty($method)){
			$result = Factory::validator($validator);
		}
		return $result;
	}


	protected function validateField($field){
		$rules = $this -> rules();
		if (!empty($rules[ $field ])){
			foreach($rules[ $field ] as $validatorName => $params){
				$validator = $this -> getValidator($validatorName);
				if(is_object($validator)){
					$validator -> setParams($params);
					$validator -> validate($this -> $field);
					$this -> setErrors($field, $validator -> getErrors());
				} elseif(is_string($validator)) {
					$this -> $validator($field);
				} else {
					throw new Exception('Couldn\'t find validation rule for field `'. $field .'`');
				}
			}
		}
	}

	public function setErrors($field, $errors){
		$errors = is_array($errors) ? $errors : array($errors);
		if (empty($this -> errors[ $field ])){
			$this -> errors[ $field ] = $errors;
		} else {
			$this -> errors[ $field ] = array_merge($this -> errors[ $field ], $errors);
		}
	}

    public function getErrors(){
		return $this -> errors;
	}

    public function setFields(array $fields){
        foreach($fields as $name => $value){
            if (!in_array($name, $this -> fields )){
				trigger_error('Can not find property `'. $name .'` in model `'. get_class($this) .'`');
			}
			$this -> $name = $value;
		}
    }

    public function clearFields(){
		// TODO: set all fields to default values and clear all fields before setFields
	}

    public function getFields(){
        $result = array();
        foreach($this -> fields as $name){
            $result[ $name ] = $this -> $name;
        }
        return $result;
    }


    protected function getFieldNames(){
        if (is_null($this -> fields)){
            $this -> fields = array();
            $ref = new ReflectionClass($this);
            foreach($ref->getProperties(ReflectionProperty::IS_PUBLIC) as $obj){
                $this -> fields[] = $obj -> name;
            }
        }
        return $this -> fields;
    }
}