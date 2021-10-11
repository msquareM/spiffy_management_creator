<?php

namespace Trioangle\SpiffyAutogenerate\Services;


class ControllerCreator extends AutoGenearateManagement
{
	public function __construct($path = '',$fileName,$fileLocation = '',$fields=['name'=> 'String'])
	{	

		$path = $path != '' ? $path : url('/public');
		$fileLocation = $fileLocation  != '' ? $fileLocation : base_path().'/app/Http/Controllers/Admin/';

		$this->fileSrc  =  $path.'/PrecedentialController.php';
		$this->fileName = $fileName.'Controller.php';
		$this->newFileLocation = $fileLocation.$this->fileName;
		$this->originalFileName = $fileName;
		$this->fields = $fields;

	}


	public function creator()
	{	
		$insertRules = $this->insertRules();
		$insertNick = $this->insertNick();
		$insertFiled = $this->insertFiled();
		
		$copyData = $this->fileRead($this->fileSrc);
		$copyData = str_replace("//insert Rules",$insertRules,$copyData);
		$copyData = str_replace("//insert Nick",$insertNick,$copyData);
		$copyData = str_replace("//insert Fileds",$insertFiled,$copyData);
		$pasteData = $this->change($copyData,$this->originalFileName);
		
		$this->createFile($this->newFileLocation,$pasteData);

	}

	private function insertRules(){
		$pre_sample = "
		\$rules = array(
		";

		$post_sample = "      'status' => 'required',
			);
			\n
		";

		$sample = "       'test' => 'required',\n";

		$new_content = '';

		foreach ($this->fields as $key => $value) {
			$sample1 = str_replace("test",$key,$sample);
			$new_content .= $sample1;
		}
		
		$new = $pre_sample.$new_content.$post_sample;

		return $new;
	}

	private function insertNick(){
		$pre_sample = "
		\$niceNames = array(
		";

		$post_sample = "      'status' => 'Status',
			);
			\n
		";

		$sample = "       'test' => 'Test',\n";

		$new_content = '';

		foreach ($this->fields as $key => $value) {
			$sample1 = str_replace("test",$key,$sample);
			$sample1 = str_replace("Test",ucwords($key),$sample1);
			$new_content .= $sample1;
		}
		
		$new = $pre_sample.$new_content.$post_sample;

		return $new;
	}


	private function insertFiled(){
		$sample = "       \$precedential->test = \$request->test;\n";

		$new_content = '';

		foreach ($this->fields as $key => $value) {
			$sample1 = str_replace("test",$key,$sample);
			$new_content .= $sample1;
		}
		
		return $new_content;
	}

}