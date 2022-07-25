<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\MemberType;
use App\Models\User;
use Illuminate\Http\Request;

class MemberTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $member_type = MemberType::orderBy('title')->where('organization_id',$user->organization_id)->get();
        return response()->json($member_type);
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
        $member_type = new MemberType();
        $member_type->title = $request->title;
        $member_type->minimum_requirements = $request->minimum_requirements;
        $member_type->organization_id = $user->organization_id;
        $member_type->save();
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
            'title' =>'required',
        ]);
        $member_type = MemberType::findOrFail($id);
        $member_type->title = $request->title;
        $member_type->minimum_requirements = $request->minimum_requirements;
        $member_type->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member_type = MemberType::find($id);
        $member_type->delete();
    }
}
