<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 07.11.14
 * Time: 17:19
 * To change this template use File | Settings | File Templates.
 */

class Derevbud_AdduserModel extends User_AdduserModel{

    public $name = 'lala';

	public function rules(){
		return array(
			'name' => array('string' => array('max' => 3, 'min' => 2)),
		);
	}
}