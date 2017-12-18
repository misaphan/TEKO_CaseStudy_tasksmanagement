<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'users'], function(){
	Route::get('/','User\UsersController@index');
});

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/home', function () {

//     return redirect(route('todolist'));
// });


Route::group(['middleware' => 'auth'], function(){
	Route::get('/home', 'Todolist\TodoListController@index')->name('home');

	Route::group(['prefix' => 'users'], function(){
		Route::get('/','User\UsersController@index');

		Route::post('/getuserbyemail', 'User\UsersController@getUserByEmail')->name('users.getbyemail');
	});

	Route::group(['prefix' => 'todolist'], function(){
		Route::get('/', 'Todolist\TodoListController@index')->name('todolist');

		Route::post('/create', 'Todolist\TodoListController@create')->name('todolist.create');

		Route::post('/get', 'Todolist\TodoListController@get')->name('todolist.get');

		Route::post('/update', 'Todolist\TodoListController@update')->name('todolist.update');

		Route::post('/delete', 'Todolist\TodoListController@delete')->name('todolist.delete');

		Route::post('/putback', 'Todolist\TodoListController@putBackTodoList')->name('todolist.putback');

		Route::post('/addmember', 'Todolist\TodoListController@updateTodoListMember')->name('todolist.addmember');

		Route::post('/getmember', 'Todolist\TodoListController@getTodoListMember')->name('todolist.getmember');

		Route::get('/trash', 'Todolist\TodoListController@getTodoListInTrash')->name('todolist.trash');

		Route::post('/search', 'Todolist\TodoListController@search')->name('todolist.search');
	});
});


