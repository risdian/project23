@extends('site.app')
@section('title', $product->name)
@section('content')
    <section class="section-content bg padding-y border-top" id="site">
        <div class="container">

            <!-- ============================ COMPONENT 1 ================================= -->
            <div class="card">
                <div class="row no-gutters">
                    <aside class="col-md-6">
            <article class="gallery-wrap">
                <div class="img-big-wrap">
                    <a href="#">
                @if ($product->images->count() > 0)
                    <img src="{{ asset('storage/'.$product->images->first()->full) }}">
                @else
                    <img src="../images/items/12.jpg">
                @endif
                    </a>
                </div> <!-- img-big-wrap.// -->
                @if ($product->images->count() > 0)
                <div class="thumbs-wrap">
                    @foreach ($product->images as $item)
                    <a href="#" class="item-thumb"><img src="{{ asset('storage/'.$item->full) }}">></a>
                    @endforeach
                </div> <!-- thumbs-wrap.// -->
                @endif
            </article> <!-- gallery-wrap .end// -->
                    </aside>
                    <main class="col-md-6 border-left">
            <article class="content-body">

            <h2 class="title">{{ $product->name }}</h2>

            <div class="mb-3">

                @if ($product->sale_price > 0)
                    <var class="price h4 text-danger">
                        <span class="currency">{{ config('settings.currency_symbol') }}</span><span class="num" id="productPrice">{{ $product->sale_price }}</span>
                        <del class="price-old"> {{ config('settings.currency_symbol') }}{{ $product->price }}</del>
                    </var>
                @else
                <var class="price h4 text-success">
                    <span class="currency">{{ config('settings.currency_symbol') }}</span><span class="num" id="productPrice">{{ $product->price }}</span>
                </var>
                @endif
                <span class="text-muted">/per Unit</span>
            </div>

            <p>
                {{ $product->description }}
            </p>

            <dl class="row">
            <dt class="col-sm-3">Category#</dt>
            <dd class="col-sm-9">{{ $product->category->name }}</dd>

            <dt class="col-sm-3">Quantity</dt>
            <dd class="col-sm-9">{{ $product->quantity }}</dd>

            <dt class="col-sm-3">Delivery From</dt>
            <dd class="col-sm-9">{{ $product->branch->name }}</dd>
            </dl>

            <hr>
                <a href="{{ route('product.click', $product->id) }}" class="btn  btn-primary"> Contact Personal Shopper </a>
            </article> <!-- product-info-aside .// -->
                    </main> <!-- col.// -->
                </div> <!-- row.// -->
            </div> <!-- card.// -->
<!-- ============================ COMPONENT 1 END .// ================================= -->

<br><br>
        </div>
    </section>
@stop
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#addToCart').submit(function (e) {
                if ($('.option').val() == 0) {
                    e.preventDefault();
                    alert('Please select an option');
                }
            });
            $('.option').change(function () {
                $('#productPrice').html("{{ $product->sale_price != '' ? $product->sale_price : $product->price }}");
                let extraPrice = $(this).find(':selected').data('price');
                let price = parseFloat($('#productPrice').html());
                let finalPrice = (Number(extraPrice) + price).toFixed(2);
                $('#finalPrice').val(finalPrice);
                $('#productPrice').html(finalPrice);
            });
        });
    </script>
@endpush
