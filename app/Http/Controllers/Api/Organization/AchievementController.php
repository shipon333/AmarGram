<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $achiements = Achievement::where('people_id',$request->peopleId)->get();
        return response()->json($achiements);
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
            'people_id' =>'required',
        ]);
        $achievemt_history = new Achievement();
        $achievemt_history->title = $request->title;
        $achievemt_history->details = $request->details;
        $achievemt_history->people_id = $request->people_id;
        $achievemt_history->file = $request->file;
        $achievemt_history->save();
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
            'title' =>'required',
            'details' =>'required',
            'people_id' =>'required',
        ]);
        $achievemt_history = Achievement::findOrFail($id);
        $achievemt_history->title = $request->title;
        $achievemt_history->details = $request->details;
        $achievemt_history->people_id = $request->people_id;
        $achievemt_history->file = $request->file;
        $achievemt_history->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $achievemt_history =Achievement::find($id);
        $achievemt_history->delete();
    }
}
