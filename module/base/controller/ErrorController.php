<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 21.10.14
 * Time: 15:54
 * To change this template use File | Settings | File Templates.
 */

class Base_ErrorController extends Base_Controller{

	public function actionIndex(Exception $exception){
		switch($exception -> getMessage()){
			case '404':
				$this -> action404($exception);
				break;
			default:
				$this -> actionSomeError($exception);
		}
		echo 'this is base error controller';
	}

	protected function action404($exception){
		echo '404';
	}

	protected function actionSomeError($exception){
		echo 'some error ';
	}
}