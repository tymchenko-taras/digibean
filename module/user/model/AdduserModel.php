<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 07.11.14
 * Time: 17:19
 * To change this template use File | Settings | File Templates.
 */

class User_AdduserModel extends Base_Model{
	public $name = null;

	public function rules(){
		return array(
			'name' => array('string' =>  array('min' => 3)),
		);
	}

}