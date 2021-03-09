@extends('layouts.app')
  @section('content')
<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Manage Employees</h3>
                 </div>
                 <!-- /.card-header -->
                <div class="card-body">
                    <table id="tbl_employees" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>Address</th>
                        <th>Department</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Zip</th>
                        <th>Birthday</th>
                        <th>Date Hired</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
      <div class="modal fade" id="manageData_modal" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title card-title" id="manageData_modalTitle">Manage Employees</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <div class="modal-body">
                    <div class="card card-primary">  
                        <form role="form" id="manage_form">
                        {{ csrf_field() }}
                          <div class="card-body">
                            <input type="hidden" class="form-control" id="id" name="id" placeholder="Enter id">
                            <div class="row">
                              <div class="form-group col-4">
                                <label for="exampleInputEmail1">First Name :</label>
                                <input type="text" class="form-control" id="frstname" name="frstname" placeholder="Enter frstname">
                              </div>
                              <div class="form-group col-4">
                                <label for="exampleInputEmail1">Last Name :</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter lastname">
                              </div>
                              <div class="form-group col-4">
                                <label for="exampleInputEmail1">Middle Name :</label>
                                <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Enter middlename">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputEmail1">Address :</label>
                              <input type="text" class="form-control" id="address" name="address" placeholder="Enter address">
                            </div>

                            <div class="row">
                              <div class="form-group col-3">
                                <label for="exampleInputEmail1">Country :</label>
                                <select class="form-control select2" style="width: 100%;" name="country_id" id="country_id">
                                  <option value="0">Please Select</option>
                                    @foreach ($country as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach                                    
                                  </select>
                              </div>

                              <div class="form-group col-3">
                                <label for="exampleInputEmail1">states :</label>
                                <select class="form-control select2" style="width: 100%;" name="state_id" id="state_id">
                                  <option value="0">Please Select</option>
                                    @foreach ($states as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach                                    
                                  </select>
                              </div>

                              <div class="form-group col-3">
                                <label for="exampleInputEmail1">city :</label>
                                <select class="form-control select2" style="width: 100%;" name="city_id" id="city_id">
                                  <option value="0">Please Select</option>
                                    @foreach ($city as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach                                    
                                  </select>
                              </div>
                              
                              <div class="form-group col-3">
                                <label for="exampleInputEmail1">department :</label>
                                <select class="form-control select2" style="width: 100%;" name="department_id" id="department_id">
                                  <option value="0">Please Select</option>
                                    @foreach ($department as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach                                    
                                  </select>
                              </div>
                            </div>
                            
                            
                            <div class="row">
                              <div class="form-group col-4">
                                <label for="exampleInputEmail1">Zip :</label>
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="Enter zip">
                              </div>
                              <div class="form-group col-4">
                                <label for="exampleInputEmail1">Brithday :</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Enter birthdate">
                              </div>
                              <div class="form-group col-4">
                                <label for="exampleInputEmail1">Date Hired :</label>
                                <input type="date" class="form-control" id="date_hired" name="date_hired" placeholder="Enter birthdate">
                              </div>
                            </div>
                           
                        </div>

                          <!-- /.card-body -->
                          <div class="card-footer">
                            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                          </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="btnsave" class="btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>      
          </div>
      </div>

   </section>
    <!-- /.content -->
   @include('Employees.script')
  @endsection
  
