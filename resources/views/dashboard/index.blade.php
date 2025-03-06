@extends('layouts.base')
@section('body')
    @include('layouts.flash-messages')
    <div class="row">
        <div class="container">
            {{ Auth::check() ? Auth::user()->name : '' }}
            <div class="container">
                <hr>
                <h2>customer chart</h2>
               {!! $customerChart->container() !!}
               {!! $customerChart->script() !!}
            </div>
            <div class="container">
                <hr>
                <h2>sales chart</h2>
               {!! $salesChart->container() !!}
               {!! $salesChart->script() !!}
            </div>

            <div class="container">
                <hr>
                <h2>sales chart</h2>
               {!! $itemChart->container() !!}
               {!! $itemChart->script() !!}
            </div>
        </div>
        
    @endsection
