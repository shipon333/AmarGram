<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Donation;
use App\Models\People;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $donations = Donation::with(['people','project'])->orderBy('id','desc')->where('organization_id',$user->organization_id)->get();
        return response()->json($donations);
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
            'donor_id' =>'required_if:donor_name,null',
            'donor_name' =>'required_if:donor_id,null',
            'donation_date' =>'required',
            'amount' =>'required|numeric',
            'account_id' =>'required|numeric',
//            'received_by' =>'required|numeric',
            'user_id' =>'required|numeric',
        ]);

        DB::beginTransaction();
        try{
            $user = User::findOrFail($request->user_id);
            $donation = new Donation();
            $donation->donor_name = $request->donor_name;
            $donation->people_id = $request->donor_id;
            $donation->project_id = $request->project_id;
            $donation->amount = $request->amount;
//            $donation->received_by = $request->received_by;
            $donation->note = $request->note;
            $donation->organization_id = $user->organization_id;
            $donation->donation_date = $request->donation_date;

            $donation->save();



            $account = Account::find($request->account_id);
            $transaction = new Transaction();
            $transaction->type = 'donation';
            if($request->donor_id != ''){
                $donor = People::find($request->donor_id);
                $transaction->payer = $donor->name;
            } else {
                $transaction->payer = $request->donor_name;
            }

            $transaction->debit = $request->amount;
            $transaction->trx_date = $request->donation_date;
            $transaction->trx_code = 'DN';
            $transaction->table_name = 'donations';
            $transaction->table_id = $donation->id;
            $transaction->note = $request->note;
            $transaction->account_id  = $request->account_id;
            $transaction->balance  = $account->balance() + $request->amount;
            $transaction->user_id   = $request->user_id;
            $transaction->organization_id = $user->organization_id;
            $transaction->save();
            DB::commit();


        } catch(\Exception $e){
            DB::rollBack();
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
        $donation = Donation::findOrFail($id);
        return response()->json($donation);
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
            'people_id' =>'required_if:donor_name,null',
            'donor_name' =>'required_if:people_id,null',
            'donation_date' =>'required',
            'amount' =>'required|numeric',
//            'received_by' =>'required|numeric',
        ]);

        DB::beginTransaction();
        try{
            $donation = Donation::findOrFail($id);
            $donation->donor_name = $request->donor_name;
            $donation->people_id = $request->people_id;
            $donation->project_id = $request->project_id;
            $donation->amount = $request->amount;
//            $donation->received_by = $request->received_by;
            $donation->note = $request->note;
            $donation->donation_date = $request->donation_date;
            $donation->save();

            $transaction = Transaction::where('table_name','donations')->where('table_id',$id)->first();

            $account = Account::find($transaction->account_id);
            if($request->people_id != ''){
                $donor = People::find($request->people_id);
                $transaction->payer = $donor->name;
            } else {
                $transaction->payer = $request->donor_name;
            }
            $current_balance = ($account->balance() - $transaction->debit)+$request->amount;

            $transaction->debit = $request->amount;
            $transaction->trx_date = $request->donation_date;
            $transaction->note = $request->note;
            $transaction->balance = $current_balance;
            $transaction->save();
           
            DB::commit();

        } catch(\Exception $e){
            DB::rollBack();
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
        $donation = Donation::find($id);
        $donation->delete();

        $transaction = Transaction::where('table_name','donations')->where('table_id',$id);
        $transaction->delete();
    }
}
