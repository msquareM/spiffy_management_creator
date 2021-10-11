<?php

namespace Trioangle\SpiffyAutogenerate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Trioangle\SpiffyAutogenerate\Services\AutoGenearateManagement;

use Session;

class AutoGenerateManagementController extends Controller
{

   public function auto_generate_management_view(){
         
        return view('autogenerate::auto_generate');
   }

   public function auto_generate_management_create(Request $request){

        $fileValues = [];
        if(isset($request->type_name)){
         foreach ($request->type_name as $key => $value) {
            if($value){

               $fileValues[$value] = $request->type[$key] ?? 'String';
            }
         }
        }
        
        if(count($fileValues) == 0){
         $fileValues = ['name'=>'String'];
        }

        $autoGenearateManagement = new AutoGenearateManagement($request->name,$fileValues);

        $result = $autoGenearateManagement->generate();     
        
        if($result){
            Session::flash('message_danger','Management Already Exist. Create With Another Name');
            return redirect('auto_generate_management');        
        }
        
        Session::flash('message_success','Management Created Successfully.');
        return redirect('auto_generate_management');
   }
}
