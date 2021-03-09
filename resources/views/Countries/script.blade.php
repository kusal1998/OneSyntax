<script>
    
    $(document).ready(function () {
            $("#tbl_countries").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "ajax": {
                    "url": '/getCountries',
                    "dataType": "json",
                    "type": "GET",
                    "data": {_token: "{{csrf_token()}}"}
                },
                "columns": [
                    {"data": "id"},
                    {"data": "country_code"},
                    {"data": "name"},                  
                    {"data": "action"}
                ],
                "buttons": [{text: 'Add New',className: 'btn btn-block btn-primary add-countries-data',}],
                "initComplete": function(settings, json) {
                    $("#tbl_countries").DataTable().buttons().container()
                        .appendTo( '#tbl_countries_wrapper .col-md-6:eq(0)');             
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
                            $('#tbl_countries').DataTable().ajax.reload();
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
                    country_code: {
                        required: true,
                    }
                                      
                },
                messages: {

                    name: {
                        required: "Please provide a Name",
                    },
                    country_code: {
                        required: "Please provide a country code",
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
        $('body').on('click', '.add-countries-data', function () {
            $('#manageData_modal').modal('show');
            $("#manage_form").attr('action', '/getCountries/create');
            $('#btnsave').show();
            $('#name').removeAttr("disabled"); 
            $('#country_code').removeAttr("disabled");
            
            $('#id').val('0');
            $('#country_code').val('');
            $('#name').val('');
          });
      

         //Edit Countries
        $('body').on('click', '.btn-countries-edit', function () {
            var dataId = $(this).attr("data-id");
            $("#manage_form").attr('action', '/getCountries/create');
            console.log('a');
            //call getCountries
            getCountries(dataId);
            $('#btnsave').show();
            $('#country_code').val('');
            $('#name').val('');
          
        });

     
        //Delete Countries
        $('body').on('click', '.btn-countries-delete', function () {
            var dataId = $(this).attr("data-id");
            //call delete function
            deleteCountries(dataId);
        });
  
         //get Countries data from controller
       function getCountries(dataId){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                        url:"/getCountries/edit/"+dataId,
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
        function deleteCountries(dataId){
                var _token = $('input[name="_token"]').val();
                if(confirm("Are You sure want to delete !"))
              {
                $.ajax({
                        url:"Countries/delete/"+dataId,
                        method:"GET",
                        success:function(data){
                          console.log(data);
                          if (data['status']==true) {
                                toastr.success('Successfull Delete your data !!!')
                            $('#tbl_countries').DataTable().ajax.reload();
                            }else{

                                toastr.error('Error data do not delete !!!')

                            }

                        }
                });
              }
        }  

    });     

</script>