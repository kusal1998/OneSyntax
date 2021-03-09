<script>
    
    $(document).ready(function () {
            $("#tbl_states").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "ajax": {
                    "url": '/getStates',
                    "dataType": "json",
                    "type": "GET",
                    "data": {_token: "{{csrf_token()}}"}
                },
                "columns": [
                    {"data": "id"},
                    {"data": "country"},
                    {"data": "name"},                  
                    {"data": "action"}
                ],
                "buttons": [{text: 'Add New',className: 'btn btn-block btn-primary add-states-data',}],
                "initComplete": function(settings, json) {
                    $("#tbl_states").DataTable().buttons().container()
                        .appendTo( '#tbl_states_wrapper .col-md-6:eq(0)');             
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
                                $(document).Toasts('create', {
                                    class: 'bg-success', 
                                    title: 'Alert Success',
                                    body: 'Congrats Succfully Saved Your Data.'
                                })
                            $('#manageData_modal').modal('hide');
                            $('#tbl_states').DataTable().ajax.reload();
                            }else{
                                $(document).Toasts('create', {
                                    class: 'bg-danger', 
                                    title: 'Alert Fail',
                                    body: 'There is a Problem Saving Your Data'
                                })

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
                    country: {
                        required: true,
                    },
                                      
                },
                messages: {

                    name: {
                        required: "Please provide a Name",
                    },
                    country: {
                        required: "Please provide a country",
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
        $('body').on('click', '.add-states-data', function () {
            $('#manageData_modal').modal('show');
            $("#manage_form").attr('action', '/getStates/create');
            $('#btnsave').show();
            $('#name').removeAttr("disabled"); 
            $('#country').removeAttr("disabled");
            
            $('#id').val('0');
            $('#country').val('');
            $('#name').val('');
          });
      

         //Edit Countries
        $('body').on('click', '.btn-states-edit', function () {
            var dataId = $(this).attr("data-id");
            $("#manage_form").attr('action', '/getStates/create');
            console.log('a');
            //call getCountries
            getStates(dataId);
            $('#btnsave').show();
            $('#country').val('');
            $('#name').removeAttr("disabled"); 
          
        });

     
        //Delete Countries
        $('body').on('click', '.btn-states-delete', function () {
            var dataId = $(this).attr("data-id");
            //call delete function
            deleteStates(dataId);
        });
  
         //get Countries data from controller
       function getStates(dataId){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                        url:"/getStates/edit/"+dataId,
                        method:"GET",
                        success:function(data){
                          $('#name').val(data.name);
                          $('#country').val(data.country).trigger('change');
                          $('#id').val(data.id);

                            $('#manageData_modal').modal('show');

                        }
                });
        }




      //Delete Animal Type
        function deleteStates(dataId){
                var _token = $('input[name="_token"]').val();
                if(confirm("Are You sure want to delete !"))
              {
                $.ajax({
                        url:"States/delete/"+dataId,
                        method:"GET",
                        success:function(data){
                          console.log(data);
                          if (data['status']==true) {
                                $(document).Toasts('create', {
                                    class: 'bg-success', 
                                    title: 'Alert Success',
                                    body: 'Congrats Succfully Delete Your Data.'
                                })
                            $('#tbl_states').DataTable().ajax.reload();
                            }else{
                                $(document).Toasts('create', {
                                    class: 'bg-danger', 
                                    title: 'Alert Fail',
                                    body: 'There is a Problem Deleting Your Data'
                                })

                            }

                        }
                });
              }
        }  

    });     

</script>