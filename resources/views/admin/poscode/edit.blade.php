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
                <form action="{{ route('admin.poscode.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="region">Region <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('region') is-invalid @enderror" type="text" name="region" id="region" value="{{ old('region', $poscode->region) }}"/>
                            <input type="hidden" name="id" value="{{ $poscode->id }}">
                            @error('region') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="poscode">Poscode <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('poscode') is-invalid @enderror" type="text" name="poscode" id="poscode" value="{{ old('poscode', $poscode->poscode) }}"/>
                            @error('poscode') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="state">State <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('state') is-invalid @enderror" type="text" name="state" id="state" value="{{ old('state', $poscode->state) }}"/>
                            @error('state') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="country">Country <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" id="country" value="{{ old('country', $poscode->country) }}"/>
                            @error('country') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save poscode</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.poscode.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
