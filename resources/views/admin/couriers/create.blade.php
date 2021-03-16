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
        <div class="col-md-12 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="#" method="POST" role="form" enctype="multipart/form-data" id="dynamic_form">
                    @csrf
                    <div class="form-group">
                        <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
                        @error('name') {{ $message }} @enderror
                     </div>
                     <div class="form-group">
                        <label class="control-label" for="shipping_method">Shipping method <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('shipping_method') is-invalid @enderror" type="text" name="shipping_method" id="shipping_method" value="{{ old('shipping_method') }}"/>
                        @error('shipping_method') {{ $message }} @enderror
                     </div>
                    <table class="table table-bordered" id="dynamic_field">
                        <tr>
                            <th>Country</th>
                            <th>Region</th>
                            <th>Postcode From</th>
                            <th>Postcode to</th>
                            <th>Weight From</th>
                            <th>Weight to</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                        <tr id="row0">
                            <td>
                                <input type="text" name="country[]" placeholder="Enter country" class="form-control country_list" />
                                <div class="alert-message " id="country.0"></div>
                            </td>
                             <td>
                                 <input type="text" name="region[]" placeholder="Enter region" class="form-control region_list" />
                                 <div class="alert-message " id="region.0"></div>
                            </td>
                             <td>
                                 <input type="text" name="zip_from[]" placeholder="Enter postcode from" class="form-control zip_from_list" />
                                 <div class="alert-message " id="zip_from.0"></div>
                            </td>
                             <td>
                                 <input type="text" name="zip_to[]" placeholder="Enter postcode to" class="form-control zip_to_list" />
                                 <div class="alert-message " id="zip_to.0"></div>
                            </td>
                            <td>
                                <input type="text" name="weight_from[]" placeholder="Enter weight from" class="form-control weight_from_list" />
                                <div class="alert-message " id="weight_from.0"></div>
                           </td>
                            <td>
                                <input type="text" name="weight_to[]" placeholder="Enter weight to" class="form-control weight_to_list" />
                                <div class="alert-message " id="weight_to.0"></div>
                           </td>
                           <td>
                                <input type="text" name="price[]" placeholder="Enter price" class="form-control price_list" />
                                <div class="alert-message " id="price.0"></div>
                            </td>
                             <td><button type="button" name="add" id="add" class="btn btn-success">+</button></td>
                        </tr>
                   </table>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit" name="save" id="save"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Commission</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.couriers.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/popper.min.js')}}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
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
                  $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="country[]" placeholder="Enter country" class="form-control country_list" /><div class="alert-message " id="country.'+i+'"></div></td><td><input type="text" name="region[]" placeholder="Enter region" class="form-control region_list" /><div class="alert-message " id="region.'+i+'"></div></td><td><input type="text" name="zip_from[]" placeholder="Enter postcode from" class="form-control zip_from_list" /><div class="alert-message " id="zip_from.'+i+'"></div></td><td><input type="text" name="zip_to[]" placeholder="Enter postcode to" class="form-control zip_to_list" /><div class="alert-message " id="zip_to.'+i+'"></div></td><td><input type="text" name="weight_from[]" placeholder="Enter weight from" class="form-control weight_from_list" /><div class="alert-message " id="weight_from.'+i+'"></div></td><td><input type="text" name="weight_to[]" placeholder="Enter weight to" class="form-control weight_to_list" /><div class="alert-message " id="weight_to.'+i+'"></div></td><td><input type="text" name="price[]" placeholder="Enter price" class="form-control price_list" /><div class="alert-message " id="price.'+i+'"></div></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');

             });
             $(document).on('click', '.btn_remove', function(){
                  var button_id = $(this).attr("id");
                  $('#row'+button_id+'').remove();
             });

             $('#dynamic_form').on('submit', function(event){
                event.preventDefault();
                let form_data = $("#dynamic_form").serialize()
                $.ajax({

                    url:'{{ route("admin.couriers.store") }}',
                    method:'post',
                    data : form_data,
                    dataType:'json',
                    beforeSend:function(){
                        $('#save').attr('disabled','disabled');
                    },
                    success:function(response)
                    {
                        window.location=response.url;
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
