<?php

$container->set('database', function() {
	return (object) [
		'default' => [
			"DB_HOST" => 'localhost',
			"DB_NAME" => 'crud',
			"DB_USER" => 'root',
			"DB_PASS" => '',
			"DB_CHAR" => 'utf8'
		]
	];
});