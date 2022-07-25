<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $accounts = Account::where('organization_id',$user->organization_id)->get();
        return response()->json($accounts);
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
     * @accountm  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'type' =>'required',
            'account_number' =>'nullable',
        ]);
//        return $request->user_id;
        $user = User::findOrFail($request->user_id);
        $account = new Account();
        $account->name = $request->name;
        $account->type = $request->type;
        $account->account_number = $request->account_number;
        $account->organization_id = $user->organization_id;
        $account->save();

    }

    /**
     * Display the specified resource.
     *
     * @accountm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @accountm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @accountm  \Illuminate\Http\Request  $request
     * @accountm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' =>'required',
            'type' =>'required',
            'account_number' =>'nullable',
        ]);
        $account = Account::findOrFail($id);
        $account->name = $request->name;
        $account->type = $request->type;
        $account->account_number = $request->account_number;
        $account->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @accountm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Account::find($id);
        $account->delete();
    }
}
