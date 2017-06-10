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
    
    Route::get('/', [
        'as' => 'home',
        'uses' => 'PagesController@home'
    ]);
    
    Route::get('documents/changeActiveDocument/{id?}', [
        'as' => 'changeActiveDocument',
        'uses' => 'DocumentsController@changeActiveDocument'
    ]);

    
    Route::resource('proprietors', 'ProprietorsController');
    Route::resource('parcels', 'ParcelsController');
    Route::resource('places', 'PlacesController');
    Route::resource('parceltypes', 'ParcelTypesController');
    Route::resource('references', 'ReferencesController');
    Route::resource('professions', 'ProfessionsController');
    Route::resource('documents', 'DocumentsController');
});
