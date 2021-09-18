<?php namespace App\Models;


class CategoriaModel{

	protected $pdo;

	//CONSTRUCTOR DEL MODELO.
	public function __construct($db) {

		$this->pdo = $db;
	}


	//FUNCIÓN QUE OBTIENE TODAS LAS CATEGORÍAS. (SI NO HAY CATEGORÍAS, RETORNA VACÍO).
	public function obtenerTodo() {

		$sql = "SELECT caId AS id,
					   caDescripcion AS descripcion
				FROM categoria
				ORDER BY caId ASC";

		$query = $this->pdo->query($sql);

		return $query->fetchAll();  //Devuelve un array que contiene todas las filas del conjunto de resultados.
	}


	//FUNCIÓN QUE BUSCA SI ESTÁ REGISTRADO EL IDENTIFICADOR DE LA CATEGORÍA.
	public function buscarId($id) {

		$sql = "SELECT caDescripcion
				FROM categoria
				WHERE caId = ?";

		$sentencia = $this->pdo->prepare($sql);  //Prepara una sentencia para su ejecución y devuelve un objeto sentencia.

		//Vincula un valor al parámetro de sustitución con signo de interrogación de la sentencia SQL.
		$sentencia->bindValue(1, $id);

		$sentencia->execute();  //Ejecuta una sentencia preparada.

		return $sentencia->rowCount();  //Devuelve el número de filas afectadas por la última sentencia SQL.
	}
}