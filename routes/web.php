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

Route::get('/', function () {
	return view('welcome');
})->name('home');

Route::post('/signup', [
	'uses' => 'UserController@postSignUp',
	'as'=>'signup'
]);

Route::get('/dashboard', [
	'uses'=>'postController@getDashboard',
	'as'=>'dashboard',
])->middleware('auth');

Route::post('/signin', [
	'uses' => 'UserController@postSignIn',
	'as'=>'signin'
]);

Route::post('/createpost', [
	'uses' => 'postController@postCreatePost',
	'as' => 'post.create',
	'middleware' => 'auth'
]);

Route::get('/delete-post/{post_id}', [
	'uses' => 'postController@getPostDelete',
	'as' => 'post.delete',
	'middleware' => 'auth'
]);

Route::get('/logout',[
	'uses' =>'UserController@getLogout',
	'as'=>'get.logout'
]);

Route::get('/account', [
	'uses'=>'UserController@getAccount',
	'as'=>'account',
	'middleware' => 'auth'
]);

Route::post('/updateAccount', [
	'uses' => 'UserController@saveAccount',
	'as' => 'account.save',
	'middleware' => 'auth'
]);
Route::get('/userImage/{filename}', [
	'uses'=>'UserController@getUserImage',
	'as'=> 'account.image',
	'middleware' => 'auth'
]);

Route::post('/edit',[
	'uses'=> "PostController@postEditPost",
	'as'=>'edit',
	'middleware' => 'auth'
]);

Route::post('/likes', [
	'uses'=>'PostController@postLikePost',
	'as'=>'likes',
	'middleware' => 'auth'
]);

Auth::routes();

//Route::get('/welcome', 'HomeController@index')->name('home');

