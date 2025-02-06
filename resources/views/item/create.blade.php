@extends('layouts.base')

@section('body')
    <div class="container">
        {!! Form::open(['route' => 'items.store']) !!}
        {!! Form::label('desc', 'item name', ['class' => 'form-label']) !!}
        {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'desc']) !!}
        {!! Form::close() !!}
    </div>
@endsection
