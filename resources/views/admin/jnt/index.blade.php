@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-briefcase"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.jnt.create') }}" class="btn btn-primary pull-right">Add New Rates</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> Shipping method </th>
                            <th> Country </th>
                            <th> Region </th>
                            <th> Zip from </th>
                            <th> Zip To </th>
                            <th> Weight From </th>
                            <th> Weight To </th>
                            <th> Price</th>
                            <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($jnt as $shipping)
                            <tr>
                                <td>{{ $shipping->id }}</td>
                                <td>{{ $shipping->shipping_type }}</td>
                                <td>{{ $shipping->country }}</td>
                                <td>{{ $shipping->region }}</td>
                                <td>{{ $shipping->zip_from }}</td>
                                <td>{{ $shipping->zip_to }}</td>
                                <td>{{ $shipping->weight_from }}</td>
                                <td>{{ $shipping->weight_to }}</td>
                                <td>{{ $shipping->price }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Second group">
                                        <a href="{{ route('admin.jnt.edit', $shipping->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush
