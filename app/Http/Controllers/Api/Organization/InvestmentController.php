<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\User;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $investments = Investment::orderBy('id','desc')->where('organization_id',$user->organization_id)->get();
        return response()->json($investments);
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
     * @investmentm  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'invest_date' =>'required',
            'amount' =>'required|numeric|min:1',
            'note' =>'nullable',
        ]);
        $user = User::findOrFail($request->user_id);
        $investment = new Investment();
        $investment->name = $request->name;
        $investment->invest_date = $request->invest_date;
        $investment->amount = $request->amount;
        $investment->return_capital = $request->return_capital??0;
        $investment->note = $request->note;
        $investment->organization_id = $user->organization_id;
        $investment->save();

    }

    /**
     * Display the specified resource.
     *
     * @investmentm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $investment = Investment::with(['incomes','organization'])->findOrFail($id);
        return response()->json($investment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @investmentm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @investmentm  \Illuminate\Http\Request  $request
     * @investmentm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' =>'required',
            'invest_date' =>'required',
            'amount' =>'required|numeric',
            'note' =>'nullable',
        ]);
        $investment = Investment::findOrFail($id);
        $investment->name = $request->name;
        $investment->invest_date = $request->invest_date;
        $investment->amount = $request->amount;
        $investment->return_capital = $request->return_capital;
        $investment->note = $request->note;
        $investment->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @investmentm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $investment = Investment::find($id);
        $investment->delete();
    }

    public function activeInvestments(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $investments = Investment::where('organization_id',$user->organization_id)->where('status',1)->get();
        return response()->json($investments);
    }
}
