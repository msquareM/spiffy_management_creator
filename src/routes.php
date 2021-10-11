<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Trioangle\SpiffyAutogenerate\AutoGenerateManagementController;

Route::group(['middleware' => ['web']], function () {
	
	Route::get('auto_generate_management' , [AutoGenerateManagementController::class, 'auto_generate_management_view']);

	Route::post('auto_generate_management' , [AutoGenerateManagementController::class, 'auto_generate_management_create']);

	/*Route::post('auto_generate_management' , 'AutoGenerateController@auto_generate_management_create');
		
	Route::get('testbye' , 'AutoGenerateController@auto_generate_management_view');*/
});


