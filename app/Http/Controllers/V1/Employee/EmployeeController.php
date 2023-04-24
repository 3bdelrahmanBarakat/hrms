<?php

namespace App\Http\Controllers\V1\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Employee\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {

        return view('form.employee')->with(['employees'=> Employee::all(), 'schedules'=>Schedule::all(), 'departments'=>Department::all()]);
    }

    public function store(EmployeeRequest $request)
    {

        // return $request;
        // die;

        $request->validated();


        Employee::create([
        'name'=> $request->name,
        'position'=> $request->position,
        'email'=> $request->email,
        'department_id'=> $request->department_id,
        'pin_code'=> bcrypt($request->pin_code)
        ]);

        if($request->schedule_id){

            $employee = Employee::latest()->first();

            $employee->schedules()->attach($request->schedule_id);

        }


        session()->flash('Add','Employee Record has been created successfully !');

        return redirect()->route('form/employees/page');
    }


    public function update(Request $request, Employee $employee)
    {
        return $request;
        die;

        $request->validated();

        $employee::where('id',$request->id)->update([

            'name'=> $request->employee,
            'position'=> $request->position,
            'email'=> $request->email,
            'department'=> $request->department,
            'schedule'=> $request->schedule,
            'id'=> $request->id
        ]);






        session()->flash('Update','Employee Record has been Updated successfully !');

        return redirect()->route('form/employees/page');
    }


    public function destroy(Employee $employee)
    {
        $employee->delete();
        session()->flash('Delete','Employee Record has been Deleted successfully !');
        return back()>with('success');
    }
}
