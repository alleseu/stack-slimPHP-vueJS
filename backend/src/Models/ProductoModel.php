<?php namespace App\Models;


class ProductoModel {

	protected $pdo;

	//CONSTRUCTOR DEL MODELO.
	public function __construct($db) {

		$this->pdo = $db;
	}


	//FUNCIÓN QUE OBTIENE TODOS LOS PRODUCTOS. (SI NO HAY PRODUCTOS, RETORNA VACÍO).
	public function obtenerTodo() {

		$sql = "SELECT prId AS id,
					   prCodigo AS codigo,
					   prNombre AS nombre,
					   prCategoria AS idCategoria,
					   caDescripcion AS categoria,
					   prCreated AS fechaCreacion,
					   prUpdated AS fechaActualizacion
				FROM producto,
					 categoria
				WHERE prCategoria = caId
				  AND prDeleted IS NULL
				ORDER BY prCodigo ASC";

		$query = $this->pdo->query($sql);  //Ejecuta una sentencia SQL, devolviendo un conjunto de resultados como un objeto PDOStatement.
		
		return $query->fetchAll();  //Devuelve un array que contiene todas las filas del conjunto de resultados.
	}


	//FUNCIÓN QUE OBTIENE UN PRODUCTO DE UN IDENTIFICADOR ESPECÍFICO. (SI NO HAY PRODUCTO, RETORNA VACÍO).
	public function obtener($id) {

		$sql = "SELECT prId AS id,
					   prCodigo AS codigo,
					   prNombre AS nombre,
					   prCategoria AS idCategoria,
					   caDescripcion AS categoria,
					   prCreated AS fechaCreacion,
					   prUpdated AS fechaActualizacion
				FROM producto,
					 categoria
				WHERE prCategoria = caId
				  AND prId = ?
				  AND prDeleted IS NULL";

		$sentencia = $this->pdo->prepare($sql);  //Prepara una sentencia para su ejecución y devuelve un objeto sentencia.

		//Vincula un valor al parámetro de sustitución con signo de interrogación de la sentencia SQL.
		$sentencia->bindValue(1, $id);

		$sentencia->execute();  //Ejecuta una sentencia preparada.

		return $sentencia->fetch();  //Obtiene la siguiente fila de un conjunto de resultados.
	}


	//FUNCIÓN QUE BUSCA SI ESTÁ REGISTRADO EL IDENTIFICADOR DEL PRODUCTO.
	public function buscarId($id) {

		$sql = "SELECT prCodigo
				FROM producto
				WHERE prId = ?
				  AND prDeleted IS NULL";

		$sentencia = $this->pdo->prepare($sql);  //Prepara una sentencia para su ejecución y devuelve un objeto sentencia.

		//Vincula un valor al parámetro de sustitución con signo de interrogación de la sentencia SQL.
		$sentencia->bindValue(1, $id);

		$sentencia->execute();  //Ejecuta una sentencia preparada.

		return $sentencia->rowCount();  //Devuelve el número de filas afectadas por la última sentencia SQL.
	}


	//FUNCIÓN QUE BUSCA SI ESTÁ REGISTRADO EL CÓDIGO DEL PRODUCTO. (RETORNA LA CANTIDAD DE REGISTROS).
	public function buscarCodigo($codigo) {

		$sql = "SELECT COUNT(prId) AS busqueda
				FROM producto
				WHERE prCodigo = ?
				  AND prDeleted IS NULL";

		$sentencia = $this->pdo->prepare($sql);  //Prepara una sentencia para su ejecución y devuelve un objeto sentencia.

		//Vincula un valor al parámetro de sustitución con signo de interrogación de la sentencia SQL.
		$sentencia->bindValue(1, $codigo);

		$sentencia->execute();  //Ejecuta una sentencia preparada.

		return $sentencia->fetchColumn();  //Devuelve una única columna de la siguiente fila de un conjunto de resultados.
	}


	//FUNCIÓN QUE BUSCA SI ESTÁ REGISTRADO EL CÓDIGO DEL PRODUCTO, DESCARTANDO UN IDENTIFICADOR ESPECÍFICO. (RETORNA LA CANTIDAD DE REGISTROS).
	public function buscarCodigoFiltrado($id, $codigo) {

		$sql = "SELECT COUNT(prId) AS busqueda
				FROM producto
				WHERE prCodigo = ?
				  AND prId != ?
				  AND prDeleted IS NULL";

		$sentencia = $this->pdo->prepare($sql);  //Prepara una sentencia para su ejecución y devuelve un objeto sentencia.

		//Vincula los valores a los parámetros de sustitución con signo de interrogación de la sentencia SQL.
		$sentencia->bindValue(1, $codigo);
		$sentencia->bindValue(2, $id);

		$sentencia->execute();  //Ejecuta una sentencia preparada.

		return $sentencia->fetchColumn();  //Devuelve una única columna de la siguiente fila de un conjunto de resultados.
	}


	//FUNCIÓN PARA INSERTAR UN PRODUCTO NUEVO.
	public function insertar($codigo, $nombre, $categoria) {

		$sql = "INSERT INTO producto (prCodigo, prNombre, prCategoria, prCreated)
				VALUES (?, ?, ?, ?)";

		$sentencia = $this->pdo->prepare($sql);  //Prepara una sentencia para su ejecución y devuelve un objeto sentencia.

		//Vincula los valores a los parámetros de sustitución con signo de interrogación de la sentencia SQL.
		$sentencia->bindValue(1, $codigo);
		$sentencia->bindValue(2, $nombre);
		$sentencia->bindValue(3, $categoria);
		$sentencia->bindValue(4, date('Y-m-d H:i:s'));

		$sentencia->execute();  //Ejecuta una sentencia preparada.
	}


	//FUNCIÓN PARA ACTUALIZAR UN PRODUCTO.
	public function actualizar($id, $codigo, $nombre, $categoria) {

		$sql = "UPDATE producto
				SET prCodigo = ?,
					prNombre = ?,
					prCategoria = ?,
					prUpdated = ?
				WHERE prId = ?";

		$sentencia = $this->pdo->prepare($sql);  //Prepara una sentencia para su ejecución y devuelve un objeto sentencia.

		//Vincula los valores a los parámetros de sustitución con signo de interrogación de la sentencia SQL.
		$sentencia->bindValue(1, $codigo);
		$sentencia->bindValue(2, $nombre);
		$sentencia->bindValue(3, $categoria);
		$sentencia->bindValue(4, date('Y-m-d H:i:s'));
		$sentencia->bindValue(5, $id);

		$sentencia->execute();  //Ejecuta una sentencia preparada.
	}


	//FUNCIÓN PARA ELIMINAR UN PRODUCTO. (NO ELIMINA EL REGISTRO, SOLO ACTUALIZA LA FECHA).
	public function eliminar($id) {

		$sql = "UPDATE producto
				SET prdeleted = ?
				WHERE prId = ?";

		$sentencia = $this->pdo->prepare($sql);  //Prepara una sentencia para su ejecución y devuelve un objeto sentencia.

		//Vincula los valores a los parámetros de sustitución con signo de interrogación de la sentencia SQL.
		$sentencia->bindValue(1, date('Y-m-d H:i:s'));
		$sentencia->bindValue(2, $id);

		$sentencia->execute();  //Ejecuta una sentencia preparada.
	}
}