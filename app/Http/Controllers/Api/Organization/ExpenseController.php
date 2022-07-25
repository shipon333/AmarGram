<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $expenses = Expense::with(['expense_type','project'])->orderBy('date','desc')->where('organization_id',$user->organization_id)->get();
        return response()->json($expenses);
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
     * @projectm  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' =>'required',
            'expense_type_id' =>'required',
            'amount' =>'required|numeric',
            'expense_date' =>'required',
            'account_id' =>'required|numeric',
            'user_id' =>'required|numeric',
        ]);


        DB::beginTransaction();
        try{
            $user = User::findOrFail($request->user_id);
            $expense = new Expense();
            $expense->title = $request->title;
            $expense->expense_type_id = $request->expense_type_id;
            $expense->amount = $request->amount;
            $expense->date = $request->expense_date;
            $expense->note = $request->note;
            $expense->project_id = $request->project_id;
            $expense->organization_id = $user->organization_id;
            $expense->save();

            $account = Account::find($request->account_id);
//            if(($account->balance()-$request->amount) < 0){
//                throw new \Exception('Balance is low. Please check your account');
//            }


            $transaction = new Transaction();
            $transaction->type = 'expense';
            $transaction->credit = $request->amount;
            $transaction->trx_date = $request->expense_date;
            $transaction->trx_code = 'EXP';
            $transaction->table_name = 'expenses';
            $transaction->table_id = $expense->id;
            $transaction->note = $request->note;
            $transaction->account_id  = $request->account_id;
            $transaction->balance  = $account->balance() - $request->amount;
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
     * @projectm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::findOrFail($id);
        return response()->json($expense);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @projectm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @projectm  \Illuminate\Http\Request  $request
     * @projectm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' =>'required',
            'expense_type_id' =>'required',
            'amount' =>'required|numeric',
            'date' =>'required',
        ]);

        DB::beginTransaction();
        try{
            $expense = Expense::findOrFail($id);
            $expense->title = $request->title;
            $expense->expense_type_id = $request->expense_type_id;
            $expense->amount = $request->amount;
            $expense->date = $request->date;
            $expense->note = $request->note;
            $expense->project_id = $request->project_id;
            $expense->save();

            $transaction = Transaction::where('table_name','expenses')->where('table_id',$id)->first();

            $account = Account::find($transaction->account_id);
            $current_balance = ($account->balance() + $transaction->credit)-$request->amount;

//            if($current_balance < $request->amount){
//                throw new \Exception('Cash balance is low to expense');
//            }

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
     * @projectm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();

        $transaction = Transaction::where('table_name','expenses')->where('table_id',$id);
        $transaction->delete();

    }
}
