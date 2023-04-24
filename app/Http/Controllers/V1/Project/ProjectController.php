<?php

namespace App\Http\Controllers\V1\Project;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){

        return view('project.project')->with(['projects' => Project::all() , 'clients' => Client::all() , 'employees' =>Employee::all()]);
    }
    public function store(Request $request)
    {
        $project = new Project();
        $project->project_name = $request->project_name;
        $project->start_date = $request->start_date;
        $project->client_id = $request->client_id;
        $project->end_date = $request->end_date;
        $project->rate = $request->rate;
        $project->rate_type = $request->rate_type;
        $project->priority = $request->priority;
        $project->description = $request->description;
        $project->progress = $request->progress;
        $project->teamLeader()->associate(Employee::find($request->team_leader_id));
        $project->save();
        $project->employees()->sync($request->employee_ids);


        return back()->with('Add','Project Record has been created successfully !');


    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $currentEmployees = $project->employees->pluck('id')->toArray();
        return view('project.edit_project')->with(['project' => $project,
         'clients' => Client::all() ,
         'employees' => Employee::all(),
         'currentEmployees' => $currentEmployees  ]);
    }

    public function update(Request $request,$id)
    {

        $project = Project::findOrFail($id);
        $project->project_name = $request->project_name;
        $project->start_date = "2023-03-25";
        $project->client_id = $request->client_id;
        $project->end_date = "2023-03-28";
        $project->rate = $request->rate;
        $project->rate_type = $request->rate_type;
        $project->priority = $request->priority;
        $project->description = $request->description;
        $project->teamLeader()->associate(Employee::find($request->team_leader_id));
        $project->update();
        $project->employees()->sync($request->employee_ids);

        return back()->with('Update','Project Record has been Updated successfully !');
    }


}
