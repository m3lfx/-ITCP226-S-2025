@extends('layouts.base')

@section('body')
    <div class="container">
        {!! Form::open(['route' => 'items.store']) !!}
        {!! Form::close() !!}
    </div>
@endsection
