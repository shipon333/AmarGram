<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\People;
use App\Models\User;
use Image;
use DB;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $peoples = People::with(['para','village','father.father','mother.father','spouse','point'])->orderBy('para_id','desc')->where('village_id',$request->villageId);

        if($request->search_text != ''){
            $peoples = $peoples->where('name','LIKE','%'.$request->search_text.'%')
                ->orWhere('unique_id','LIKE','%'.$request->search_text.'%')
                ->orWhere('nid','LIKE','%'.$request->search_text.'%')
                ->orWhere('birth_registration','LIKE','%'.$request->search_text.'%')
                ->orWhere('passport_no','LIKE','%'.$request->search_text.'%')
                ->orWhere('driving_license','LIKE','%'.$request->search_text.'%')
                ->orWhere('passport_no','LIKE','%'.$request->search_text.'%')
                ->orWhere('mobile_numbers','LIKE','%'.$request->search_text.'%');
        }
        if($request->religion != '') $peoples = $peoples->where('religion',$request->religion);
        if($request->blood_group != '') $peoples = $peoples->where('blood_group',$request->blood_group);
        if($request->gender != '') $peoples = $peoples->where('gender',$request->gender);
        if($request->para_id != '') $peoples = $peoples->where('para_id',$request->para_id);

        $peoples = $peoples->get();
        return response()->json($peoples);
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
            'name' =>'required',
            'gender' =>'required',
            'para_id' =>'required',
            'ward_no' =>'required',
            'dob' =>'required',
            'marital_status' =>'required',
            'nid' =>'nullable|unique:peoples,nid',
            'birth_registration' =>'nullable|unique:peoples,birth_registration',
            'passport_no' =>'nullable|unique:peoples,passport_no',
            'driving_license' =>'nullable|unique:peoples,driving_license',
            'mobile_numbers' =>'nullable|unique:peoples,mobile_numbers',
            'email' =>'nullable|unique:peoples,email',
        ]);
        $user = User::findOrFail($request->user_id);
        $rend = rand(1000,9999);
        $people = new People();
        if ($request->avatar){
            $explode = explode(';',$request->avatar);

            $again_explode = explode('/',$explode[0]);

            $again_explode = end($again_explode);
            $path =public_path('upload/people/');
            $filename = date('YmdHi').$rend.'.'.$again_explode;

            $people->avatar = $filename;
            Image::make($request->avatar)->resize(170, 170)->save($path.$filename);
        }

        $people->unique_id = $rend;
        $people->nid = $request->nid;
        $people->birth_registration = $request->birth_registration;
        $people->passport_no = $request->passport_no;
        $people->driving_license = $request->driving_license;
        $people->name = $request->name;
        $people->father_name = $request->father_name;
        $people->father_id = $request->father_id;
        $people->mother_name = $request->mother_name;
        $people->mother_id = $request->mother_id;
        $people->dob = $request->dob;
        $people->dod = $request->dod;
        $people->dom = $request->dom;
        $people->mobile_numbers = $request->mobile_numbers;
        $people->marital_status = $request->marital_status;
        $people->email = $request->email;
        $people->profession = $request->profession;
        $people->village_id = $user->organization->village->id;
        $people->para_id = $request->para_id;
        $people->spouse_name = $request->spouse_name;
        $people->spouse_id = $request->spouse_id;
        $people->spouse_address = $request->spouse_address;
        $people->blood_group = $request->blood_group;
        $people->religion = $request->religion;
        $people->dependent_on = $request->dependent_on;
        $people->old_age_allowance = $request->old_age_allowance??0;
        $people->is_freedom_fighter = $request->is_freedom_fighter??0;
        $people->freedom_fighter_allowance = $request->freedom_fighter_allowance??0;
        $people->is_disabled = $request->is_disabled??0;
        $people->disability_allowance = $request->disability_allowance??0;
        $people->ward_no = $request->ward_no;
        $people->height = $request->height;
        $people->weight = $request->weight;
        $people->gender = $request->gender;
        $people->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $people = People::with(['father.father','mother.father','donations'])->findOrFail($id);
        return response()->json($people);
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
            'name' =>'required',
            'gender' =>'required',
            'para_id' =>'required',
            'ward_no' =>'required',
            'dob' =>'required',
            'marital_status' =>'required',
            'nid' =>'nullable|unique:peoples,nid,'.$id,
            'birth_registration' =>'nullable|unique:peoples,birth_registration,'.$id,
            'passport_no' =>'nullable|unique:peoples,passport_no,'.$id,
            'driving_license' =>'nullable|unique:peoples,driving_license,'.$id,
            'mobile_numbers' =>'nullable|unique:peoples,mobile_numbers,'.$id,
            'email' =>'nullable|unique:peoples,email,'.$id,
        ]);
        $rend = rand(1000,9999);
        $people = People::findOrFail($id);
        if ($request->avatar != $people->avatar){
            $old_image_path = 'upload/people/';
            $old_image = $old_image_path.$people->avatar;
            if ($people->avatar){
                unlink($old_image);
            }
            $explode = explode(';',$request->avatar);
            $again_explode = explode('/',$explode[0]);
            $again_explode = end($again_explode);
            $path =public_path('upload/people/');
            $filename = date('YmdHi').$rend.'.'.$again_explode;

            $people->avatar = $filename;
            Image::make($request->avatar)->resize(170, 170)->save($path.$filename);
        }

        $people->nid = $request->nid;
        $people->birth_registration = $request->birth_registration;
        $people->passport_no = $request->passport_no;
        $people->driving_license = $request->driving_license;
        $people->name = $request->name;
        $people->father_name = $request->father_name;
        $people->father_id = $request->father_id;
        $people->mother_name = $request->mother_name;
        $people->mother_id = $request->mother_id;
        $people->dob = $request->dob;
        $people->dod = $request->dod;
        $people->dom = $request->dom;
        $people->mobile_numbers = $request->mobile_numbers;
        $people->marital_status = $request->marital_status;
        $people->email = $request->email;
        $people->profession = $request->profession;
        $people->para_id = $request->para_id;
        $people->spouse_name = $request->spouse_name;
        $people->spouse_id = $request->spouse_id;
        $people->spouse_address = $request->spouse_address;
        $people->blood_group = $request->blood_group;
        $people->religion = $request->religion;
        $people->dependent_on = $request->dependent_on;
        $people->old_age_allowance = $request->old_age_allowance;
        $people->is_freedom_fighter = $request->is_freedom_fighter;
        $people->freedom_fighter_allowance = $request->freedom_fighter_allowance;
        $people->is_disabled = $request->is_disabled;
        $people->disability_allowance = $request->disability_allowance;
        $people->ward_no = $request->ward_no;
        $people->height = $request->height;
        $people->weight = $request->weight;
        $people->gender = $request->gender;

        $people->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DB::transaction(function() use ($id) {
            $people_delete = People::find($id);
            $old_image_path = 'upload/people/';
            if (!empty($people_delete->avatar)){
                $old_image = $old_image_path.$people_delete->avatar;
                unlink($old_image);
                $people_delete->delete();
            }
            else{

                $people_delete->delete();
            }
        });

    }

    public function getPeople($id){

        $data['male']=People::with('father')->where('gender','Male')->where('village_id',$id)->get();
        $data['female']=People::with('father')->where('gender','Female')->where('village_id',$id)->get();

        return response()->json($data);
    }

    public function getPeoples(Request $request){
        $peoples = People::where('village_id',$request->villageId)->get();
        return response()->json($peoples);
    }
}
