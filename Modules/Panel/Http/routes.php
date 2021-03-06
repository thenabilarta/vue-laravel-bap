<?php

Route::group(['middleware' => 'web', 'prefix' => 'panel', 'namespace' => 'Modules\Panel\Http\Controllers'], function()
{
    Route::get('/', 'PanelController@index');
    Route::get('/data', 'PanelController@data');
    Route::post('/addmedia', 'PanelController@addmedia');
    Route::get('/main', 'PanelController@main');
    Route::get('/delete/{id}', 'PanelController@delete');
    Route::get('/edit/{id}', 'PanelController@edit');
    Route::post('/edit/store', 'PanelController@editstore');
});
