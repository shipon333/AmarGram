<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Organization;
use App\Models\People;
use App\Models\Transaction;
use App\Models\Union;
use App\Models\Upozilla;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        $user = User::find($request->userId);

        $peoples = People::where('village_id',$user->organization->village_id);
        $data['resident_total'] = $peoples->get()->count();
        $data['resident_male'] = $peoples->where('gender','Male')->count();
        $data['resident_female'] = $peoples->where('gender','Female')->count();
        $data['resident_others'] = $peoples->where('gender','Others')->count();

        $data['balance'] = Transaction::where('organization_id',$user->organization_id)->sum(DB::raw('debit-credit'));
        $data['income'] = Income::where('organization_id',$user->organization_id)->sum('amount');
        $data['expense'] = Expense::where('organization_id',$user->organization_id)->sum('amount');

        $data['division'] = Division::all()->count();
        $data['district'] = District::all()->count();
        $data['upozilla'] = Upozilla::all()->count();
        $data['union'] = Union::all()->count();
        $data['village'] = Village::all()->count();
        $data['organization'] = Organization::all()->count();
        return response()->json($data);
    }
}
