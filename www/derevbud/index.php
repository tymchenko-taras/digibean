<?php

define('BEAN_PROJECT_DIR', realpath('../..'));
define('BEAN_DOCUMENT_ROOT', $_SERVER["DOCUMENT_ROOT"]);
define('BEAN_LOG_START_TIME', microtime(1));

require BEAN_PROJECT_DIR .'/include/Initialization.php';

System::modules(array(
    'Base',
    'User',
    'Derevbud',
));

System::app('Derevbud') -> run();