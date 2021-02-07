@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <section class="section-pagetop bg-white">
        <div class="container clearfix">
            <h2 class="title-page">{{ $pageTitle }}</h2>
            @if($order->payment_status == 1)
            <p class="alert alert-success">Order Success</p>
            @else
            <p class="alert alert-warning">Order unsuccessful</p>
            @endif

        </div>
    </section>
    <section class="section-content bg padding-y border-top">
        <div class="container">
            {{-- <div class="row">
                <main class="col-sm-12">
                    <p class="alert alert-success">Your order placed successfully. Your order number is : {{ $order->order_number }}.</p>
                </main>
            </div> --}}

            <div class="row">
                <aside class="col-md-9 mx-auto">
                <!-- ============================ COMPONENT 3  ================================= -->
                    <div class="card mb-3 ">
                        <article class="card-body border-top">
                            {{-- {{ $request->status_id }} --}}
                            @if($order->payment_status == 1)
                                <p class="alert alert-success">Your order placed successfully. Your order number is : {{ $order->order_number }}.</p>
                            @else
                                <p class="alert alert-danger">Your order is not successfull. please check with your personal shopper for more info. Or made new payment. Thank you</p>
                            @endif


                            <dl class="row">
                                <dt class="col-sm-12">Pesonal Shopper : <span class="float-right text-muted">{{ $order->user->name }}</span></dt>
                                <dt class="col-sm-12">Phone : <span class="float-right text-muted">{{ $order->user->country_code }}{{ $order->user->mobile }}</span></dt>
                                <dt class="col-sm-12">Email : <span class="float-right text-muted">{{ $order->user->email }}</span></dt>
                            </dl>
                            <hr>
                            <dl class="row">
                            <dt class="col-sm-12">Name : <span class="float-right text-muted">{{ $order->name }}</span></dt>

                            <dt class="col-sm-12">Phone : <span class="float-right text-muted">{{ $order->phone_number }}</span></dt>
                            <dt class="col-sm-12">Email : <span class="float-right text-muted">{{ $order->email }}</span></dt>

                            <dt class="col-sm-8">Address: <span class="float-right text-muted"></span></dt>
                            <dd class="col-sm-4 text-right text-success"><strong>{{ $order->address }} {{ $order->postcode}} {{ $order->city}} {{ $order->state }} {{ $order->country }}</strong></dd>
                            </dl>
                            <hr>
                        </article> <!-- card-body.// -->
                        <article class="card-body">
                            <header class="mb-4">

                                <h4 class="card-title">Order number : {{ $order->order_number }}</h4>

                            </header>
                                <div class="row">
                                    @foreach( $products as $product)
                                    <div class="col-md-6">
                                        <figure class="itemside  mb-3">
                                            <div class="aside">
                                                @if($product->images->count() > 0)
                                                <img src="{{ asset('storage/'.$product->images->first()->full) }}" class="border img-md">
                                                @else
                                                <img src="https://via.placeholder.com/176" class="border img-md">
                                                @endif
                                            </div>
                                            <figcaption class="info">
                                                <p>{{ $product->name }}</p>
                                                <span>{{ $product->pivot->quantity }} x {{ config('settings.currency_symbol'). number_format((float)$product->pivot->price, 2, '.', '')}} = Total: {{ config('settings.currency_symbol'). number_format((float)$product->pivot->price * $product->pivot->quantity, 2, '.', '')}} </span>
                                            </figcaption>
                                        </figure>
                                    </div> <!-- col.// -->
                                    @endforeach
                                </div> <!-- row.// -->
                        </article> <!-- card-body.// -->
                        <article class="card-body border-top">

                            <dl class="row">
                            <dt class="col-sm-10">Subtotal: <span class="float-right text-muted">{{ $order->item_count }} items</span></dt>
                            <dd class="col-sm-2 text-right"><strong>{{ config('settings.currency_symbol'). number_format((float)$order->sub_total, 2, '.', '')}} </strong></dd>

                            {{-- <dt class="col-sm-10">Discount: <span class="float-right text-muted">10% offer</span></dt>
                            <dd class="col-sm-2 text-danger text-right"><strong>$29</strong></dd> --}}

                            <dt class="col-sm-10">Delivery charge: <span class="float-right text-muted">{{ $order->delivery_method }}</span></dt>
                            <dd class="col-sm-2 text-right"><strong>{{ config('settings.currency_symbol'). number_format((float)$order->delivery_price, 2, '.', '')}}</strong></dd>

                            <dt class="col-sm-10">Tax: <span class="float-right text-muted">{{ config('settings.tax')}}%</span></dt>
                            <dd class="col-sm-2 text-right text-success"><strong>{{ config('settings.currency_symbol'). number_format((float)$order->tax, 2, '.', '')}}</strong></dd>

                            <dt class="col-sm-10">Total:</dt>
                            <dd class="col-sm-2 text-right"><strong class="h5 text-dark">{{ config('settings.currency_symbol'). number_format((float)$order->grand_total, 2, '.', '')}}</strong></dd>
                            </dl>
                            @if($order->payment_status != 1)
                            <a href="https://dev.toyyibpay.com/{{$order->payment_code}}" class="btn btn-primary btn-block"> Make Purchase </a>
                            @endif

                        </article> <!-- card-body.// -->
                    </div> <!-- card.// -->
                </aside>
            <!-- ============================ COMPONENT 3  ================================= -->
            </div> <!-- row.// -->
        </div>
    </section>
@stop
