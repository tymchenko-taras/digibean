<?php

return array(
	'url' => array(
		'test' => array(
			'fon' => 'it works',
		),
	),

	'system' => array(
		'errorController'	=> 'Base_ErrorController',
		'errorAction'		=> 'actionIndex',
	),

	'repositories' => array(
		'Content' => 'Base_ContentRepository',
	),

	'services' => array(
		'Error' => 'Base_ErrorService',
	),
	'validators' => array(
		'required' => 'Base_RequiredValidator',
		'string' => 'Base_StringValidator',
	),

);