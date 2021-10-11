<?php

namespace Trioangle\SpiffyAutogenerate\Services;


class AdminWriter extends AutoGenearateManagement
{
	public function __construct($fileName)
	{	
		$this->fileLocation = base_path().'/routes/admin.php';
		$this->originalFileName = $fileName;
	}

	public function writer()
	{	
		$copyData = $this->content();
		$pasteData = $this->change($copyData,$this->originalFileName);
		$this->appendFile($this->fileLocation,$pasteData);
	}


	private function content(){

		$content = "

Route::group(['middleware' => 'auth:admin'], function () { 

	// Manage Precedentials Routes
	Route::group(['middleware' => 'permission:manage-precedentials'], function () {
		Route::get('precedential', 'PrecedentialController@index');
		Route::match(array('GET', 'POST'), 'add_precedential', 'PrecedentialController@add');
		Route::match(array('GET', 'POST'), 'edit_precedential/{id}', 'PrecedentialController@update')->where('id', '[0-9]+');
		Route::get('delete_precedential/{id}', 'PrecedentialController@delete')->where('id', '[0-9]+');
		Route::match(array('GET', 'POST'), 'update_precedential_status/{id}/{status}', 'PrecedentialController@update_status')->where('id', '[0-9]+');
	});

});

		";

		return $content;

	}


}