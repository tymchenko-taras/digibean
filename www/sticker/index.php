<?php

//$time = microtime(1);
//// change the following paths if necessary
//$yii=dirname(__FILE__).'/../../framework/yii.php';
//$config=dirname(__FILE__).'/../../sticker/config/main.php';
//
//
//require_once($yii);
//Yii::createWebApplication($config)->run();
//
//echo 'time - '.(microtime(1) - $time);

define('BEAN_PROJECT_DIR', '../..');

require BEAN_PROJECT_DIR .'/include/Initialization.php';
Initialization::loader('CoreController');
exit;


error_reporting(E_ALL);
$app = Factory::application('Derevbud');
$app -> run();
