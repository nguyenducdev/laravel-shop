<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
    Route::group(['prefix' => 'admin'], function () {
	    Route::get('/', function () {
		    return view('admin/dashboard');
		});
		
		Route::get('/category', [
			'as' => 'Categoryindex',
			'uses' => 'CategoriesController@index'
		]);

		Route::get('/category/add', [
			'as' => 'Categorycreate',
			'uses' => 'CategoriesController@create'
		]);

		Route::post('/category/postadd', [
			'as' => 'Categorystore',
			'uses' => 'CategoriesController@store'
		]);

		Route::get('/category/edit/{id}', [
			'as' => 'Categoryedit',
			'uses' => 'CategoriesController@edit'
		]);

		Route::post('/category/update/{id}', [
			'as' => 'Categoryupdate',
			'uses' => 'CategoriesController@update'
		]);

		Route::get('/category/destroy/{id}', [
			'as' => 'Categorydestroy',
			'uses' => 'CategoriesController@destroy'
		]);

	});
});
