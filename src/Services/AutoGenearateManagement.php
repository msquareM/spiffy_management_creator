<?php

namespace Trioangle\SpiffyAutogenerate\Services;

class AutoGenearateManagement extends CheckGenerateFiles
{

	public $name;
	public $fileds;
	public $path;

	public $controllerName;
	public $modelName;
	//public $migrationName;
	public $viewFolderName;
	public $dataTableName;

	public function __construct($name,$fields)
	{	
		$this->name = ucwords(strtolower($name));
		$this->fields = $fields;
		//$this->path = public_path('/Precedential');
		$this->path = AUTO_GENERATE_SRC_PATH;
		$this->setNames();

	}


	public function generate(){

		$is_allowed = $this->check($this->name);

		if($is_allowed){
			return true;
		}

		$modelCreator = new ModelCreator($this->path,$this->name,'',$this->fields);
		$modelCreator->creator();


		$dataTableCreator = new DataTableCreator($this->path,$this->name,'',$this->fields);
		$dataTableCreator->creator();

		$controllerCreator = new ControllerCreator($this->path,$this->name,'',$this->fields);
		$controllerCreator->creator();

		
		$migrationCreator = new MigrationCreator($this->path,$this->name,'',$this->fields);
		$migrationCreator->creator();

		$viewCreator = new ViewsCreator($this->path,$this->name,'',$this->fields);
		$viewCreator->creator();

		$adminWriter = new AdminWriter($this->name);
		$adminWriter->writer();

		$navigationWriter = new NavigationWriter($this->name);
		$navigationWriter->writer();

		$footWriter = new FootWriter($this->name);
		$footWriter->writer();

		$queryWriter = new QueryWriter($this->name,$this->fields);
		$queryWriter->writer();
		
		return false;
	}	

	private function setNames(){
		$this->controllerName = $this->name.'Controller.php';
		$this->modelName = $this->name.'.php';
		$this->viewFolderName = strtolower($this->name).'s';
		$this->tableName = strtolower($this->name).'s';
		$this->dataTableName = $this->name.'DataTable.php';
	}

	public function fileRead($copyFile){
		$myfile = fopen($copyFile, "r") or die("Unable to open file!");
		$modelData = fread($myfile,filesize($copyFile));
		fclose($myfile);
		return $modelData;
	}

	protected function change($data,$name){
		$name = $this->nameChange($name);
		$a = $name['uc'];
		$b = $name['ucs'];
		$c = $name['lc'];
		$d = $name['lcs'];
		$e = $name['upper'];
		$data = str_replace("Precedentials",$b,$data);
		$data = str_replace("Precedential",$a,$data);	
		$data = str_replace("precedentials",$d,$data);	
		$data = str_replace("precedential",$c,$data);	
		$data = str_replace("PRECEDENTIAL",$e,$data);	
		return $data;
	}


	private function nameChange($result){
		$moduleName = strtolower($result);

		$data['uc'] = $uc = ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $moduleName))));
		$data['ucs'] = $ucs = $uc.'s'; 
		$data['lc'] = $lc = $moduleName;
		$data['lcs'] = $lcs = $lc.'s';
		$data['upper'] = $upper = strtoupper($moduleName);
		return $data;
	}

	protected function createFile($fileLocation,$modelData){
		file_put_contents($fileLocation, $modelData);	
		$permissions = 'chmod -R 777 '.$fileLocation;
		exec($permissions);
	}


	protected function appendFile($fileLocation,$modelData){
		$fp = fopen($fileLocation, 'a');//opens file in append mode.
		fwrite($fp,$modelData);
		fclose($fp);
	}

}