<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'api', 'middleware' => 'cors' ], function () use ($router) {
    //
    $router->group(['namespace' => 'User', 'prefix' => 'user', 'middleware' => 'auth'], function () use ($router) {
        $router->get('/', 'UserController@index');
        $router->post('/store', 'UserController@store');
        $router->get('/show/{id}', 'UserController@show');
        $router->get('/edit/{id}', 'UserController@edit');
        $router->post('/update/{id}', 'UserController@update');
        $router->delete('/destroy/{id}', 'UserController@destroy');
        $router->get('/login', 'UserController@getUserLogin');
        $router->post('/logout', 'UserController@logout');
        $router->get('/search', 'UserController@search');
    });

    $router->group(['namespace' => 'Customer', 'prefix' => 'customer'], function () use ($router) {
        $router->get('/', 'CustomerController@index');
        $router->post('/store', 'CustomerController@store');
        $router->put('/update/{id}', 'CustomerController@update');
        $router->get('/show/{id}', 'CustomerController@show');
    });

    $router->group(['namespace' => 'Category', 'prefix' => 'categories'], function () use ($router) {
        $router->get('/', 'CategoryController@index');
        $router->post('/store', 'CategoryController@store');
        $router->put('/update/{id}', 'CategoryController@update');
        $router->get('/show/{id}', 'CategoryController@show');
        $router->delete('/delete/{id}', 'CategoryController@show');
    });

    $router->group(['namespace' => 'Order', 'prefix' => 'order'], function () use ($router){
        $router->get('/', 'OrderController@index');
    });

    $router->group(['prefix' => 'login', 'namespace' => 'User'], function () use ($router) {
        $router->post('/', 'UserController@login');
    });

    $router->group(['prefix' => 'reset', 'namespace' => 'User'], function () use ($router) {

        $router->post('/', 'UserController@sendResetToken');
        $router->put('/{token}', 'UserController@verifyResetPassword');
    });
});
