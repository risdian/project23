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
                <form action="{{ route('admin.items.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="branch">Branch</label>
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <select name="branch" id="branch" class="form-control @error('branch') is-invalid @enderror"
                            >
                                <option value="0">Select a branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ ( old("branch", $item->product->branch_id) == $branch->id ? "selected":"") }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback active">
                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('branch') <span>{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="product_id">Product</label>
                            <select class="browser-default custom-select  @error('product_id') is-invalid @enderror" name="product_id" id="product_id" data-selected-subcategory="{{ old('product_id', $item->product_id) }}" >
                            </select>
                            <div class="invalid-feedback active">
                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('product_id') <span>{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="image">Item Image</label>
                            @if ($item->image != null)
                                <figure class="mt-2" style="width: 80px; height: auto;">
                                        <img src="{{ asset('storage/'.$item->image) }}" id="itemImage" class="img-fluid" alt="img">
                                </figure>
                            @endif
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea name="description" id="description" rows="8" class="form-control">{{ old('description', $item->description) }}</textarea>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Item</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.categories.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {


        var OldValue = '{{ old('branch', $item->product->branch_id) }}';
        console.log(OldValue);
        if(OldValue !== '') {

            $('#branch').val(OldValue );
            var bran_id = '{{ old('branch', $item->product->branch_id) }}';

            // this will load subcategories once you set the category value
            $.ajax({
                url:"{{ route('admin.items.subcat') }}",
                type:"POST",
                    data: {
                        bran_id: bran_id
                    },
                success:function (data) {
                    $('#product_id').empty();
                    $.each(data.products[0].products,function(index,product){
                        $('#product_id').append('<option value="'+product.id+'">'+product.name+'</option>');
                    });

                    // take subcategory value which has been selected in data attribute
                    var subCategoryVal = $("#product_id").attr("data-selected-subcategory");
                    if(subCategoryVal !== '')
                    {
                        console.log(subCategoryVal);
                        // assign chosen data attribute value to select
                        $("#product_id").val(subCategoryVal);
                    }

                }
            })
        }

        $('#branch').change(function(e) {

            var bran_id = e.target.value;
            // console.log(bran_id);
            $.ajax({
                url:"{{ route('admin.items.subcat') }}",
                type:"POST",
                    data: {
                        bran_id: bran_id
                    },
                success:function (data) {
                    $('#product_id').empty();
                    $.each(data.products[0].products,function(index,product){
                        $('#product_id').append('<option value="'+product.id+'">'+product.name+'</option>');
                    });

                }
            })
        });
    });
</script>
@endpush
