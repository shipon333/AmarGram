<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\EducationalHistory;
use App\Models\EducationType;
use App\Models\PointDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class EducationHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $education_historie = EducationalHistory::with('educationType')->where('person_id',$request->peopleId)->get();
        return response()->json($education_historie);
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
            'education_type_id' =>'required',
            'people_id' =>'required',
        ]);
        $education_historie = new EducationalHistory();

        $rend = rand(1000,9999);
        if ($request->certificate){
            $explode = explode(';',$request->certificate);
            $again_explode = explode('/',$explode[0]);
            $again_explode = end($again_explode);
            $path =public_path('upload/certificate/');
            $filename = date('YmdHi').$rend.'.'.$again_explode;
            $education_historie->files = $filename;
            Image::make($request->certificate)->resize(170, 170)->save($path.$filename);

        }
        $education_historie->education_type_id = $request->education_type_id;
        $education_historie->person_id = $request->people_id;
        $education_historie->note = $request->note;
        if ($education_historie->save()){
            $get_education_type = EducationType::find($request->education_type_id);
            $point = new PointDetails();
            $point->title = $get_education_type->name;
            $point->type = 'Education';
            $point->people_id = $request->people_id;
            $point->point = $get_education_type->point;
            $point->table_name = 'educational_histories';
            $point->table_id = $education_historie->id;
            $point->save();
        }

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
            'education_type_id' =>'required',
            'people_id' =>'required',
        ]);
        $rend = rand(1000,9999);
        $education_historie = EducationalHistory::findOrFail($id);
        if ($request->certificate != $education_historie->files){
            $old_image_path = 'upload/certificate/';
            $old_image = $old_image_path.$education_historie->files;
            if ($education_historie->files){
                unlink($old_image);
            }
            $explode = explode(';',$request->certificate);
            $again_explode = explode('/',$explode[0]);
            $again_explode = end($again_explode);
            $path =public_path($old_image_path);
            $filename = date('YmdHi').$rend.'.'.$again_explode;
            $education_historie->files = $filename;
            Image::make($request->certificate)->resize(170, 170)->save($path.$filename);

        }
        $education_historie->education_type_id = $request->education_type_id;
        $education_historie->note = $request->note;
        $education_historie->save();


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
            $education_history = EducationalHistory::find($id);
            $old_image_path = 'upload/certificate/';
            if (!empty($education_history->files)){
                $old_image = $old_image_path.$education_history->files;
                unlink($old_image);
            }
            $point = PointDetails::where('table_name','educational_histories')->where('table_id',$id);
            $point->delete();
            $education_history->delete();

        });
    }
}
