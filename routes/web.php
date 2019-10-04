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
$router->post(
    'auth/login',
    [
       'uses' => 'AuthController@authenticate'
    ]
);

$router->group(
    ['middleware' => 'jwt.auth'],
    function() use ($router) {
        $router->get('users', function() {
            $users = \App\User::all();
            return response()->json($users);
        });
    }
);
$router->group(['middleware' => 'jwt.auth'], function($router)
{
    $router->group(['prefix' => 'income'], function () use ($router)
    {
        $router->get('users', function() {
            $users = \App\User::all();
            return response()->json($users);
        });
        $router->get('/', [
            'uses' => 'IncomeController@index'
        ]);
        $router->get('/search', [
            'uses' => 'IncomeController@search'
        ]);
        $router->put('/{income}', [
            'uses' => 'IncomeController@update'
        ]);
        $router->get('/{income}', [
            'uses' => 'IncomeController@detail'
        ]);
        $router->delete('/{income}', [
            'uses' => 'IncomeController@delete'
        ]);
        $router->post('/', [
            'uses' => 'IncomeController@store'
        ]);
    });
    $router->group(['prefix' => 'expense'], function () use ($router)
    {
        $router->get('/', [
            'uses' => 'ExpenseController@index'
        ]);
        $router->get('/search', [
            'uses' => 'ExpenseController@search'
        ]);
        $router->put('/{income}', [
            'uses' => 'ExpenseController@update'
        ]);
        $router->get('/{income}', [
            'uses' => 'ExpenseController@detail'
        ]);
        $router->delete('/{income}', [
            'uses' => 'ExpenseController@delete'
        ]);
        $router->post('/', [
            'uses' => 'ExpenseController@store'
        ]);
    });
    $router->group(['prefix' => 'estimation'], function () use ($router)
    {
        $router->get('/', [
            'uses' => 'ExpenseEstimationController@index'
        ]);
        $router->get('/search', [
            'uses' => 'ExpenseEstimationController@search'
        ]);
        $router->put('/{income}', [
            'uses' => 'ExpenseEstimationController@update'
        ]);
        $router->get('/{income}', [
            'uses' => 'ExpenseEstimationController@detail'
        ]);
        $router->delete('/{income}', [
            'uses' => 'ExpenseEstimationController@delete'
        ]);
        $router->post('/', [
            'uses' => 'ExpenseEstimationController@store'
        ]);
    });

});
