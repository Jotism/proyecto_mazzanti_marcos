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