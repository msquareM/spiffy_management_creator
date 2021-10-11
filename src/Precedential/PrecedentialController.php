<?php

/**
 * Precedential Controller
 *
 * @package     Spiffy
 * @subpackage  Controller
 * @category    Precedential
 * @author      Trioangle Product Team
 * @version     1.8
 * @link        http://trioangle.com
 */

namespace App\Http\Controllers\Admin;

use App\DataTables\PrecedentialDataTable;
use App\Http\Controllers\Controller;
use App\Http\Start\Helpers;
use App\Models\Precedential;
use Illuminate\Http\Request;
use Validator;

class PrecedentialController extends Controller {

	protected $helper; // Global variable for instance of Helpers

	public function __construct() {
		$this->helper = new Helpers;
	}

	/**
	 * Load Datatable for Precedential
	 *
	 * @param array $dataTable  Instance of PrecedentialDataTable
	 * @return datatable
	 */
	public function index(PrecedentialDataTable $dataTable) {
		return $dataTable->render('admin.precedentials.view');
	}

	/**
	 * Add a New Precedential
	 *
	 * @param array $request  Input values
	 * @return redirect     to Precedential view
	 */
	public function add(Request $request) {

		if (!$_POST) {
			return view('admin.precedentials.add');
		} else if ($request->submit) {
			// Add Precedential Validation Rules
			//insert Rules

			// Add Precedential Validation Custom Names
			//insert Nick

			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
			} else {
				$precedential = new Precedential;

				//insert Fileds

				$precedential->status = $request->status;
				$precedential->save();

				$this->helper->flash_message('success', 'Added Successfully'); // Call flash message function

				return redirect('admin/precedential');
			}
		} else {
			return redirect('admin/precedential');
		}
	}

	/**
	 * Update Precedential Details
	 *
	 * @param array $request    Input values
	 * @return redirect     to Precedential View
	 */
	public function update(Request $request) {
		if (!$_POST) {
			$data['result'] = Precedential::find($request->id);

			if (!empty($data['result'])) {
				return view('admin.precedentials.edit', $data);
			} else {
				abort('404');
			}

		} else if ($request->submit) {
			// Edit Precedential Validation Rules
			//insert Rules

			// Edit Precedential Validation Custom Fields Name
			//insert Nick

			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
			} else {
				$precedential = Precedential::find($request->id);

				//insert Fileds

				$precedential->status = $request->status;
				$precedential->save();

				$this->helper->flash_message('success', 'Updated Successfully'); // Call flash message function

				return redirect('admin/precedential');
			}
		} else {
			return redirect('admin/precedential');
		}
	}

	/**
	 * Delete Precedential
	 *
	 * @param array $request    Input values
	 * @return redirect     to Precedential View
	 */
	public function delete(Request $request) {
		Precedential::find($request->id)->delete();
		$this->helper->flash_message('success', 'Deleted Successfully');
		return redirect('admin/precedential');
	}

}
