<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use App\Models\Departments;
use App\Models\Employees;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = Countries::get();
        $states = States::get();
        $city = Cities::get();
        $department = Departments::get();

        return view('Employees.index')->with(compact('country', 'states', 'city', 'department'));
    }

    public function getAll(Request $request)
    {
        $types = DB::table('tbl_employees')
        ->select('tbl_employees.*','tbl_departments.name as department','tbl_cities.name as city','tbl_countries.name as country','tbl_states.name as state')
        ->join('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
        ->join('tbl_cities','tbl_cities.id','=','tbl_employees.city_id')
        ->join('tbl_countries','tbl_countries.id','=','tbl_employees.country_id')
        ->join('tbl_states','tbl_states.id','=','tbl_employees.state_id')
        ->get();
        $data = array();
        if (!empty($types)) {
            foreach ($types as $type) {
               $nestedData['id'] = $type->id;
                $nestedData['frstname'] = $type->frstname;
                $nestedData['lastname'] = $type->lastname;
                $nestedData['middlename'] = $type->middlename;
                $nestedData['address'] = $type->address;
                $nestedData['department'] = $type->department;
                $nestedData['city'] = $type->city;
                $nestedData['state'] = $type->state;
                $nestedData['country'] = $type->country;
                $nestedData['zip'] = $type->zip;
                $nestedData['birthdate'] = $type->birthdate;
                $nestedData['date_hired'] = $type->date_hired;
                $nestedData['action'] = '
                <a href="javascript:void(0)" data-id="'.$type->id.'" class="btn-employees-edit btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fas fa-pencil-alt"></i></a>
                <a href="javascript:void(0)" data-id="'.$type->id.'" class="btn-employees-delete btn btn-light btn-sm btn-hover-success font-weight-bold mr-2 only-icon"><i class="fa fa-trash"></i></a>
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
                $emp = new Employees();
                $emp->id = $request->id;
                $emp->frstname = $request->frstname;
                $emp->lastname = $request->lastname;
                $emp->middlename = $request->middlename;
                $emp->address = $request->address;
                $emp->department_id = $request->department_id;
                $emp->city_id = $request->city_id;
                $emp->state_id = $request->state_id;
                $emp->country_id = $request->country_id;
                $emp->zip = $request->zip;
                $emp->birthdate = $request->birthdate;
                $emp->date_hired = $request->date_hired;
                $emp->save();
            }else{
                $emp = Employees::where('id',$request->id)->first();
                $emp->frstname = $request->frstname;
                $emp->lastname = $request->lastname;
                $emp->middlename = $request->middlename;
                $emp->address = $request->address;
                $emp->department_id = $request->department_id;
                $emp->city_id = $request->city_id;
                $emp->state_id = $request->state_id;
                $emp->country_id = $request->country_id;
                $emp->zip = $request->zip;
                $emp->birthdate = $request->birthdate;
                $emp->date_hired = $request->date_hired;
                $emp->update();
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
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show(Employees $employees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employees = Employees::where('id',$id)->first();
        return response()->json($employees);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employees $employees)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $employees = Employees::where('id',$id)->delete();
            return response()->json(['status' => True]);
        } catch (\Throwable $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            return response()->json(['status' => false, 'message' => 'Server Error! Try again.']);
        }
    }
}
