@extends('layouts.base')

@section('title')
    Laravel Shopping Cart
@endsection

@section('body')
   {{-- {{ dd($products)}} --}}
    @if (Session::has('cart'))
    
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <ul class="list-group">
                    @foreach ($products as $product)
                        <li class="list-group-item">
                            <span class="badge rounded-pill bg-danger">{{ $product['qty'] }}</span>
                            <strong>{{ $product['item']['description'] }}</strong>
                            <span class="label label-success">{{ $product['price'] }}</span>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                  Choose
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                   <li><a href="{{ route('reduceByOne', $product['item']['item_id']) }}">Reduce By 1</a></li> 
                                        <li><a href="{{ route('removeItem', $product['item']['item_id']) }}">Reduce All</a></li> 
                                        {{-- <li><a class="dropdown-item" href="#">Reduce By 1</a></li> --}}

                                        {{-- <li><a class="dropdown-item" href="#">Reduce All</a></li> --}}
                                </ul>
                              </div>
                          
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <strong>Total: {{ $totalPrice }}</strong>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                {{-- <a href="{{ route('checkout') }}" type="button" class="btn btn-success">Checkout</a> --}}
                <a href="#" type="button" class="btn btn-success">Checkout</a>

            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <h2>No Items in Cart!</h2>
            </div>
        </div>
    @endif
@endsection
