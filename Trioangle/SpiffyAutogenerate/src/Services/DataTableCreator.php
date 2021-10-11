<?php

namespace Trioangle\SpiffyAutogenerate\Services;


class DataTableCreator extends AutoGenearateManagement
{
	public function __construct($path = '',$fileName,$fileLocation = '',$fields=['name'=> 'String'])
	{	

		$path = $path != '' ? $path : url('/public');
		$fileLocation = $fileLocation  != '' ? $fileLocation : base_path().'/app/DataTables/';

		$this->fileSrc  =  $path.'/PrecedentialDataTable.php';
		$this->fileName = $fileName.'DataTable.php';
		$this->newFileLocation = $fileLocation.$this->fileName;
		$this->originalFileName = $fileName;
		$this->fields = $fields;

	}


	public function creator()
	{	
		$insertContent = $this->insertFiledContent();
		$copyData = $this->fileRead($this->fileSrc);
		$pasteData = $this->change($copyData,$this->originalFileName);
		$pasteData = str_replace("//insert Fileds",$insertContent,$pasteData);
		$this->createFile($this->newFileLocation,$pasteData);
	}

	private function insertFiledContent(){
		$sample = "['data' => 'test', 'name' => 'test', 'title' => 'Test'],\n";
		$new_content = '';

		foreach ($this->fields as $key => $value) {
			$sample1 = str_replace("test",$key,$sample);
			$sample1 = str_replace("Test",ucwords($key),$sample1);
			$new_content .= $sample1;
		}
		
		return $new_content;
	}

}