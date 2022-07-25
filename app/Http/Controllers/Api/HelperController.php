<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Organization;
use App\Models\OrganizationType;
use App\Models\Union;
use App\Models\Upozilla;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelperController extends Controller
{
   public function loadDistrict($id){
      $district =  District::where('division_id',$id)->get();
      return response()->json($district);
   }
   public function loadUpozilla($id){
      $upozilla =  Upozilla::where('district_id',$id)->get();
      return response()->json($upozilla);
   }
   public function unionLoad($id){
      $union =  Union::where('upozilla_id',$id)->get();
      return response()->json($union);
   }
   public function organizationType(){
       $organizationType = OrganizationType::all();
       return response()->json($organizationType);
   }
   public function organizationRegister(Request $request){
       DB::transaction(function () use ($request){
           $validatedData = $request->validate([
               'union_id' =>'required',
               'villageName' =>'required',
               'organizationName' =>'required',
               'name' =>'required',
               'email' =>'required',
               'password' =>'required',
               'organization_type_id' =>'required',
           ]);
           $village = new Village();
           $village->name = $request->villageName;
           $village->union_id = $request->union_id;
           if ($village->save()){
               $organization = new Organization();
               $organization->name = $request->organizationName;
               $organization->organization_type_id = $request->organization_type_id;
               $organization->village_id = $village->id;
               if ($organization->save()){
                   $user = new User();
                   $user->name = $request->name;
                   $user->email = $request->email;
                   $user->user_type = "org";
                   $user->organization_id = $organization->id;
                   $user->password = bcrypt($request->password);
                   $user->save();
               }
           }
       });

   }
   public function village(){
       $village = Village::orderBy('name')->get();
       return response()->json($village);
   }

   public function user($id){
       $user = User::findOrFail($id);
       return response()->json($user);
   }
}
