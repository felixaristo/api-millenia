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

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', 'AuthenticationController@login');
});

$router->group(['prefix' => 'article'], function () use ($router) {
    $router->post('create', 'ArticleController@create');
    $router->post('update/{id}', 'ArticleController@update');
    $router->delete('delete/{id}', 'ArticleController@delete');
    $router->get('list/{page}/{limit}', 'ArticleController@list');
    $router->get('detail/{id}', 'ArticleController@detail');
    $router->get('other/{id}', 'ArticleController@other');
});

$router->group(['prefix' => 'banner'], function () use ($router) {
    $router->post('create', 'BannerController@create');
    $router->post('update/{id}', 'BannerController@update');
    $router->delete('delete/{id}', 'BannerController@delete');
    $router->get('list/{page}/{limit}', 'BannerController@list');
    $router->get('detail/{id}', 'BannerController@detail');
});