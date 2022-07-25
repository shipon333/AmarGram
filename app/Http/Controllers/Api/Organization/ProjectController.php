<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $projects = Project::orderBy('id','desc')->where('organization_id',$user->organization_id)->get();
        return response()->json($projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @projectm  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'start_date' =>'required',
            'location' =>'nullable',
            'budget' =>'nullable|numeric',
            'description' =>'nullable',
        ]);
        $user = User::findOrFail($request->user_id);
        $project = new Project();
        $project->name = $request->name;
        $project->start_date = $request->start_date;
        $project->location = $request->location;
        $project->budget = $request->budget;
        $project->description = $request->description;
        $project->organization_id = $user->organization_id;
        $project->save();

    }

    /**
     * Display the specified resource.
     *
     * @projectm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with(['donations','expenses','organization'])->findOrFail($id);
        return response()->json($project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @projectm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @projectm  \Illuminate\Http\Request  $request
     * @projectm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' =>'required',
            'start_date' =>'required',
            'location' =>'nullable',
            'budget' =>'nullable|numeric',
            'description' =>'nullable',
        ]);
        $project = Project::findOrFail($id);
        $project->name = $request->name;
        $project->start_date = $request->start_date;
        $project->location = $request->location;
        $project->budget = $request->budget;
        $project->description = $request->description;
        $project->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @projectm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();
    }

    public function activeProjects(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $projects = Project::where('organization_id',$user->organization_id)->where('status',0)->get();
        return response()->json($projects);
    }
}
