<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\CommitteeDesignation;
use App\Models\User;
use Illuminate\Http\Request;

class CommitteeDesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $committee_designation = CommitteeDesignation::orderBy('title')->where('organization_id',$user->organization_id)->get();
        return response()->json($committee_designation);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' =>'required',
        ]);
        $user = User::findOrFail($request->user_id);
        $para = new CommitteeDesignation();
        $para->title = $request->title;
        $para->organization_id = $user->organization_id;
        $para->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' =>'required,'.$id,
        ]);
        $committee = CommitteeDesignation::findOrFail($id);
        $committee->title = $request->title;
        $committee->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $committee_delete = CommitteeDesignation::find($id);
        $committee_delete->delete();
    }
}
