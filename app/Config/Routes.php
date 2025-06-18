<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/Quienes-Somos', 'Home::index/Quienes Somos');
$routes->get('/Contacto', 'Home::index/Contacto');
$routes->get('/Comercializacion', 'Home::index/Comercializacion');
$routes->get('/Terminos-Y-Uso', 'Home::index/Terminos Y Usos');
$routes->get('/Catalogo', 'Home::index/Catalogo');
$routes->get('/Consultas', 'Home::index/Consultas');
$routes->get('/Carrito', 'Home::index/Carrito_parte_view');

// Rutas del registro de usuario
$routes->get('/Registro', 'Home::index/Registro');
$routes->post('/enviar-form', 'Usuarios_controller::formValidation');

//Rutas del Logueo de usuario
$routes->get('/login', 'Home::index/Login');
$routes->post('/validar-login', 'Usuarios_controller::validarLogin');
$routes->get('/logout', 'Usuarios_controller::logout');

/*Rutas de productos*/
$routes->get('/crear', 'Productos_controller::index', ['filter' => 'auth']);
$routes->get('/agregar', 'Productos_controller::index', ['filter' => 'auth']);
$routes->get('/produ-form', 'Productos_controller::creaproducto', ['filter' => 'auth']);
$routes->post('/enviar-prod', 'Productos_controller::store',['filter' => 'auth']);
$routes->get('/editar/(:num)', 'Productos_controller::singleproducto/$1',['filter' => 'auth']);
$routes->post('modifica/(:num)', 'Productos_controller::modifica/$l',['filter' => 'auth']);
$routes->get('borrar/(:num)', 'Productos_controller::deleteproducto/$1');
$routes->get('/eliminados' , 'Productos_controller::eliminados',['filter' => 'auth']);
$routes->get('activar_pro/(:num)', 'Productos_controller::activarproducto/$1', ['filter' => 'auth']);

/*Rutas de manejo de usuarios*/
$routes->get('/users-list', 'Usuario_crud_controller::index', ['filter' => 'auth']);
$routes->get('/user-form', 'Usuario_crud_controller::create', ['filter' => 'auth']);
$routes->post('/enviar', 'Usuario_crud_controller::store',['filter' => 'auth']);
$routes->get('/editar-user/(:num)', 'Usuario_crud_controller::singleUser/$1',['filter' => 'auth']);
$routes->post('modifica-user', 'Usuario_crud_controller::update',['filter' => 'auth']);
$routes->get('deleteLogico/(:num)', 'Usuario_crud_controller::deleteLogico/$1');
$routes->get('activar/(:num)', 'Usuario_crud_controller::activar/$1', ['filter' => 'auth']);


//Rutas para el carrito*/
//muestra todos los productos del catalogo
$routes->get('/todos_p','carrito_controller::catalogo',['filter' => 'auth']);
//carga la vista carrito_parte_view
$routes->get('/muestro','carrito_controller::muestra',['filter' => 'auth']);
//actualiza los datos del carrito
$routes->get('/carrito_actualiza','carrito_controller::actualiza_carrito',['filter' => 'auth']);
//agregar los items seleccionados
$routes->post('carrito/add','Carrito_controller::add',['filter' => 'auth']);
//elimina un item del carrito
$routes->get('carrito_elimina/(:any)','carrito_controller::remove/$1',['filter' => 'auth']);
//elimar todo el carrito
$routes->get('/borrar','carrito_controller::borrar_carrito',['filter' => 'auth']);
//Registrar la venta en las tablas
$routes->get('/carrito-comprar','Ventascontroller::registrar_venta',['filter' => 'auth']);
//botones de sumar y restar en la vista del carrito
$routes->get('carrito_suma/(:any)','carrito_controller::suma/$1');
$routes->get('carrito_resta/(:any)','carrito_controller::resta/$1');

// Rutas del cliente para ver sus compras y el detalle
$routes->get('vista_compras/(:num)', 'Ventascontroller::ver_factura/$1', ['filter' => 'auth']);
$routes->get('ver_factura_usuario/(:num)', 'Ventascontroller::ver_facturas_usuario/$1', ['filter' => 'auth']);

// Las ventas que ve el admin
$routes->get('/ventas', 'Ventascontroller::ventas');

