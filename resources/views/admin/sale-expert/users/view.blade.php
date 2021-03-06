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
                    <h4 class="line-head">Details</h4>
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
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="user-sale">
                @foreach ($products as $product)
                <div class="timeline-post">
                    <div class="post-media">
                        <div class="content">
                            <h5><a href="#">{{ $product->order_number }}</a></h5>
                            <p class="text-muted"><small>{{ $product->created_at }}</small></p>
                            <address><strong>{{ $product->name }}</strong><br>{{ $product->address }}<br>{{ $product->city }}, {{ $product->state }}  {{ $product->country }} {{ $product->postcode }}<br>{{ $product->phone_number }}<br></address>
                        </div>
                    </div>
                </div>
                @endforeach
                {{ $products->links() }}
            </div>
            <div class="tab-pane fade" id="user-profile">
                <div class="tile user-profile">
                <h4 class="line-head">Profile</h4>
                <form action="{{ route('admin.sale-expert.users.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label>Name</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $sale_expert->name) }}"
                            >
                            <input type="hidden" name="id" value="{{ $sale_expert->id }}">
                            @error('name') {{ $message }} @enderror
                        </div>
                        <div class="col-md-8 mb-4">
                            <label>Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{ old('email',$sale_expert->email) }}">
                            @error('email') {{ $message }} @enderror
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-8 mb-4">
                            <label>NRIC</label>
                            <input class="form-control @error('nric') is-invalid @enderror" type="text" name="nric" id="nric" value="{{ old('nric',$sale_expert->nric) }}">
                            @error('nric') {{ $message }} @enderror

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-8 mb-4">
                            <label>Mobile No</label>
                            <input class="form-control @error('mobile') is-invalid @enderror" name="mobile" id="mobile" type="text" value="{{ old('mobile',$sale_expert->mobile) }}">
                            @error('mobile') {{ $message }} @enderror
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-8 mb-4">
                            <label>Parent</label>
                            <input class="form-control" type="text" value="{{ $sale_expert->parent->name }}" disabled>
                        </div>
                    </div>
                    <div class="row mb-10">
                        <div class="col-md-12">
                            {{-- <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save User</button> --}}
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

    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('backend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/popper.min.js')}}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('backend/js/plugins/pace.min.js') }}"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="{{ asset('backend/js/plugins/chart.js') }}"></script>
    @if($list_commission != null)

        <script type="text/javascript">
        var data = {
            labels: {!!json_encode($list_commission->pluck('date'))!!},
            datasets: [
                {
                    label: "Sales",
                    fillColor: "rgba(220,220,220,0.2)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: {!!json_encode($list_commission->pluck('sale'))!!}
                },

            ]
        };

        var ctxl = $("#lineChartDemo").get(0).getContext("2d");
        var lineChart = new Chart(ctxl).Line(data);

        </script>

    @endif

@endpush

