<?php

namespace App\Http\Controllers\V1\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('form.attendance')->with(['attendances' => Attendance::all(),   'employees'=> Employee::with(['attendances','leaves'])->get() , 'leaves'=> Leave::all()]);
    }

    public function check_store(Request $request)
    {


        if (isset($request->attd)) {
            foreach ($request->attd as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($employee = Employee::whereId(request('employee_id'))->with('schedules')->first()) {
                        if (
                            !Attendance::whereAttendance_date($keys)
                                ->whereEmployee_id($key)
                                ->whereType(0)
                                ->first()
                        ) {
                            $data = new Attendance();

                            $data->employee_id = $key;

                            $time_in = $employee['schedules'][0]['time_in'];
                            $data->attendance_time = date('H:i:s', strtotime($time_in));
                            $data->attendance_date = $keys;

                            // $emps = date('H:i:s', strtotime($employee->schedules->first()->time_in));
                            // if (!($emps >= $data->attendance_time)) {
                            //     $data->status = 0;

                            // }
                            $data->save();
                        }
                    }
                }
            }
        }
        if (isset($request->leave)) {
            foreach ($request->leave as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($employee = Employee::whereId(request('employee_id'))->with('schedules')->first()) {
                        if (
                            !Leave::whereLeave_date($keys)
                                ->whereEmployee_id($key)
                                ->whereType(1)
                                ->first()
                        ) {
                            $data = new Leave();
                            $data->employee_id = $key;
                            $time_out = $employee['schedules'][0]['time_out'];
                            $data->leave_time = $time_out;
                            $data->leave_date = $keys;
                            // if ($employee->schedules->first()->time_out <= $data->leave_time) {
                            //     $data->status = 1;

                            // }
                            //
                            $data->save();
                        }
                    }
                }
            }
        }
        session()->flash('Success', 'You have successfully submited the attendance !');
        return back();
    }
}
