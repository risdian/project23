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
                <form action="{{ route('admin.users.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
                            @error('name') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Country Code</label>
                            <input class="form-control @error('country_code') is-invalid @enderror" type="text" id="country_code" name="country_code"/>
                            @error('country_code') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mobile</label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" id="mobile" name="mobile"/>
                            @error('mobile') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email"/>
                            @error('email') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save User</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.users.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
