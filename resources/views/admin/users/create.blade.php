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
                            <label class="control-label">Nric</label>
                            <input class="form-control @error('nric') is-invalid @enderror" type="text" id="nric" name="nric"  value="{{ old('nric') }}"/>
                            @error('nric') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mobile</label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" id="mobile" name="mobile" value="{{ old('mobile') }}"/>
                            @error('mobile') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}"/>
                            @error('email') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Role</label>
                            <select id="roles" class="form-control custom-select mt-15 @error('roles') is-invalid @enderror" name="roles">
                                <option value="0">Select a Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @if (old('roles') == $role->id)
                                        selected  @endif> {{ $role->name }} </option>
                                @endforeach
                            </select>
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
