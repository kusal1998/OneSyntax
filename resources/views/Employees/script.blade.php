<script>
    
    $(document).ready(function () {
            $("#tbl_employees").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "ajax": {
                    "url": '/getEmployees',
                    "dataType": "json",
                    "type": "GET",
                    "data": {_token: "{{csrf_token()}}"}
                },
                "columns": [
                    {"data": "id"},
                    {"data": "frstname"},
                    {"data": "lastname"},
                    {"data": "middlename"},
                    {"data": "address"},
                    {"data": "department"},
                    {"data": "city"},
                    {"data": "state"},
                    {"data": "country"},
                    {"data": "zip"},
                    {"data": "birthdate"},
                    {"data": "date_hired"},                  
                    {"data": "action"}
                ],
                "buttons": [{text: 'Add New',className: 'btn btn-block btn-primary add-employees-data',}],
                "initComplete": function(settings, json) {
                    $("#tbl_employees").DataTable().buttons().container()
                        .appendTo( '#tbl_employees_wrapper .col-md-6:eq(0)');             
                }
            })
            


        $.validator.setDefaults({
            submitHandler: function (e) {
            
                var form = $('#manage_form');
                var data = form.serializeArray();
                $.ajax({
                        url:$('#manage_form').attr('action'),
                        type: 'POST',
                        dataType: "JSON",
                        data: data,
                        success:function(data){
                            if (data['status']) {
                                toastr.success('Successfull save your data !!!')
                            $('#manageData_modal').modal('hide');
                            $('#tbl_employees').DataTable().ajax.reload();
                            }else{
                                toastr.error('Error  data do not save !!!')

                            }

                        }
                });

            }
        });



         $('#manage_form').validate({
                rules: {
                
                    frstname: {
                        required: true,
                    },
                    lastname: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    department_id: {
                        required: true,
                    },
                    city_id: {
                        required: true,
                    },
                    state_id: {
                        required: true,
                    },
                    country_id: {
                        required: true,
                    },
                                      
                },
                messages: {

                    frstname: {
                        required: "Please provide a frstname",
                    },
                    lastname: {
                        required: "Please provide a lastname",
                    },
                    middlename: {
                        required: "Please provide a middlename",
                    },
                    address: {
                        required: "Please provide a address",
                    },
                    department_id: {
                        required: "Please provide a department_id",
                    },
                    city_id: {
                        required: "Please provide a city_id",
                    },
                    state_id: {
                        required: "Please provide a state_id",
                    },
                    country_id: {
                        required: "Please provide a country_id",
                    },
                   
                },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    }
                });

         //Add Countries
        $('body').on('click', '.add-employees-data', function () {
            $('#manageData_modal').modal('show');
            $("#manage_form").attr('action', '/getEmployees/create');
            $('#btnsave').show();
           
            
            $('#id').val('0');
            $('#frstname').val('');
            $('#lastname').val('');
            $('#middlename').val('');
            $('#address').val('');
            $('#department_id').val('0').trigger('change');
            $('#city_id').val('0').trigger('change');
            $('#state_id').val('0').trigger('change');
            $('#country_id').val('0').trigger('change');
            $('#zip').val('');
            $('#birthdate').val('');
            $('#date_hired').val('');
          });
      

         //Edit Countries
        $('body').on('click', '.btn-employees-edit', function () {
            var dataId = $(this).attr("data-id");
            $("#manage_form").attr('action', '/getEmployees/create');
            console.log('a');
            //call getEmployees
            getEmployees(dataId);
            $('#btnsave').show();
            $('#frstname').val('');
            $('#lastname').val('');
            $('#middlename').val('');
            $('#address').val('');
            $('#department_id').val('').trigger('change');
            $('#city_id').val('').trigger('change');
            $('#state_id').val('').trigger('change');
            $('#country_id').val('').trigger('change');
            $('#zip').val('');
            $('#birthdate').val('');
            $('#date_hired').val('');
          
        });

     
        //Delete Countries
        $('body').on('click', '.btn-employees-delete', function () {
            var dataId = $(this).attr("data-id");
            //call delete function
            deleteEmployees(dataId);
        });
  
         //get Countries data from controller
       function getEmployees(dataId){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                        url:"/getEmployees/edit/"+dataId,
                        method:"GET",
                        success:function(data){
                          $('#frstname').val(data.frstname);
                          $('#lastname').val(data.lastname);
                          $('#middlename').val(data.middlename);
                          $('#address').val(data.address);
                          $('#department_id').val(data.department_id).trigger('change');
                          $('#city_id').val(data.city_id).trigger('change');
                          $('#state_id').val(data.state_id).trigger('change');
                          $('#country_id').val(data.country_id).trigger('change');
                          $('#zip').val(data.zip);
                          $('#birthdate').val(data.birthdate);
                          $('#date_hired').val(data.date_hired);
                          $('#id').val(data.id);
                           
                            $('#manageData_modal').modal('show');

                        }
                });
        }




      //Delete
        function deleteEmployees(dataId){
                var _token = $('input[name="_token"]').val();
                if(confirm("Are You sure want to delete !"))
              {
                $.ajax({
                        url:"Employees/delete/"+dataId,
                        method:"GET",
                        success:function(data){
                          console.log(data);
                          if (data['status']==true) {
                            toastr.success('Successfull Delete your data !!!')
                            $('#tbl_employees').DataTable().ajax.reload();
                            }else{
                                toastr.error('Error data do not delete!!! ')
                            }

                        }
                });
              }
        }  

    });     

</script>