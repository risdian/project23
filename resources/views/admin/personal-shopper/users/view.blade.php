@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @include('admin.partials.flash')

     <div class="row user">
        <div class="col-md-12">
            <div class="tile" >
                <h3 class="tile-title">Monthly Sales</h3>
                <div class="embed-responsive" style=" height:20vh;">
                    <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row user">

        <div class="col-md-3">
            <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
                <li class="nav-item"><a class="nav-link active" href="#user-details" data-toggle="tab">Details</a></li>
                <li class="nav-item"><a class="nav-link" href="#user-sale" data-toggle="tab">Sale</a></li>
                <li class="nav-item"><a class="nav-link" href="#user-profile" data-toggle="tab">Profile</a></li>
            </ul>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content">
            <div class="tab-pane active" id="user-details">
                <div class="tile user-details">
                    {{-- <h4 class="line-head">Details</h4>
                    <div class="row">
                        <div class="col-md-8">
                            <label>Total Sale : {{ $total_sale }}</label>
                        </div>
                        <div class="col-md-8">
                            <label>Number of Sale : {{ $productCount }}</label>
                        </div>
                        <div class="col-md-8">
                            <label>Total commission : {{ $total_commission }}</label>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Date </th>
                                <th> Sale </th>
                                <th> No. of sale </th>
                                <th> Commission </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_commission as $list)
                                <tr>
                                    <td> {{ $list->date }} </td>
                                    <td> {{ number_format((float)$list->sale , 2, '.', '')}} </td>
                                    <td> {{ $list->count }}</td>
                                    <td> {{ number_format((float)$list->commission , 2, '.', '')}} </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table> --}}
                </div>
            </div>
            <div class="tab-pane" id="user-sale">
                <div class="tile user-details">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Order No. </th>
                                <th> Status </th>
                                <th> Created At </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td> {{ $order->id }} </td>
                                    <td> {{ $order->order_number }} </td>
                                    <td> {{ $order->status }} </td>
                                    <td> {{ $order->created_at }} </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.personal-shopper.users.view', $order->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="user-profile">
                <div class="tile user-profile">
                <h4 class="line-head">Profile</h4>
                <form>
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label>Name</label>
                            <input class="form-control" type="text" value="{{ $personal_shopper->name }}">
                        </div>
                        <div class="col-md-8 mb-4">
                            <label>Email</label>
                            <input class="form-control" type="email" value="{{ $personal_shopper->email }}">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-8 mb-4">
                            <label>NRIC</label>
                            <input class="form-control" type="text" value="{{ $personal_shopper->nric }}">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-8 mb-4">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" value="{{ $personal_shopper->mobile }}">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-8 mb-4">
                            <label>Parent</label>
                            <input class="form-control" type="text" value="{{ $personal_shopper->parent->name }}" disabled>
                        </div>
                    </div>
                    <div class="row mb-10">
                        <div class="col-md-12">
                            {{-- <button class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button> --}}
                        </div>
                    </div>
                </form>
                </div>
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
