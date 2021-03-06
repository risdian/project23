@extends('site.app')
@section('title', $order->order_number)
@section('content')


<section class="section-content padding-y bg">
    <div class="container">

    <div class="row">
        <aside class="col-md-9 mx-auto">
    <!-- ============================ COMPONENT 3  ================================= -->

    <div class="card mb-3 ">

        <article class="card-body">
            <header class="mb-4">
                <h4 class="card-title">Order number : {{ $order->order_number }}</h4>
                <h4 class="card-title">Tracking number : {{ $order['products']['0']['pivot']['tracking_number'] }}</h4>

            </header>
                <div class="row">
                    @foreach( $order['products'] as $product)
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
                                <p>{{ $product->branch->name }}</p>
                                <p>{{ $product->name }}</p>
                                <span>{{ $product->pivot->quantity }} x {{ config('settings.currency_symbol'). number_format((float)$product->pivot->price, 2, '.', '')}} = Total: {{ config('settings.currency_symbol'). number_format((float)$product->pivot->price * $product->pivot->quantity, 2, '.', '')}} </span>
                            </figcaption>
                        </figure>
                    </div> <!-- col.// -->
                    @endforeach

                    @if($order['products']['0']['pivot']['tracking_number'] != null)
                        @if ($order['products']['0']['pivot']['tracking_status'] == 'received')

                        <a class="btn btn-primary btn-block"> Thank you for your purchase
                        </a>

                        @else
                            <a href="{{ route('site.shippings.update',  $order['products']['0']['pivot']['tracking_number'] ) }}" class="btn btn-primary btn-block"> I have received the parcel
                            </a>
                        @endif

                    @else

                        <a href="" class="btn btn-warning btn-block">Your parcel number is not active, please Contact your Personal Shopper </a>

                    @endif



                </div> <!-- row.// -->
        </article> <!-- card-body.// -->

    </div> <!-- card.// -->
        </aside>
    <!-- ============================ COMPONENT 3  ================================= -->
    </div> <!-- row.// -->


    </div> <!-- container .//  -->
</section>
    <!-- ========================= SECTION CONTENT END// ========================= -->

@stop
