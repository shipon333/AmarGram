<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\CommitteeDetails;
use Illuminate\Http\Request;

class CommitteeDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


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
            'member_id' =>'required',
            'committee_id' =>'required',
            'committee_designation_id' =>'required',
        ]);
        $committee_details = CommitteeDetails::findOrFail($id);
        $committee_details->member_id = $request->member_id;
        $committee_details->committee_id = $request->committee_id;
        $committee_details->committee_designation_id = $request->committee_designation_id;
        $committee_details->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $committee_delete = CommitteeDetails::find($id);
        $committee_delete->delete();
    }
}
