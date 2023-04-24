<?php

namespace App\Http\Controllers\V1\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Department\saveRecordDepartmentRequest;
use App\Models\Department;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = DB::table('departments')->paginate(15);
        return view('form.departments', compact('departments'));
    }

    public function saveRecordDepartment(saveRecordDepartmentRequest $request)
    {
        $department = new Department();
        $department->department = $request->department;
        $department->save();


        session()->flash('Add', 'Department Added Successfully');
        return redirect()->route('form/departments/page');
    }

    public function updateRecordDepartment(Request $request)
    {
        $this->validate($request,[
            'department' => 'required',
        ]);

        Department::where('id', $request->id)->update(['department'=> $request->department]);
        session()->flash('Update', 'Department Updated Successfully');
        return redirect()->route('form/departments/page');
    }
}
