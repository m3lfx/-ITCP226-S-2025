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
        </div>
        
    @endsection
