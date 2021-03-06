<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| apis Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/login', 'AuthController@login');
    $router->post('/register', 'AuthController@register');
    $router->post('/forgot', 'AuthController@forgot');
    $router->post('/reset_password', 'VerifyController@reset_password');
    $router->post('/verify', 'VerifyController@verify');
    $router->post('/verify_confirmation', 'AuthController@verify_confirmation');
});

$router->group(['prefix' => 'user'], function () use ($router) {
    $router->get('/validate_token', 'ProfileController@validateToken');
});

$router->group(['prefix' => 'user', 'middleware' => ['auth']], function () use ($router) {
    $router->get('/profile', 'ProfileController@getProfile');
});

$router->group(['prefix' => 'chat', 'middleware' => ['auth']], function () use ($router) {
    $router->get('/topic', 'ContactController@getTopicList');
    $router->get('/message', 'ContactController@getMessageList');
    $router->post('/send', 'ContactController@createMessage');
    $router->post('/feedback', 'ContactController@createFeedback');
});

$router->group(['prefix' => 'profile', 'middleware' => ['auth']], function () use ($router) {
    $router->get('/info', 'ProfileController@getInfo');
    $router->get('/', 'ProfileController@getUserProfile');
    $router->post('/update', 'ProfileController@updateProfile');
});
