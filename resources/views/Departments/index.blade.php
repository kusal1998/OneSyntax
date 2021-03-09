@extends('layouts.app')
  @section('content')
<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Manage Departments</h3>
                 </div>
                 <!-- /.card-header -->
                <div class="card-body">
                    <table id="tbl_departments" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
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
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title card-title" id="manageData_modalTitle">Manage Departments</h5>
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
                            <div class="form-group">
                              <label for="exampleInputEmail1">Name :</label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
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
   @include('Departments.script')
  @endsection
  
