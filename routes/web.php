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

$router->group(['prefix' => 'api', 'middleware' => 'auth' ], function () use ($router) {
    $router->group(['namespace' => 'User', 'prefix' => 'user'], function () use ($router) {
        $router->get('/', 'UserController@index');
        $router->post('/store', 'UserController@store');
        $router->get('/show/{id}', 'UserController@show');
        $router->get('/edit/{id}', 'UserController@edit');
        $router->post('/update/{id}', 'UserController@update');
        $router->delete('/destroy/{id}', 'UserController@destroy');
    });
});