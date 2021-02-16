@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="#" method="POST" role="form" enctype="multipart/form-data" id="dynamic_form">
                    @csrf

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" id="name">
                     </div>

                    <table class="table table-bordered" id="dynamic_field">
                        <tr id="row.1">
                             <td>
                                 <input type="text" name="price[]" placeholder="Enter price" class="form-control price_list" />
                                 <div class="alert-message " id="price.0"></div>
                            </td>
                             <td>
                                 <input type="text" name="min[]" placeholder="Enter Mininmum" class="form-control min_list" />
                                 <div class="alert-message " id="min.0"></div>
                            </td>
                             <td>
                                 <input type="text" name="max[]" placeholder="Enter Maximum" class="form-control max_list" />
                                 <div class="alert-message " id="max.0"></div>
                            </td>
                             <td><button type="button" name="add" id="add" class="btn btn-success">+</button></td>
                        </tr>
                   </table>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit" name="save" id="save"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Commission</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.commissions.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/popper.min.js')}}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/main.js') }}"></script>
    <script>
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json'
            });

             var i=0;
             $('#add').click(function(){
                  i++;
                  $('#dynamic_field').append('<tr id="row.'+i+'"><td><input type="text" name="price[]" placeholder="Enter price" class="form-control price_list" /> <div class="alert-message " id="price.'+i+'"></div></td><td><input type="text" name="min[]" placeholder="Enter Mininmum" class="form-control min_list" /> <div class="alert-message " id="min.'+i+'"></td><td><input type="text" name="max[]" placeholder="Enter Maximum" class="form-control max_list" /> <div class="alert-message " id="max.'+i+'"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
             });
             $(document).on('click', '.btn_remove', function(){
                  var button_id = $(this).attr("id");
                  $('#row'+button_id+'').remove();
             });

             $('#dynamic_form').on('submit', function(event){
                event.preventDefault();
                let form_data = $("#dynamic_form").serialize()
                $.ajax({

                    url:'{{ route("admin.commissions.store") }}',
                    method:'post',
                    data : form_data,
                    dataType:'json',
                    beforeSend:function(){
                        $('#save').attr('disabled','disabled');
                    },
                    success:function(data)
                    {

                        $('#save').attr('disabled', false);

                    },
                        error:function (response){

                            $.each(response.responseJSON.errors,function(field_name,error){

                                $('#dynamic_form').find('[id="'+field_name+'"]').after('<span class="text-strong danger">' +error+ '</span>')
                            })

                            $('#save').attr('disabled', false);

                        }
                })

             });
        });
        </script>
@endsection
