@extends('site.app')
@section('title', 'Homepage')

@section('content')

<!-- ========================= SECTION  ========================= -->
<section class="section-name  padding-y-sm">
    <div class="container">

    <header class="section-heading">
        <a href="#" class="btn btn-outline-primary float-right">See all</a>
        <h3 class="section-title">Popular products</h3>
    </header><!-- sect-heading -->


    <div class="row">
        @foreach ($items as $item)
        <div class="col-md-3">
            <div href="{{ route('product.show', $item->slug) }}" class="card card-product-grid">
                <a href="{{ route('product.show', $item->slug) }}" class="img-wrap">
                    @if($item->images->count() > 0)
                    <img src="{{ asset('storage/'.$item->images->first()->full) }}">
                    @else
                    <img src="https://via.placeholder.com/176">
                    @endif
                </a>
                <figcaption class="info-wrap">
                    <a href="{{ route('product.show', $item->slug) }}"  class="title">{{ $item->name }}</a>
                    @if ($item->sale_price > 0)
                        <var class="price h4 text-danger">
                            <span class="currency">{{ config('settings.currency_symbol') }}</span><span class="num" id="productPrice">{{ $item->sale_price }}</span>
                            <del class="price-old"> {{ config('settings.currency_symbol') }}{{ $item->price }}</del>
                        </var>
                    @else
                    <var class="price h4 text-success">
                        <span class="currency">{{ config('settings.currency_symbol') }}</span><span class="num" id="productPrice">{{ $item->price }}</span>
                    </var>
                    @endif
                </figcaption>
            </div>
        </div> <!-- col.// -->
        @endforeach
    </div> <!-- row.// -->

    </div><!-- container // -->
    </section>
    <!-- ========================= SECTION  END// ========================= -->


<!-- ========================= SECTION  ========================= -->
<section class="section-name padding-y bg">
    <div class="container">

    <div class="row">
    <div class="col-md-6">
        <h3>Download app demo text</h3>
        <p>Get an amazing app  to make Your life easy</p>
    </div>
    <div class="col-md-6 text-md-right">
        <a href="#"><img src="images/misc/appstore.png" height="40"></a>
        <a href="#"><img src="images/misc/appstore.png" height="40"></a>
    </div>
    </div> <!-- row.// -->
    </div><!-- container // -->
    </section>
    <!-- ========================= SECTION  END// ======================= -->


@stop
