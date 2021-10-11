<?php

namespace Trioangle\SpiffyAutogenerate\Services;


class ViewsCreator extends AutoGenearateManagement
{
	public function __construct($path = '',$fileName,$fileLocation = '',$fields=['name'=> 'String'])
	{	

		$path = $path != '' ? $path : url('/public');
		$fileLocation = $fileLocation  != '' ? $fileLocation : base_path().'/resources/views/admin/';

		$this->folderSrc  =  $path.'/precedentials';
		$this->newFileLocation = $fileLocation.strtolower($fileName).'s';
		$this->originalFileName = $fileName;
		$this->folderLocation = $fileLocation;
		$this->fields = $fields;
	}


	public function creator()
	{	
		$this->folderCheck();
		$files = $this->folderRead();

		foreach ($files as $key => $value) {
			$temp_location = $this->newFileLocation.'/'.$value;
			$this->makeFile($temp_location,$value);
		}
	}

	private function makeFile($temp_location,$value){

		$insertHtml = $this->insertHtml($value);


		$temp = $this->folderSrc.'/'.$value;
		$copyData = $this->fileRead($temp);
		$pasteData = $this->change($copyData,$this->originalFileName);

		$pasteData = str_replace("{{-- insert Html --}}",$insertHtml,$pasteData);
		

		$temp2 = $this->newFileLocation.'/'.$value;
		$this->createFile($temp2,$pasteData);
	}


	private function folderRead(){
		$arr = scandir($this->folderSrc);
		unset($arr[0]);
		unset($arr[1]);
		return $arr;
	}

	private function folderCheck(){
		if(!is_dir($this->newFileLocation)){
			mkdir($this->newFileLocation);
			$permissions = 'chmod -R 777 '.$this->newFileLocation;
			exec($permissions);
		}
	}


	private function insertHtml($file){

		$filesContent = array(
			'add.blade.php' => "
				<div class='form-group'>
	              <label for='input_short_test' class='col-sm-3 control-label'>Test<em class='text-danger'>*</em></label>

	              <div class='col-sm-6'>
	                {!! Form::text('test', '', ['class' => 'form-control', 'placeholder' => 'Test']) !!}
	                <span class='text-danger'>{{ \$errors->first('test') }}</span>
	              </div>
	            </div>\n
			",
			'edit.blade.php' => "
				<div class='form-group'>
				  <label for='input_short_test' class='col-sm-3 control-label'>Test<em class='text-danger'>*</em></label>

				  <div class='col-sm-6'>
				    {!! Form::text('test', \$result->test, ['class' => 'form-control',  'placeholder' => 'Test']) !!}
				    <span class='text-danger'>{{ \$errors->first('test') }}</span>
				  </div>
				</div>
			",
			'view.blade.php' => '',
		);


		$new_content = '';

		foreach ($this->fields as $key => $value) {
			$sample1 = str_replace("test",$key,$filesContent[$file]);	
			$sample1 = str_replace("Test",ucwords($key),$sample1);
			$new_content .= $sample1;
		}

		
		return $new_content;
	}


}