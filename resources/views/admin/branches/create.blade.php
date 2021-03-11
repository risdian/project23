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
                <form action="{{ route('admin.branches.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
                            @error('name') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="phone_number">Phone number <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"/>
                            @error('phone_number') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address">Address <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ old('address') }}"/>
                            @error('address') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="postcode">postcode <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('postcode') is-invalid @enderror" type="text" name="postcode" id="postcode" value="{{ old('postcode') }}"/>
                            @error('postcode') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="city">City <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" id="city" value="{{ old('city') }}"/>
                            @error('city') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="state">State <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('state') is-invalid @enderror" type="text" name="state" id="state" value="{{ old('state') }}"/>
                            @error('state') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="country">Country <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" id="country" value="{{ old('country') }}"/>
                            @error('country') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Branch</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.branches.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
