<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = States::get();
        return view('Cities.index')->with(compact('states'));
    }

    public function getAll(Request $request)
    {
        $Cities = DB::table('tbl_cities')
        ->select('tbl_cities.*','tbl_states.name as state')
        ->join('tbl_states','tbl_states.id','=','tbl_cities.state')
        ->get();
        $data = array();
        if (!empty($Cities)) {
            foreach ($Cities as $type) {
               $nestedData['id'] = $type->id;
                $nestedData['state'] = $type->state;
                $nestedData['name'] = $type->name;
                $nestedData['action'] = '
                <a href="javascript:void(0)" data-id="'.$type->id.'" class="btn-cities-edit btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fas fa-pencil-alt"></i></a>
                <a href="javascript:void(0)" data-id="'.$type->id.'" class="btn-cities-delete btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fa fa-trash"></i></a>
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
                $brand = new Cities();
                $brand->id = $request->id;
                $brand->state = $request->state;
                $brand->name = $request->name;
                $brand->save();
            }else{
                $brand = Cities::where('id',$request->id)->first();
                $brand->state = $request->state;
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
     * @param  \App\Models\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function show(Cities $cities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities = Cities::where('id',$id)->first();
        return response()->json($cities);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cities $cities)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $cities = Cities::where('id',$id)->delete();
            return response()->json(['status' => True]);
        } catch (\Throwable $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            return response()->json(['status' => false, 'message' => 'Server Error! Try again.']);
        }
    }
}
