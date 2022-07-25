<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\CommitteeDetails;
use App\Models\User;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $committee = Committee::orderBy('name')->where('organization_id',$user->organization_id)->get();
        return response()->json($committee);
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
        $request->validate([
            'name' =>'required',
            'start_date' =>'required',
            'end_date' =>'required',
        ]);
        $user = User::findOrFail($request->user_id);
        $committee = new Committee();
        $committee->name = $request->name;
        $committee->organization_id = $user->organization_id;
        $committee->start_date = $request->start_date;
        $committee->end_date = $request->end_date;
        $committee->save();
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
       $request->validate([
            'name' =>'required',
            'start_date' =>'required',
            'end_date' =>'required',
        ]);
        $committee =  Committee::findOrFail($id);
        $committee->name = $request->name;
        $committee->start_date = $request->start_date;
        $committee->end_date = $request->end_date;
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
        $committee_delete = Committee::find($id);
        $committee_delete->delete();
    }

    public function storeCommitteeDetails(Request $request){
        $request->validate([
            'member_id' =>'required',
            'committee_id' =>'required',
            'committee_designation_id' =>'required',
        ]);
        $committee_details = new CommitteeDetails();
        $committee_details->member_id = $request->member_id;
        $committee_details->committee_id = $request->committee_id;
        $committee_details->committee_designation_id = $request->committee_designation_id;
        $committee_details->save();
    }

    public function showCommitteeDetails($id){
        $committee_details = CommitteeDetails::with(['committee','member.people','committeeDesignation'])->where('committee_id',$id)->get();
        return response()->json($committee_details);
    }

    public function deleteCommitteeDetails($id){
        $committee_details_delete = CommitteeDetails::find($id);
        $committee_details_delete->delete();
    }
}
