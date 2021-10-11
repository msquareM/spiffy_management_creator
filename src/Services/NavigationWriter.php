<?php

namespace Trioangle\SpiffyAutogenerate\Services;


class NavigationWriter extends AutoGenearateManagement
{
	public function __construct($fileName)
	{	
		$this->fileLocation = base_path().'/resources/views/admin/common/navigation.blade.php';
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
		@if(Auth::guard('admin')->user()->can('manage-precedentials'))
			<li class=\"{{ (Route::current()->uri() == 'admin/precedential') ? 'active' : ''  }}\"><a href=\"{{ url('admin/precedential') }}\"><i class=\"fa fa-globe\"></i><span>Manage Precedential</span></a></li>
		@endif

		</ul>
	</section>
</aside>

		";

		return $content;

	}


	protected function getFile($fileLocation,$modelData){
		$copyData = file_get_contents($fileLocation);
		$copyData = str_replace('</ul>', '<new>', $copyData);
		$copyData = preg_replace('/<new>/', '</ul>', $copyData, 2);
		$copyData = preg_replace('/<new>/', '', $copyData, 1);
		$copyData = str_replace('</section>', '', $copyData);
		$copyData = str_replace('</aside>', '', $copyData);
		$modelData = $copyData.$modelData; 
		file_put_contents($fileLocation,$modelData);
	}



}