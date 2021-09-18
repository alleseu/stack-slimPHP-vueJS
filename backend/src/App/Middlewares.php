<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;


/**
 * FUNCIÓN QUE VÁLIDA EL TOKEN DE AUTORIZACIÓN PARA UTILIZAR LOS ENDPOINTS DE LA API.
 *
 * @param  ServerRequest  $request PSR-7 request
 * @param  RequestHandler $handler PSR-15 request handler
 *
 * @return Response
 */
$beforeMiddleware = function (Request $request, RequestHandler $handler) {
	$server = $request->getServerParams();

	//Solo si el parámetro no está vacío.
	if (!empty($server['HTTP_AUTHORIZATION'])) {

		$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJPbmxpbmUgSldUIEJ1aWxkZXIiLCJpYXQiOjE2MzE2NjgyMTcsImV4cCI6MTY2MzIwNDIxNywiYXVkIjoid3d3LmV4YW1wbGUuY29tIiwic3ViIjoianJvY2tldEBleGFtcGxlLmNvbSIsIkdpdmVuTmFtZSI6IkpvaG5ueSIsIlN1cm5hbWUiOiJSb2NrZXQiLCJFbWFpbCI6Impyb2NrZXRAZXhhbXBsZS5jb20iLCJSb2xlIjpbIk1hbmFnZXIiLCJQcm9qZWN0IEFkbWluaXN0cmF0b3IiXX0.7n_r0dP7f7hQyMf6kBlIch4F5vrmBS33FeRipP53HRg';

		//VÁLIDA EL TOKEN DE AUTORIZACIÓN.
		if ($token === $server['HTTP_AUTHORIZATION']) {

			$response = $handler->handle($request);
			return $response;
		}
		else {

			$codigo_http = 403;  //Código de estado de respuesta HTTP, Forbidden.
			$respuesta['mensaje'] = 'Acceso denegado. Token inválido.';

			$response = new Response();
			$response->getBody()->write(json_encode($respuesta));
			return $response
				->withHeader('content-type', 'application/json')
				->withStatus($codigo_http);
		}
	}
	else {

		$codigo_http = 401;  //Código de estado de respuesta HTTP, Unauthorized.
		$respuesta['mensaje'] = 'Token nulo. Falta token de autorización.';

		$response = new Response();
		$response->getBody()->write(json_encode($respuesta));
		return $response
			->withHeader('content-type', 'application/json')
			->withStatus($codigo_http);
	}
};
