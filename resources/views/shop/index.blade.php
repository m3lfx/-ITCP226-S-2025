@extends('layouts.base')
@section('title')
    laravel shopping cart
@endsection
@section('body')
    
    @include('layouts.flash-messages')
   
    @foreach ($items->chunk(4) as $itemChunk)
        <div class="row">
            @foreach ($itemChunk as $item)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="{{ Storage::url($item->image) }}" alt="..." class="img-responsive" width="250px" height="250px">
                        <div class="caption">
                            <h3>{{ $item->description }}<span>${{ $item->sell_price }}</span></h3>

                            <div class="clearfix">
                                {{-- <a href="#" class="btn btn-primary" role="button"><i class="fas fa-cart-plus"></i>
                                    Add to Cart</a> --}}
                                <a href="{{ route('addToCart', $item->item_id) }}" class="btn btn-primary" role="button"><i class="fas fa-cart-plus"></i> Add to Cart</a> 

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
    @endforeach
@endsection
