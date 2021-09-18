<?php 

use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use Psr\Container\ContainerInterface;


$container->set('modelo_producto', function(ContainerInterface $container) {
	return new ProductoModel($container->get('db'));
});

$container->set('modelo_categoria', function(ContainerInterface $container) {
	return new CategoriaModel($container->get('db'));
});