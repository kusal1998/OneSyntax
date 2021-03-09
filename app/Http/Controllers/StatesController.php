<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = Countries::get();
        return view('States.index')->with(compact('country'));
    }
    public function getAll(Request $request)
    {
        $States = DB::table('tbl_states')
        ->select('tbl_states.*','tbl_countries.name as country')
        ->join('tbl_countries','tbl_countries.id','=','tbl_states.country')
        ->get();
        $data = array();
        if (!empty($States)) {
            foreach ($States as $type) {
               $nestedData['id'] = $type->id;
                $nestedData['country'] = $type->country;
                $nestedData['name'] = $type->name;
                $nestedData['action'] = '
                <a href="javascript:void(0)" data-id="'.$type->id.'" class="btn-states-edit btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fas fa-pencil-alt"></i></a>
                <a href="javascript:void(0)" data-id="'.$type->id.'" class="btn-states-delete btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fa fa-trash"></i></a>
                ';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "data" => $data
        );
        echo json_encode($json_data);
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
        try {
           
            if($request->id == 0){
                $brand = new States();
                $brand->id = $request->id;
                $brand->country = $request->country;
                $brand->name = $request->name;
                $brand->save();
            }else{
                $brand = States::where('id',$request->id)->first();
                $brand->country = $request->country;
                $brand->name = $request->name;
                $brand->update();
            }
           
            return json_encode(['status' => True]);
        } catch (\Throwable $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            return json_encode(['status' => false, 'message' => 'Server Error! Try again.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\States  $states
     * @return \Illuminate\Http\Response
     */
    public function show(States $states)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\States  $states
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $states = States::where('id',$id)->first();
        return response()->json($states);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\States  $states
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, States $states)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\States  $states
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $states = States::where('id',$id)->delete();
            return response()->json(['status' => True]);
        } catch (\Throwable $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            return response()->json(['status' => false, 'message' => 'Server Error! Try again.']);
        }
    }
}
