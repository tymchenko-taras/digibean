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
			'product/<\d+>' => 'derevbud/index/product',
			'base' => 'base/site/index',
		)
    ),

    'system' => array(
        'errorController'	=> 'Derevbud_ErrorController',
    ),

    'repositories' => array(
		'User' => 'User_UserRepository',
    ),
);