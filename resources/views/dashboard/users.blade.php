@extends('layouts.base')
@section('body')
    @include('layouts.flash-messages')
    <div class="row">

        <div class="container">
            {{ Auth::check() ? Auth::user()->name : '' }}

            <div class="container">
                <hr>
                <h2>users list</h2>
                {{ $dataTable->table() }}
            </div>
        </div>
        {{ $dataTable->scripts() }}
    @endsection
