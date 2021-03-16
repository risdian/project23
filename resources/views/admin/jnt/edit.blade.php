@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-briefcase"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.jnt.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="shipping_type">Shipping Type <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('shipping_type') is-invalid @enderror" type="text" name="shipping_type" id="shipping_type" value="{{ old('shipping_type', $rates->shipping_type) }}"/>
                            <input type="hidden" name="id" value="{{ $rates->id }}">
                            @error('shipping_type') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="country">Country <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" id="country" value="{{ old('country', $rates->country ) }}"/>
                            @error('country') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="region">Region <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('region') is-invalid @enderror" type="text" name="region" id="region" value="{{ old('region', $rates->region) }}"/>
                            @error('region') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="zip_from">Zip from <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('zip_from') is-invalid @enderror" type="text" name="zip_from" id="zip_from" value="{{ old('zip_from', $rates->zip_from) }}"/>
                            @error('zip_from') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="zip_to">Zip to <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('zip_to') is-invalid @enderror" type="text" name="zip_to" id="zip_to" value="{{ old('zip_to', $rates->zip_to) }}"/>
                            @error('zip_to') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="weight_from">Weight From <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('weight_from') is-invalid @enderror" type="text" name="weight_from" id="weight_from" value="{{ old('weight_from', $rates->weight_from) }}"/>
                            @error('weight_from') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="weight_to">Weight To <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('weight_to') is-invalid @enderror" type="text" name="weight_to" id="weight_to" value="{{ old('weight_to', $rates->weight_to) }}"/>
                            @error('weight_to') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="price">Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value="{{ old('price', $rates->price) }}"/>
                            @error('price') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Rates</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.jnt.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
