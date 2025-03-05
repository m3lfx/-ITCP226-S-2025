@extends('layouts.base')
@section('body')
    <p>order shipped</p>
    <h2>{{ $orderTotal }}</h2>
    {{dump($order)}}
@endsection