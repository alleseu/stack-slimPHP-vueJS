<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;


$container->set('logger_files', function() {

	//El formato de fecha predeterminada es: "Y-m-d\TH:i:sP".
	$dateFormat = "Y-m-d H:i:s";

	//El formato de salida predeterminado es: "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n".
	$output = "[%datetime%] %level_name% %message% %context% %extra%\n\n";

	//Definición del directorio y nombre de archivo del registrador.
	$directory = __DIR__ . '/../../log/';
	$file = date('Y-m-d') . '.log';

	//Crea el formato.
	$formatter = new LineFormatter($output, $dateFormat, true, true);

	//Crea el manipulador. Registra registros en cualquier secuencia PHP, use esto para archivos de registro.
	$stream = new StreamHandler($directory.$file, Logger::WARNING);
	$stream->setFormatter($formatter);

	//Crea el objeto registrador con el nombre de canal: "files".
	$logger = new Logger('files');
	$logger->pushHandler($stream);

	return $logger;
});