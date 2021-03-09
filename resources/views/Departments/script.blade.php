<script>
    
    $(document).ready(function () {
            $("#tbl_departments").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "ajax": {
                    "url": '/getDepartments',
                    "dataType": "json",
                    "type": "GET",
                    "data": {_token: "{{csrf_token()}}"}
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},                  
                    {"data": "action"}
                ],
                "buttons": [{text: 'Add New',className: 'btn btn-block btn-primary add-departments-data',}],
                "initComplete": function(settings, json) {
                    $("#tbl_departments").DataTable().buttons().container()
                        .appendTo( '#tbl_departments_wrapper .col-md-6:eq(0)');             
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
                            $('#tbl_departments').DataTable().ajax.reload();
                            }else{
                                toastr.error('Error data do not save !!!')
                            }

                        }
                });

            }
        });



         $('#manage_form').validate({
                rules: {
                
                    name: {
                        required: true,
                    },
                                      
                },
                messages: {

                    name: {
                        required: "Please provide a Name",
                    }
                   
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
        $('body').on('click', '.add-departments-data', function () {
            $('#manageData_modal').modal('show');
            $("#manage_form").attr('action', '/getDepartments/create');
            $('#btnsave').show();
            $('#name').removeAttr("disabled"); 
            
            $('#id').val('0');
            $('#name').val('');
          });
      

         //Edit Countries
        $('body').on('click', '.btn-departments-edit', function () {
            var dataId = $(this).attr("data-id");
            $("#manage_form").attr('action', '/getDepartments/create');
            console.log('a');
            //call getDepartments
            getDepartments(dataId);
            $('#btnsave').show();
            $('#name').val('');
          
        });

     
        //Delete Countries
        $('body').on('click', '.btn-departments-delete', function () {
            var dataId = $(this).attr("data-id");
            //call delete function
            deletetDepartments(dataId);
        });
  
         //get Countries data from controller
       function getDepartments(dataId){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                        url:"/getDepartments/edit/"+dataId,
                        method:"GET",
                        success:function(data){
                          $('#name').val(data.name);
                          $('#country_code').val(data.country_code);
                          $('#id').val(data.id);
                           
                            $('#manageData_modal').modal('show');

                        }
                });
        }




      //Delete Animal Type
        function deletetDepartments(dataId){
                var _token = $('input[name="_token"]').val();
                if(confirm("Are You sure want to delete !"))
              {
                $.ajax({
                        url:"Departments/delete/"+dataId,
                        method:"GET",
                        success:function(data){
                          console.log(data);
                          if (data['status']==true) {
                                 toastr.success('Successfull Delete your data !!!')
                            $('#tbl_departments').DataTable().ajax.reload();
                            }else{
                               
                                toastr.error('Error data do not delete !!!')

                            }

                        }
                });
              }
        }  

    });     

</script>