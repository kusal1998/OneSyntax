<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\BrandModal;
use App\Models\partmodal;
use App\Models\Parts;
use Illuminate\Http\Request;
use DB;

class PartModalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand = Brand::get();
        $modal = BrandModal::get();
        $part = Parts::get();
        return view('part-modal.index')->with(compact('brand', 'modal', 'part'));
    }

    public function getAll(Request $request)
    {
       $partmodal = DB::table('tbl_part_modal')
       ->select('tbl_part_modal.*','tbl_brand.name','tbl_brand_model.modal','tbl_parts.part')
       ->join('tbl_brand','tbl_brand.id','=','tbl_part_modal.brand')
       ->join('tbl_brand_model','tbl_brand_model.id','=','tbl_part_modal.modal')
       ->join('tbl_parts','tbl_parts.id','=','tbl_part_modal.part')
       ->get();
    
        $data = array();
        if (!empty($partmodal)) {
            foreach ($partmodal as $modal) {
                $nestedData['id'] = $modal->id;
                $nestedData['brand'] = $modal->name;
                $nestedData['modal'] = $modal->modal;
                $nestedData['part'] = $modal->part;
                $nestedData['part_modal'] = $modal->part_modal;
                if($modal->active==0){
                   $nestedData['active'] = '<div class="icheck-primary d-inline">
                   <input type="checkbox"><label for="active"></label>
                 </div>';
                }else{
                   $nestedData['active'] = '<div class="icheck-primary d-inline">
                   <input type="checkbox" checked><label for="active"></label>
                 </div>';
                }
                $nestedData['action'] = '
                <a href="javascript:void(0)" data-id="'.$modal->id.'" class="btn-part_modal-view btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fas fa-eye"></i></a>
                <a href="javascript:void(0)" data-id="'.$modal->id.'" class="btn-part_modal-edit btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fas fa-pencil-alt"></i></a>
                <a href="javascript:void(0)" data-id="'.$modal->id.'" class="btn-part_modal-delete btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fa fa-trash"></i></a>
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
                    $partmodal = new partmodal();
                    $partmodal->id = $request->id;
                    $partmodal->brand = $request->brand;
                    $partmodal->modal = $request->modal;
                    $partmodal->part = $request->part;
                    $partmodal->part_modal = $request->part_modal;
                    $partmodal->active = $request->active;
                    $partmodal->save();
                }else{
                    $partmodal = partmodal::where('id',$request->id)->first();
                    $partmodal->id = $request->id;
                    $partmodal->brand = $request->brand;
                    $partmodal->modal = $request->modal;
                    $partmodal->part = $request->part;
                    $partmodal->part_modal = $request->part_modal;
                    $partmodal->active = $request->active;
                    $partmodal->update();
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
     * @param  \App\Models\PartModal  $partModal
     * @return \Illuminate\Http\Response
     */
    public function show(PartModal $partModal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PartModal  $partModal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partmodal = PartModal::where('id',$id)->first();
        return response()->json($partmodal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartModal  $partModal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartModal $partModal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartModal  $partModal
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $partmodal = PartModal::where('id',$id)->delete();
            return response()->json(['status' => True]);
        } catch (\Throwable $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            return response()->json(['status' => false, 'message' => 'Server Error! Try again.']);
        }
    }
}
