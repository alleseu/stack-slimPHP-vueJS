/*!
 * INSTANCIAS DE VUE-JS.
 * Copyright 2021 - Alejandro Alberto Sánchez Iturriaga.
 */


app_header = new Vue({
	el: "#app-header",
	data: {
		spinner: true,
		titulo: "PRODUCTOS"
	},
	methods: {
		ocultar: function () {
			this.spinner = false;  //Oculta el spinner de carga.
		}
	}
});


app_main = new Vue({
	el: "#app-main",
	data: {
		loading: true,
		columnas: ["Código", "Producto", "Categoría", "Fecha creación", "Fecha actualización", "Herramientas"],
		productos: null,
		cantidad: 0,
		respuesta: {
			visible: false,
			resultado: true,
			mensaje: null
		},
	},
	methods: {
		cargarTabla: async function () {
			try {
				const r = await obtenerProductos();
				const response = await r.json();

				this.productos = response.data;
				this.cantidad = response.data.length;
				this.loading = false;
			}
			catch (error) {
				console.log(error);

				this.cargarRespuesta(false, "Hubo un error interno, contáctese con el soporte.");
			}
		},
		cargarModal1: async function () {
			try {
				const r = await obtenerCategorias();
				const result = r.ok;
				const response = await r.json();

				if (result) {
					app_modal1.abrir(response.data);
				}
				else {
					this.cargarRespuesta(false, response.mensaje);
				}
			}
			catch (error) {
				console.log(error);

				this.cargarRespuesta(false, "Hubo un error interno, contáctese con el soporte.");
			}
		},
		cargarModal2: async function (id) {
			try {
				const r1 = await obtenerCategorias();
				const result1 = r1.ok;
				const response1 = await r1.json();

				const r2 = await obtenerProducto(id);
				const result2 = r2.ok;
				const response2 = await r2.json();

				if (result1 && result2) {
					app_modal2.abrir(response1.data, response2.data);
				}
				else if (!result1 && result2) {
					this.cargarRespuesta(false, response1.mensaje);
				}
				else if (result1 && !result2) {
					this.cargarRespuesta(false, response2.mensaje);
				}
				else {
					this.cargarRespuesta(false, response1.mensaje+" "+response2.mensaje);
				}
			}
			catch (error) {
				console.log(error);

				this.cargarRespuesta(false, "Hubo un error interno, contáctese con el soporte.");
			}
		},
		cargarModal3: async function (id) {
			try {
				const r = await obtenerProducto(id);
				const result = r.ok;
				const response = await r.json();

				if (result) {
					app_modal3.abrir(response.data);
				}
				else {
					this.cargarRespuesta(false, response.mensaje);
				}
			}
			catch (error) {
				console.log(error);

				this.cargarRespuesta(false, "Hubo un error interno, contáctese con el soporte.");
			}
		},
		cargarRespuesta: function (resultado, mensaje) {
			this.respuesta.visible = true;
			this.respuesta.resultado = resultado;
			this.respuesta.mensaje = mensaje;
		},
	},
	created: function () {
		this.cargarTabla();
	}
});


app_footer = new Vue({
	el: "#app-footer",
	data: {
		visible: false,
		copyright: "Copyright © 2021 - Todos los derechos reservados."
	},
	methods: {
		mostrar: function (booleano) {
			this.visible = booleano;
		},
		subir: function () {
			document.querySelector("body").scrollIntoView({behavior: "smooth"});
		}
	}
});


app_modal1 = new Vue({
	el: "#app-modal1",
	data: {
		loading: false,
		categorias: null,
		producto: {
			codigo: "",
			nombre: "",
			idCategoria: ""
		}
	},
	methods: {
		abrir: function (categorias) {
			this.categorias = categorias;

			modal1.show();  //Abre el modal 1.
		},
		cerrar: function () {
			modal1.hide();  //Cierra el modal 1.
		},
		guardar: async function () {
			this.loading = true;

			try {
				const r = await crearProducto(this.producto);
				const result = r.ok;
				const response = await r.json();

				app_main.cargarRespuesta(result, response.mensaje);
				app_main.cargarTabla();

				this.loading = false;
				modal1.hide();  //Cierra el modal 1.
			}
			catch (error) {
				console.log(error);

				app_main.cargarRespuesta(false, "Hubo un error interno, contáctese con el soporte.");
				modal1.hide();  //Cierra el modal 1.
			}
		}
	}
});

app_modal2 = new Vue({
	el: "#app-modal2",
	data: {
		loading: false,
		categorias: null,
		producto: {
			codigo: "",
			nombre: "",
			idCategoria: ""
		}
	},
	methods: {
		abrir: function (categorias, producto) {
			this.categorias = categorias;
			this.producto = producto;

			modal2.show();  //Abre el modal 2.
		},
		cerrar: function () {
			modal2.hide();  //Cierra el modal 2.
		},
		guardar: async function (id) {
			this.loading = true;

			try {
				const r = await actualizarProducto(id, this.producto);
				const result = r.ok;
				const response = await r.json();

				app_main.cargarRespuesta(result, response.mensaje);
				app_main.cargarTabla();

				this.loading = false;
				modal2.hide();  //Cierra el modal 2.
			}
			catch (error) {
				console.log(error);

				app_main.cargarRespuesta(false, "Hubo un error interno, contáctese con el soporte.");
				modal2.hide();  //Cierra el modal 2.
			} 
		}
	}
});

app_modal3 = new Vue({
	el: "#app-modal3",
	data: {
		loading: false,
		producto: {
			codigo: "",
			nombre: "",
			categoria: ""
		}
	},
	methods: {
		abrir: function (producto) {
			this.producto = producto;

			modal3.show();  //Abre el modal 3.
		},
		cerrar: function () {
			modal3.hide();  //Cierra el modal 3.
		},
		confirmar: async function (id) {
			this.loading = true;

			try {
				const r = await eliminarProducto(id);
				const result = r.ok;
				const response = await r.json();

				app_main.cargarRespuesta(result, response.mensaje);
				app_main.cargarTabla();

				this.loading = false;
				modal3.hide();  //Cierra el modal 3.
			}
			catch (error) {
				console.log(error);

				app_main.cargarRespuesta(false, "Hubo un error interno, contáctese con el soporte.");
				modal3.hide();  //Cierra el modal 3.
			}
		}
	}
});

