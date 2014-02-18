<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'type'		  => 'mysql',
		'connection'  => array(
			'dsn'        => 'mysql:host=localhost;dbname=fuel_dev',
			'hostname'   => 'localhost',
			'username'   => 'root',
			'password'   => '',
			'database'   => 'test',
			'port'		 => '3306',
		),
		'profiling'      => true,
	),
);
