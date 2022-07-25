<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Income;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $incomes = Income::with(['income_type','investment'])->orderBy('date','desc')->where('organization_id',$user->organization_id)->get();
        return response()->json($incomes);
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
            'title' =>'required',
            'income_type_id' =>'required',
            'amount' =>'required|numeric',
            'income_date' =>'required',
            'account_id' =>'required|numeric',
            'user_id' =>'required|numeric',
        ]);


        DB::beginTransaction();
        try{
            $user = User::findOrFail($request->user_id);
            $income = new Income();
            $income->title = $request->title;
            $income->income_type_id = $request->income_type_id;
            $income->amount = $request->amount;
            $income->date = $request->income_date;
            $income->note = $request->note;
            $income->investment_id = $request->investment_id;
            $income->organization_id = $user->organization_id;
            $income->save();

            $account = Account::find($request->account_id);

            $transaction = new Transaction();
            $transaction->type = 'income';
            $transaction->debit = $request->amount;
            $transaction->trx_date = $request->income_date;
            $transaction->trx_code = 'INC';
            $transaction->table_name = 'incomes';
            $transaction->table_id = $income->id;
            $transaction->note = $request->note;
            $transaction->account_id  = $request->account_id;
            $transaction->balance  = $account->balance() + $request->amount;
            $transaction->user_id   = $request->user_id;
            $transaction->organization_id = $user->organization_id;
            $transaction->save();
            DB::commit();

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json($e->getMessage(),Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Display the specified resource.
     *
     * @investmentm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $income = Income::findOrFail($id);
        return response()->json($income);
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
            'title' =>'required',
            'income_type_id' =>'required',
            'amount' =>'required|numeric',
            'date' =>'required',
        ]);

        DB::beginTransaction();
        try{
            $income = Income::findOrFail($id);
            $income->title = $request->title;
            $income->income_type_id = $request->income_type_id;
            $income->amount = $request->amount;
            $income->date = $request->date;
            $income->note = $request->note;
            $income->investment_id = $request->investment_id;
            $income->save();

            $transaction = Transaction::where('table_name','incomes')->where('table_id',$id)->first();

            $account = Account::find($transaction->account_id);
            $current_balance = ($account->balance() - $transaction->credit)+$request->amount;

            $transaction->credit = $request->amount;
            $transaction->trx_date = $request->date;
            $transaction->note = $request->note;
            $transaction->balance = $current_balance;
            $transaction->save();
           
            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json($e->getMessage(),Response::HTTP_FORBIDDEN);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @investmentm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $income = Income::find($id);
        $income->delete();

        $transaction = Transaction::where('table_name','incomes')->where('table_id',$id);
        $transaction->delete();

    }
}
