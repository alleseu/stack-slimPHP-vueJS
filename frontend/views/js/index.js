/*!
 * INDEX.
 * Copyright 2021 - Alejandro Alberto Sánchez Iturriaga.
 */


//Se definen las constantes para cada modal.
const opciones = {
	backdrop: 'static',
	keyboard: false,
	focus: true
};
const modal1 = new bootstrap.Modal(document.getElementById('modal1'), opciones);
const modal2 = new bootstrap.Modal(document.getElementById('modal2'), opciones);
const modal3 = new bootstrap.Modal(document.getElementById('modal3'), opciones);

//Se definen las variables para cada instancia de Vue.
var app_header;
var app_main;
var app_footer;
var app_modal1;
var app_modal2;
var app_modal3;

//Ejecuta la función una vez cargado todo el documento HTML y los recursos gráficos.
window.onload = function() {
	app_header.ocultar();
};

//Obtiene la posición vertical actual de la barra de desplazamiento. Si es superior a 100px, muestra el botón para ir arriba, si es inferior lo oculta.
window.onscroll = function() {
	const booleano = (document.documentElement.scrollTop > 100);
	app_footer.mostrar(booleano);
}
