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
    $version = $router->app->version();
    return view('record', ['version' => $version]);
});

$router->get('process', [
    'as' => 'process', 'uses' => 'ExampleController@index'
]);

$router->post('register', [
    'as' => 'register', 'uses' => 'ExampleController@register'
]);