<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function(){
	return str_random(32);
});

// USER Routes
$router->get('/users', ['uses' => 'UserController@index']);
$router->post('/createIntegrator', ['uses' => 'UserController@storeIntegrator']);
$router->post('/createCustomer', ['uses' => 'UserController@storeCustomer']);

// CUSTOMER Routes
$router->get('/getCustomers', ['uses' => 'CustomerController@getCustomers']);

// PRODUCT Routes
$router->get('/products', ['uses' => 'ProductController@index']);
$router->post('/createProduct', ['uses' => 'ProductController@storeProduct']);

// CATALOGUE Routes
$router->post('/createCatalogue', ['uses' => 'CatalogueController@storeCatalogue']);
$router->post('/addInventary', ['uses' => 'CatalogueController@AddStock']);
$router->post('/takedownInventary', ['uses' => 'CatalogueController@takeDown']);
$router->get('/catalogueByCustomer', ['uses' => 'CatalogueController@getCatalogueByCustomer']);