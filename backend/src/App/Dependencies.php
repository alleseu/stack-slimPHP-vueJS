<?php

use Psr\Container\ContainerInterface;

$container->set('db', function(ContainerInterface $c) {

	$config = $c->get('database')->default;
	
	$DB_HOST = $config['DB_HOST'];
	$DB_NAME = $config['DB_NAME'];
	$DB_USER = $config['DB_USER'];
	$DB_PASSWORD = $config['DB_PASS'];
	$DB_CHARSET = $config['DB_CHAR'];

	$DSN = "mysql:host=". $DB_HOST .";dbname=". $DB_NAME .";charset=". $DB_CHARSET;
	
	$options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
	];

	return new PDO($DSN, $DB_USER, $DB_PASSWORD, $options);
});