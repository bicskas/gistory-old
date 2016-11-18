<?php

Route::model('menu', 'App\Menu');
Route::model('szoveg', 'App\Szoveg');
Route::model('project', 'App\Project');
Route::model('subproject', 'App\Subproject');
Route::model('node', 'App\Node');
Route::model('team', 'App\Team');

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

	Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function () {

		Route::resource('menu', 'Admin\MenuController');
		Route::resource('szoveg', 'Admin\SzovegController');

		Route::controller('kep', 'Admin\KepController');
		Route::controller('ajax', 'Admin\AjaxController');
		Route::get('/', 'Admin\SzovegController@index');

	});

	/*Route::controller('admin/auth', 'Admin\AuthController');
	Route::controller('auth', 'Auth\AuthController');*/
	Route::controllers([
		'admin/auth' => 'Admin\AuthController',
		'auth' => 'Auth\AuthController',
		'password' => 'Auth\PasswordController',
	]);

	Route::get('/', 'FooldalController@index');

	Route::group(['middleware' => 'auth'], function ($router) {
		Route::get('/home', 'FooldalController@index');
		Route::get('/project', 'ProjectController@index');
		Route::get('/project/{id}/subproject', 'ProjectController@subproject');
		Route::get('/network/compare/{projectid}', 'NetworkController@compare');
		Route::get('/network/{projectid}', 'NetworkController@index');
		Route::get('/network/deleteedge/{edgeid}', 'NetworkController@deleteEdge')->name('deleteedge');
		Route::get('/network/{projectid}/{subprojectid}', 'NetworkController@subprojectedge');
		Route::post('/network/{projectid}/node', 'NetworkController@createNode');
		Route::post('/network/{projectid}/{subprojectid}/edge', 'NetworkController@saveEdge');
		Route::resource('project', 'ProjectController');
		Route::resource('team', 'TeamController');
		Route::resource('/project/{id}/subproject', 'SubprojectController');
		Route::resource('/network/node', 'NetworkController');

		Route::post('/addteam/{id}','TeamController@addteam')->name('addteam');

//	Route::resource('network', 'NetworkController');
		Route::get('/download/{projectid}/nodes', 'NetworkController@downloadNode');
		Route::get('/download/{projectid}/edges', 'NetworkController@downloadEdge');
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

