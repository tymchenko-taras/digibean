<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 20.10.14
 * Time: 12:46
 * To change this template use File | Settings | File Templates.
 */


class IndexController extends CoreController{
	function actionIndex(){
		$this -> render('index');
	}
}