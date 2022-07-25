<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $medical_histories = MedicalHistory::where('people_id',$request->peopleId)->get();
        return response()->json($medical_histories);
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
            'disease_name' =>'required',
            'identify_date' =>'required',
            'people_id' =>'required',
        ]);
        $medical_history = new MedicalHistory();
        $medical_history->disease_name = $request->disease_name;
        $medical_history->people_id = $request->people_id;
        $medical_history->identify_date = $request->identify_date;
        $medical_history->cure_date = $request->cure_date;
        $medical_history->note = $request->note;
        $medical_history->save();
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
            'disease_name' =>'required',
            'identify_date' =>'required',
            'people_id' =>'required',
        ]);
        $medical_history = MedicalHistory::findOrFail($id);
        $medical_history->disease_name = $request->disease_name;
        $medical_history->people_id = $request->people_id;
        $medical_history->identify_date = $request->identify_date;
        $medical_history->cure_date = $request->cure_date;
        $medical_history->note = $request->note;
        $medical_history->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medical_histori = MedicalHistory::find($id);
        $medical_histori->delete();
    }
}
