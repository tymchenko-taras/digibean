<?php

define('BEAN_PROJECT_DIR', realpath('../..'));
define('BEAN_LOG_START_TIME', microtime(1));

require BEAN_PROJECT_DIR .'/include/Initialization.php';
Initialization::setModules(array('Base', 'User', 'Admin'));

$app = System::app('Admin');
$app -> run();