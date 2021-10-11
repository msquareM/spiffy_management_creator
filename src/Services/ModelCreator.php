<?php

namespace Trioangle\SpiffyAutogenerate\Services;


class ModelCreator extends AutoGenearateManagement
{
	public function __construct($path = '',$fileName,$fileLocation = '',$fields=['name'=> 'String'])
	{	

		$path = $path != '' ? $path : url('/public');
		$fileLocation = $fileLocation  != '' ? $fileLocation : base_path().'/app/Models/';

		$this->fileSrc  =  $path.'/Precedential.php';
		$this->fileName = $fileName.'.php';
		$this->newFileLocation = $fileLocation.$this->fileName;
		$this->originalFileName = $fileName;
		
	}


	public function creator()
	{	
		$copyData = $this->fileRead($this->fileSrc);
		$pasteData = $this->change($copyData,$this->originalFileName);
		$this->createFile($this->newFileLocation,$pasteData);
	}

	


}