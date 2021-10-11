<?php

namespace Trioangle\SpiffyAutogenerate\Services;

class CheckGenerateFiles
{	
	public $fileName;

	public function check($fileName){
		$methods = get_class_methods(new CheckGenerateFiles);
		//dd($fileName);
		$this->fileName = $fileName;
		foreach($methods as $method){
			if($method != 'check'){
				if($this->$method()){
					return true;
				}
			}
		}
		return false;
	}

	private function checkTable(){
		return \Schema::hasTable($this->tableName);
	}

	private function checkController(){
		$location = base_path('app/Http/Controllers/Admin').'/'.$this->controllerName;
		return file_exists($location) ? true : false;
		
	}

	private function checkModel(){
		$location = base_path('app/Models').'/'.$this->modelName;
		return file_exists($location) ? true : false;
	}

	private function checkDataTable(){
		$location = base_path('app/DataTables').'/'.$this->dataTableName;
		return file_exists($location) ? true : false;		
	}

	private function checkView(){
		$location = base_path('/resources/views/admin').'/'.$this->viewFolderName;
		return is_dir($location) ? true : false;	
	}




}