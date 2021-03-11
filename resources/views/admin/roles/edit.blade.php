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
                <form action="{{ route('admin.roles.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $role->name) }}"/>
                            <input type="hidden" name="id" value="{{ $role->id }}">
                            @error('name') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <strong>Permission</strong>
                            <div class="form-check">
                                @foreach($permissions as $permission)
                                    <label class="form-check-label">
                                    <input class="form-check-input @error('permission') is-invalid @enderror"
                                            type="checkbox"
                                            id="permission"
                                            name="permission[]"
                                            value="{{$permission->id}}"
                                            @if(is_array(old('permission', $rolePermissions)) && in_array( $permission->id,old('permission' , $rolePermissions))) checked @endif
                                            />{{ $permission->name }}
                                    </label>
                                    <br/>
                                @endforeach
                            </div>
                            @error('permission') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Role</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.roles.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
