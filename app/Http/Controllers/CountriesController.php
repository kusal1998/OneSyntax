<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Countries.index');
    }

    public function getAll(Request $request)
    {
        $types = Countries::get();
        $data = array();
        if (!empty($types)) {
            foreach ($types as $type) {
               $nestedData['id'] = $type->id;
                $nestedData['country_code'] = $type->country_code;
                $nestedData['name'] = $type->name;
                $nestedData['action'] = '
                <a href="javascript:void(0)" data-id="'.$type->id.'" class="btn-countries-edit btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fas fa-pencil-alt"></i></a>
                <a href="javascript:void(0)" data-id="'.$type->id.'" class="btn-countries-delete btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fa fa-trash"></i></a>
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
                $brand = new Countries();
                $brand->id = $request->id;
                $brand->country_code = $request->country_code;
                $brand->name = $request->name;
                $brand->save();
            }else{
                $brand = Countries::where('id',$request->id)->first();
                $brand->country_code = $request->country_code;
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
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function show(Countries $countries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Countries::where('id',$id)->first();
        return response()->json($country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Countries $countries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $country = Countries::where('id',$id)->delete();
            return response()->json(['status' => True]);
        } catch (\Throwable $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            return response()->json(['status' => false, 'message' => 'Server Error! Try again.']);
        }
    }
}
