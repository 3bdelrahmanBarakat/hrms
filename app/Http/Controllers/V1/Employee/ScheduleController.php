<?php

namespace App\Http\Controllers\V1\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Employee\ScheduleRequest;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {

        return view('form.schedule')->with('schedules', Schedule::all());

    }


    public function store(ScheduleRequest $request)
    {
        $request->validated();



        $schedule = new Schedule();
        $schedule->schedule_name = $request->schedule_name;
        $schedule->time_in = $request->time_in;
        $schedule->time_out = $request->time_out;
        $schedule->save();



        session()->flash('Add','Schedule has been created successfully !');
        return redirect()->route('form/employees/schedule');

    }

    public function update(ScheduleRequest $request)
    {

        // $request['time_in'] = str_split($request->time_in, 5)[0];
        // $request['time_out'] = str_split($request->time_out, 5)[0];

        $request->validated();
        Schedule::where('id',$request->id)->update([
            'schedule_name'=> $request->schedule_name,
            'time_in'=> $request->time_in,
            'time_out'=> $request->time_out,
        ]);

        session()->flash('Update','Schedule has been Updated successfully !');
        return redirect()->route('form/employees/schedule');


    }


    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        session()->flash('Delete','Schedule has been Deleted successfully !');
        return redirect()->route('form/employees/schedule');
    }
}
