<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'EximusCommerce',
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=status_symbol',
			'emulatePrepare'   => true,
			'username'         => 'root',
			'password'         => '',
			'charset'          => 'utf8',
		),
	),
);