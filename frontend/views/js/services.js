/*!
 * SERVICIOS IMPLEMENTADOS CON API-FETCH.
 * Copyright 2021 - Alejandro Alberto Sánchez Iturriaga.
 */


//Se definen las principales constantes.
const URL_BASE = "http://localhost/stack/backend/";
const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJPbmxpbmUgSldUIEJ1aWxkZXIiLCJpYXQiOjE2MzE2NjgyMTcsImV4cCI6MTY2MzIwNDIxNywiYXVkIjoid3d3LmV4YW1wbGUuY29tIiwic3ViIjoianJvY2tldEBleGFtcGxlLmNvbSIsIkdpdmVuTmFtZSI6IkpvaG5ueSIsIlN1cm5hbWUiOiJSb2NrZXQiLCJFbWFpbCI6Impyb2NrZXRAZXhhbXBsZS5jb20iLCJSb2xlIjpbIk1hbmFnZXIiLCJQcm9qZWN0IEFkbWluaXN0cmF0b3IiXX0.7n_r0dP7f7hQyMf6kBlIch4F5vrmBS33FeRipP53HRg";
const headers = {
    "Content-type": "application/json",
    "Authorization": token
};

function obtenerCategorias() {
	const url = URL_BASE+"api/categorias";
	
	const response = fetch(url, {
		method: "GET",
		headers: headers
	});
	
	return response;
}

function obtenerProductos() {
	const url = URL_BASE+"api/productos";
	
	const response = fetch(url, {
		method: "GET",
		headers: headers
	});
	
	return response;
}

function obtenerProducto(id) {
	const url = URL_BASE+"api/producto/"+id;
	
	const response = fetch(url, {
		method: "GET",
		headers: headers
	});
	
	return response;
}

function crearProducto(producto) {
	const url = URL_BASE+"api/producto";
	const payload = JSON.stringify(producto);
	
	const response = fetch(url, {
		method: "POST",
		body: payload,
		headers: headers
	});
	
	return response;
}

function actualizarProducto(id, producto) {
	const url = URL_BASE+"api/producto/"+id;
	const payload = JSON.stringify(producto);
	
	const response = fetch(url, {
		method: "PUT",
		body: payload,
		headers: headers
	});
	
	return response;
}

function eliminarProducto(id) {
	const url = URL_BASE+"api/producto/"+id;
	
	const response = fetch(url, {
		method: "DELETE",
		headers: headers
	});
	
	return response;
}