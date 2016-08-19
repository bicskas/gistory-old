<?php

Route::model('menu', 'App\Menu');
Route::model('szoveg', 'App\Szoveg');
Route::model('project', 'App\Project');

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

Route::group(['middleware' => ['web']], function() {
	
	Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function() {

		Route::resource('menu', 'Admin\MenuController');
		Route::resource('szoveg', 'Admin\SzovegController');

		Route::controller('kep', 'Admin\KepController');
		Route::controller('ajax', 'Admin\AjaxController');
		Route::get('/', 'Admin\SzovegController@index');

	});

	Route::controller('admin/auth', 'Admin\AuthController');
	Route::controller('auth', 'Auth\AuthController');
	Route::get('/', 'FooldalController@index');
	Route::get('/project', 'ProjectController@index');
	Route::resource('project', 'ProjectController');

	Route::group(['middleware' => 'auth'], function() {
		Route::get('/home', 'FooldalController@index');
	});

	// ----- menü route-ok generálása -----
//	App\Menu::aktiv()
//		->where('tipus', '!=', 'url')
//		->get()
//		->each(function($menu) {
//			foreach (config('routes.' . $menu->tipus, array()) as $route) {
//				Route::{array_get($route, 'method', 'get')}($menu->link . array_get($route, 'url', ''), array(
//					'uses' => studly_case(array_get($route, 'controller', $menu->tipus)) . 'Controller@' . array_get($route, 'action', 'index'),
//					'as' => array_get($route, 'as'),
//					'menu' => $menu,
//					'where' => array_get($route, 'where', array()),
//				));
//			}
//		});

	// ----- egyéb szövegek -----
//	Route::bind('szoveg_link', function($link) {
//		$model = App\Szoveg::whereLink($link)->first();
//		return $model ?: abort(404);
//	});
//	Route::get('{szoveg_link}', array('uses' => 'SzovegController@index'));
});

