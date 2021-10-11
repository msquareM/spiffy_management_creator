<?php

namespace Trioangle\SpiffyAutogenerate\Services;


class FootWriter extends AutoGenearateManagement
{
	public function __construct($fileName)
	{	
		$this->fileLocation = base_path().'/resources/views/admin/common/foot.blade.php';
		$this->originalFileName = $fileName;
	}

	public function writer()
	{	
		$copyData = $this->content();
		$pasteData = $this->change($copyData,$this->originalFileName);
		$this->getFile($this->fileLocation,$pasteData);
	}


	private function content(){

		$content = "

@if (Route::current()->uri() == 'admin/precedential')

<script src=\"{{ url('admin_assets/plugins/datatables/jquery.dataTables.min.js') }}\"></script>
<script src=\"{{ url('admin_assets/plugins/datatables/dataTables.bootstrap.min.js') }}\"></script>

@endif 



		";

		return $content;

	}


	protected function getFile($fileLocation,$modelData){
		$copyData = file_get_contents($fileLocation);

		$str = '!isset($exception))';

		$position = strpos($copyData,$str);
		$position += strlen($str);
		$read_data = substr_replace($copyData,$modelData,$position,0);

		/*$copyData = str_replace('</body>', '', $copyData);
		$copyData = str_replace('</html>', '', $copyData);*/

		$modelData = $read_data; 
		//$modelData = $copyData.$modelData; 
		file_put_contents($fileLocation,$modelData);
	}


}