@extends('site.app')
@section('title', $order->order_number)
@section('content')


<section class="section-content padding-y bg">
    <div class="container">

    <div class="row">
        <aside class="col-md-9 mx-auto">
    <!-- ============================ COMPONENT 3  ================================= -->

    <div class="card mb-3 ">
        <article class="card-body border-top">
            <dl class="row">
                <h5>Order Details</h5>
                <dt class="col-sm-12">Order ID : <span class="float-right text-muted">{{ $order->order_number }}</span></dt>
                <dt class="col-sm-12">Status : <span class="float-right text-muted">{{ $order->status }}</span></dt>
                <dt class="col-sm-12">Order Date : <span class="float-right text-muted">{{ $order->created_at }}</span></dt>
                <dt class="col-sm-12">Payment : <span class="float-right text-muted">{{ $payment }}</span></dt>
                <dt class="col-sm-12">Payment Date : <span class="float-right text-muted">{{ $order->payment_datetime }}</span></dt>
            </dl>
            <hr>
            <dl class="row">
                <h5>Personal Shopper </h5>
                <dt class="col-sm-12">Name : <span class="float-right text-muted">{{ $order->user->name }}</span></dt>
                <dt class="col-sm-12">Phone : <span class="float-right text-muted">{{ $order->user->country_code }}{{ $order->user->mobile }}</span></dt>
                <dt class="col-sm-12">Email : <span class="float-right text-muted">{{ $order->user->email }}</span></dt>
            </dl>
            <hr>
            <dl class="row">
                <h5>Customer Details</h5>
              <dt class="col-sm-12">Name : <span class="float-right text-muted">{{ $order->name }}</span></dt>

              <dt class="col-sm-12">Phone : <span class="float-right text-muted">{{ $order->phone_number }}</span></dt>
              <dt class="col-sm-12">Email : <span class="float-right text-muted">{{ $order->email }}</span></dt>

              <dt class="col-sm-8">Address: <span class="float-right text-muted"></span></dt>
              <dd class="col-sm-4 text-right text-success"><strong>{{ $order->address }} {{ $order->postcode}} {{ $order->city}} {{ $order->state }} {{ $order->country }}</strong></dd>
            </dl>

        </article> <!-- card-body.// -->
    </div>
    @foreach ($result as $key => $product)
    <div class="card mb-3 ">
        <article class="card-body">
            <div class="row">
                @foreach ($product as $item)
                    <div class="col-md-12">
                        <figure class="itemside  mb-3">

                            <div class="aside">
                                @if($item['images']['0']['full'] != null)
                                    <img src="{{ asset('storage/'.$item['images']['0']['full']) }}" class="border img-md">
                                @else
                                    <img src="https://via.placeholder.com/176" class="border img-md">
                                @endif
                            </div>

                            <figcaption class="info">
                                <p><b>{{ $item['name'] }}</b></p>
                                <p>Sku : {{ $item['sku'] }}</p>
                                <p>Category : {{ $item['category']['name'] }}</p>
                                <span>Qty {{ $item['pivot']['quantity'] }} x Price {{ config('settings.currency_symbol'). number_format((float)$item['pivot']['price'], 2, '.', '')}}</span>
                                <p> <b>Total: {{ config('settings.currency_symbol'). number_format((float)$item['pivot']['price'] * $item['pivot']['quantity'], 2, '.', '')}}</b> </p>
                            </figcaption>
                        </figure>
                    </div> <!-- col.// -->
                @endforeach
            </div> <!-- row.// -->
            <hr>
            <dl class="row">
                <dt class="col-sm-12">Branch : <span class="float-right text-muted">{{ $key }}</span></dt>
                <dt class="col-sm-8">Address: <span class="float-right text-muted"></span></dt>
                <dd class="col-sm-4 text-right text-success"><strong>{{ $item['branch']['address'] }} {{ $item['branch']['postcode']}} {{ $item['branch']['city']}} {{ $item['branch']['state'] }} {{ $item['branch']['country'] }}</strong></dd>
                <dt class="col-sm-12">Tracking number : <span class="float-right text-muted">{{ $item['pivot']['tracking_number'] }}</span></dt>
                <br/>
                <br/>
            @if($order->payment_status == 1)
                @if($item['pivot']['tracking_number'] != null)

                    @if ($item['pivot']['tracking_status'] == 'received')
                    <dt class="col-sm-12"> <span class="float-right text-muted">Thank you for your purchase</span></dt>
                    @else
                    <dt class="col-sm-12">Confirm received of products<span class="float-right text-muted"><a href="{{ route('site.shippings.update',  [$item['pivot']['tracking_number'] ,  $order->id]) }}" class="btn btn-primary">Order Received
                    </a></span></dt>
{{--
                    [$tracking->branch_id, $tracking->order_number ])  --}}

                    @endif
                @else
                <dt class="col-sm-12">Your parcel tracking number is not active, please Contact your Personal Shopper<span class="float-right text-muted"><a href="" class="btn btn-warning">Contact</a></span></dt>


                @endif
            @endif
            </dl>

        </article> <!-- card-body.// -->
    </div>
    @endforeach
    <div class="card mb-3 ">
        <article class="card-body border-top">

            <dl class="row">
              <dt class="col-sm-10">Subtotal: <span class="float-right text-muted">{{ $order->item_count }} items</span></dt>
              <dd class="col-sm-2 text-right"><strong>{{ config('settings.currency_symbol'). number_format((float)$order->sub_total, 2, '.', '')}} </strong></dd>

              {{-- <dt class="col-sm-10">Discount: <span class="float-right text-muted">10% offer</span></dt>
              <dd class="col-sm-2 text-danger text-right"><strong>$29</strong></dd> --}}

              <dt class="col-sm-10">Delivery charge: <span class="float-right text-muted">{{ $order->delivery_method }}</span></dt>
              <dd class="col-sm-2 text-right"><strong>{{ config('settings.currency_symbol'). number_format((float)$order->delivery_price, 2, '.', '')}}</strong></dd>

              <dt class="col-sm-10">Tax: <span class="float-right text-muted">{{ config('settings.tax_value')}}%</span></dt>
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


    </div> <!-- container .//  -->
</section>
    <!-- ========================= SECTION CONTENT END// ========================= -->

@stop
