<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 21.10.14
 * Time: 15:54
 * To change this template use File | Settings | File Templates.
 */

class Derevbud_ErrorController extends Base_ErrorController{

	public function actionIndex(Exception $exception){
		echo $exception -> getCode();
		echo '<br>404';
	}

    public function errorHandler($exception){

        echo '<pre>';
		echo '<br>this is custom error handler<br>';
        print_r($exception);
    }
}