<?php

return array(
	'url' => array(
		'test' => array(
			'fon' => 'it works',
		),
	),

	'repositories' => array(
		'Content' => 'Base_ContentRepository',
	),

	'validators' => array(
		'required' => 'Base_RequiredValidator',
		'string' => 'Base_StringValidator',
	),

);