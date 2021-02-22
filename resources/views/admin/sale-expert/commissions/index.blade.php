@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.sale-expert.commissions.create') }}" class="btn btn-primary pull-right">Add Commission</a>
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
                                <th> Creator </th>
                                <th> Start </th>
                                <th> Status </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commissions as $commission)
                                <tr>
                                    <td>{{ $commission->id }} </td>
                                    <td> {{ $commission->user->name }} </td>
                                    <td> {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $commission->start)->format('Y-m') }} </td>
                                    <td>

                                     <form action="{{ route('admin.sale-expert.commissions.status') }}" method="post" id="statusForm{{$commission->id}}">
                                        @csrf
                                         <input name="id" type="hidden" value="{{$commission->id}}">
                                         <input {{ $commission->status == 1 ? 'checked' : '' }}
                                             type="checkbox" name="status"
                                             onchange="document.getElementById('statusForm{{$commission->id}}').submit()"
                                         >
                                         </form>

                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.sale-expert.commissions.edit', $commission->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
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
