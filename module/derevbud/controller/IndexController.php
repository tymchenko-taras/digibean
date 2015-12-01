<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 20.10.14
 * Time: 12:46
 * To change this template use File | Settings | File Templates.
 */


class Derevbud_IndexController extends Base_Controller{
	function actionIndex(){
        $model = Factory::model('AddUser');
        $model -> setFields(array('name' => 'S7'));

		$res = $model -> validate();
		print_r($model -> getErrors());


		$this -> title = 'lalalla';
		$test = Factory::repository('Content') -> getContent('9999');
		$this -> render('user', array(
            'test' => $test,
            'model'=> $model,
        ));
	}

	public function actionProduct($productId = ''){
		echo 'hello, this product action for product `'. $productId .'`';
	}
}