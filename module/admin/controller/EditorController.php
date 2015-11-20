<?php

class EditorController extends CoreController{

	function actionContentGet($model = null){
		if (is_null($model)){
			$model = Factory::model('ContentPage');
		}

		$this -> render('contentForm', array('model' => $model));
	}

	function actionContentPost(){
		$model = Factory::model('ContentPage');
		$model -> setFields($_POST);

		$this -> actionContentGet($model);
	}
}