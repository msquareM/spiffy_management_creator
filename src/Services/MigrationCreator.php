<?php

namespace Trioangle\SpiffyAutogenerate\Services;


class MigrationCreator extends AutoGenearateManagement
{
	public function __construct($path = '',$fileName,$fileLocation = '',$fields=['name'=> 'String'])
	{	

		$path = $path != '' ? $path : url('/public');
		$fileLocation = $fileLocation  != '' ? $fileLocation : base_path().'/database/migrations/';

		$this->fileSrc  =  $path.'/create_precedentials_table.php';
		$this->fileName = $this->filename($fileName);
		$this->newFileLocation = $fileLocation.$this->fileName;
		$this->originalFileName = $fileName;
		$this->fields = $fields;

	}


	public function creator()
	{	
		$insertSchema = $this->insertSchema();
		
		$copyData = $this->fileRead($this->fileSrc);
		$pasteData = $this->change($copyData,$this->originalFileName);

		$pasteData = str_replace("//insert Schema",$insertSchema,$pasteData);
		
		$this->createFile($this->newFileLocation,$pasteData);
	}

	private function filename($fileName){
		$fileName = strtolower($fileName).'s';
		$index = date("Y_m_d_His");
		$modelFile1 = $index.'_create_'.$fileName.'_table';
		return $modelFile1.'.php';
	}

	private function insertSchema(){
		$sample_text = "       \$table->string('test',255);\n";

		$sample_num = "       \$table->integer('test');\n";

		$new_content = '';

		foreach ($this->fields as $key => $value) {
			if($value == 'String'){
				$sample1 = str_replace("test",$key,$sample_text);	
			}else{
				$sample1 = str_replace("test",$key,$sample_num);	
			}
			$new_content .= $sample1;
		}
		
		return $new_content;
	}

}