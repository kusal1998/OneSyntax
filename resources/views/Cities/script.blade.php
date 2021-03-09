<script>
    
    $(document).ready(function () {
            $("#tbl_cities").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "ajax": {
                    "url": '/getCities',
                    "dataType": "json",
                    "type": "GET",
                    "data": {_token: "{{csrf_token()}}"}
                },
                "columns": [
                    {"data": "id"},
                    {"data": "state"},
                    {"data": "name"},                  
                    {"data": "action"}
                ],
                "buttons": [{text: 'Add New',className: 'btn btn-block btn-primary add-cities-data',}],
                "initComplete": function(settings, json) {
                    $("#tbl_cities").DataTable().buttons().container()
                        .appendTo( '#tbl_cities_wrapper .col-md-6:eq(0)');             
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
                            $('#tbl_cities').DataTable().ajax.reload();
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
                    state: {
                        required: true,
                    }
                                      
                },
                messages: {

                    name: {
                        required: "Please provide a Name",
                    },
                    state: {
                        required: "Please provide a state",
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
        $('body').on('click', '.add-cities-data', function () {
            $('#manageData_modal').modal('show');
            $("#manage_form").attr('action', '/getCities/create');
            $('#btnsave').show();
            $('#name').removeAttr("disabled"); 
            $('#state').removeAttr("disabled");
            
            $('#id').val('0');
            $('#state').val('');
            $('#name').val('');
          });
      

         //Edit Countries
        $('body').on('click', '.btn-cities-edit', function () {
            var dataId = $(this).attr("data-id");
            $("#manage_form").attr('action', '/getCities/create');
            console.log('a');
            //call getCountries
            getCities(dataId);
            $('#btnsave').show();
            $('#state').val('0').trigger('change');
            $('#name').val('');
          
        });

     
        //Delete Countries
        $('body').on('click', '.btn-cities-delete', function () {
            var dataId = $(this).attr("data-id");
            //call delete function
            deleteCities(dataId);
        });
  
         //get Countries data from controller
       function getCities(dataId){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                        url:"/getCities/edit/"+dataId,
                        method:"GET",
                        success:function(data){
                          $('#state').val(data.state).trigger('change');
                          $('#name').val(data.name);
                          $('#id').val(data.id);

                            $('#manageData_modal').modal('show');

                        }
                });
        }




      //Delete Animal Type
        function deleteCities(dataId){
                var _token = $('input[name="_token"]').val();
                if(confirm("Are You sure want to delete !"))
              {
                $.ajax({
                        url:"Cities/delete/"+dataId,
                        method:"GET",
                        success:function(data){
                          console.log(data);
                          if (data['status']==true) {
                            toastr.success('Successfull Delete your data !!!')
                            $('#tbl_cities').DataTable().ajax.reload();
                            }else{
                                toastr.error('Error data do not delete !!!,')

                            }

                        }
                });
              }
        }  

    });     

</script>