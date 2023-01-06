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

$router->group(['prefix' => 'api'] , function () use ($router) {

    //User

        $router->post('/register', 'UserController@register');
        $router->post('/login', 'UserController@login');

        $router->get('/profile', 'UserController@user');
        $router->get('/users/{email}', 'UserController@getUser');
        $router->get('/users', 'UserController@users');

        $router->put('/reset-password/{email}', 'UserController@resetPassword');
        $router->put('/update-profile/{user_id}', 'UserController@update');
        $router->put('/change-password/{user_id}', 'UserController@changePassword');

        $router->post('/logout', 'UserController@logout');
        $router->delete('/delete/{user_id}', 'UserController@delete');

    //ProjectDetail

        $router->post('/create-project', 'DetailController@create');
        $router->get('/projects', 'DetailController@allProjects');
        $router->get('/project/{user_id}', 'DetailController@getProject');
        $router->delete('/delete-project/{detail_id}', 'DetailController@deleteProject');


    });

$router->get('/', function () use ($router) {
    return $router->app->version();
});
