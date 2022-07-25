<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\CitizenCharter;
use App\Models\User;
use Illuminate\Http\Request;

class CitizenCharterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $citizen = CitizenCharter::orderBy('title','desc')->where('village_id',$request->villageId)->get();
        return response()->json($citizen);
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
            'title' =>'required',
            'details' =>'required',
        ]);

        $user = User::findOrFail($request->user_id);
        $citizen_charter = new CitizenCharter();
        $citizen_charter->title = $request->title;
        $citizen_charter->details = $request->details;
//        $citizen_charter->division_id = $request->division_id;
//        $citizen_charter->district_id  = $request->district_id ;
//        $citizen_charter->upozilla_id  = $request->upozilla_id ;
//        $citizen_charter->union_id  = $request->union_id ;
        $citizen_charter->village_id  = $user->organization->village->id;
        $citizen_charter->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $citizen = CitizenCharter::find($id);
        return response()->json($citizen);
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
            'title' =>'required',
            'details' =>'required',
        ]);

        $citizen_charter = CitizenCharter::findOrFail($id);
        $citizen_charter->title = $request->title;
        $citizen_charter->details = $request->details;
//        $citizen_charter->division_id = $request->division_id;
//        $citizen_charter->district_id  = $request->district_id ;
//        $citizen_charter->upozilla_id  = $request->upozilla_id ;
//        $citizen_charter->union_id  = $request->union_id ;
        $citizen_charter->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $citizen = CitizenCharter::find($id);
        $citizen->delete();
    }
}
