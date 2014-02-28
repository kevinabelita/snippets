<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'type'		  => 'mysqli',
		'connection'  => array(
			'hostname'   => 'localhost',
			'username'   => 'root',
			'password'   => '',
			'database'   => 'test',
			'port'		 => '3306',
		),
		'profiling'      => true,
	),
);
