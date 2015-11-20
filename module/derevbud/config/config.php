<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 25.10.14
 * Time: 20:27
 */
return array(
    'url' => array(
		'someParam' => 'paramName',
		'routes' => array(
			'/' => 'derevbud/index/index',
			'site' => 'derevbud/index/index',
			'base' => 'base/site/index',
		)
    ),

    'repositories' => array(
		'User' => System::isProduction() ? 'Derevbud_UserRepository' : 'User_UserRepository',
    ),
);