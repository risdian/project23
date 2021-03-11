@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-bar-chart"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <section class="invoice">
                    <div class="row mb-4">
                        <div class="col-6">
                            <h2 class="page-header"><i class="fa fa-globe"></i> {{ $order->order_number }}</h2>
                        </div>
                        <div class="col-6">
                            <h5 class="text-right">Date: {{ $order->created_at->toFormattedDateString() }}</h5>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-4">Placed By
                            <address><strong>{{ $order->user->name }}</strong><br>Email: {{ $order->user->email }}<br>Phone: {{ $order->user->mobile }}</address>
                        </div>
                        <div class="col-4">Ship To
                            <address>
                                <strong>{{ $order->name }} </strong><br>
                                Address : {{ $order->address }} {{ $order->city }}, {{ $order->country }} {{ $order->post_code }}<br>
                                Phone : {{ $order->phone_number }}<br>
                                Email : {{ $order->email }}<br>
                            </address>
                        </div>
                        <div class="col-4">
                            <b>Order ID:</b> {{ $order->order_number }}<br>
                            <b>Amount:</b> {{ config('settings.currency_symbol') }}{{ round($order->grand_total, 2) }}<br>
                            <b>Payment Method:</b> {{ $order->payment_method }}<br>
                            <b>Payment Status:</b>
                            @if ($order->payment_status == 1)
                            <span class="badge badge-success">Completed</span>
                            @else
                                <span class="badge badge-danger">Not Completed</span>
                            @endif
                            <br>
                            <b>Order Status:</b>
                            @if ($order->status == 'pending')
                                <span class="badge badge-warning">{{ $order->status }}</span>
                            @elseif($order->status == 'processing')
                                <span class="badge badge-info">{{ $order->status }}</span>
                            @elseif($order->status == 'completed')
                                <span class="badge badge-success">{{ $order->status }}</span>
                            @elseif($order->status == 'decline')
                                <span class="badge badge-danger">{{ $order->status }}</span>
                            @endif
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Product</th>
                                    <th>SKU #</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->products as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->sku }}</td>
                                            <td>{{ $item->pivot->quantity }}</td>
                                            <td>{{ config('settings.currency_symbol') }}{{ round($item->pivot->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-8"></div>
                        <!-- /.col -->
                        <div class="col-4">
                            <div class="table-responsive">
                                <table class="table">

                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td class="text-right">{{ config('settings.currency_symbol'). number_format((float)$order->sub_total, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Tax {{ ($order->tax / $order->sub_total ) * 100 }}%:</th>
                                        <td class="text-right">{{ config('settings.currency_symbol'). number_format((float)$order->tax, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping :</th>
                                        <td class="text-right">{{ config('settings.currency_symbol'). number_format((float)$order->delivery_price, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td class="text-right">{{ config('settings.currency_symbol'). number_format((float)$order->grand_total, 2, '.', '')}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    {{-- <div class="row no-print">
                        <div class="col-12">
                            <a href="" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                            <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-success float-right"><i class="fa fa-credit-card"></i>
                                Update Order
                            </button>
                        </div>
                    </div> --}}
                </section>
            </div>
        </div>
    </div>
@endsection
