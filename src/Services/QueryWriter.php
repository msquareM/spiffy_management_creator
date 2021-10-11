<?php

namespace Trioangle\SpiffyAutogenerate\Services;

use DB;

class QueryWriter extends AutoGenearateManagement
{
	public function __construct($fileName,$fields=['name'=> 'String'])
	{	
		$this->originalFileName = $fileName;
		$this->fields = $fields;
	}

	public function writer()
	{	

		$content = $this->schemaContent();
		
		$copyDataArr = $this->content();

		$copyDataArr = array_merge($copyDataArr,[$content]);

		foreach($copyDataArr as $key => $copyData){
			$pasteData = $this->change($copyData,$this->originalFileName);
			$result = DB::statement($pasteData);	
			if($key == 1){
				$result = DB::select('SELECT id FROM permissions ORDER BY id DESC LIMIT 1;');	
				$id = $result[0]->id;
				$this->giveAdminPermission($id);
			}
		}
	}

	private function giveAdminPermission($id){
		$query = "INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('$id', '1');";
		DB::statement($query);	
	}

	private function content(){

		$content = [
			"DROP TABLE IF EXISTS `precedentials`;",

			"INSERT INTO `permissions` (`name`, `display_name`, `description`, `created_at`, `updated_at`)
			VALUES ('manage-precedentials', 'Manage Precedentials', 'Manage Precedentials', now(), now());",
		];

		return $content;

	}


	private function schemaContent(){
		$filed = "`test`";
		$dataType1 = " int(10) unsigned NOT NULL,\n";
		$dataType2 = " varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,\n";

		$content = "CREATE TABLE `precedentials` (
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  //schema
						  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
						  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
						  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
						  PRIMARY KEY (`id`),
						  UNIQUE KEY `precedentials_name_unique` (`name`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
		$new = '';
		
		foreach ($this->fields as $key => $value) {
			$sample1 = str_replace("test",$key,$filed);
			if($value == 'String'){
				$sample1 .= $dataType2;
			}else{
				$sample1 .= $dataType1;
			}
			$new .= $sample1;

		}

		$pasteData = str_replace("//schema",$new,$content);

		return $pasteData;

	}



}