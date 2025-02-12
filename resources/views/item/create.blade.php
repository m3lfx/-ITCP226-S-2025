@extends('layouts.base')

@section('body')
    <div class="container-md">
        {!! Form::open(['route' => 'items.store', 'files' => true]) !!}
        {!! Form::label('desc', 'item name', ['class' => 'form-label']) !!}
        {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'desc']) !!}
        {!! Form::label('cost', 'cost price', ['class' => 'form-label']) !!}
        {!! Form::number('cost_price', 0.00, ['min' => 0.00, 'step' => 0.01, 'class' => 'form-control', 'id' => 'cost' ]) !!}

        {!! Form::label('sell', 'sell price', ['class' => 'form-label']) !!}
        {!! Form::number('sell_price', 0.00, ['min' => 0.00, 'step' => 0.01, 'class' => 'form-control', 'id' => 'sell' ]) !!}
        
        {!! Form::label('qty', 'quantity', ['class' => 'form-label']) !!}
        {!! Form::number('qty', 0, ['class' => 'form-control', 'id' => 'qty' ]) !!}
        
        {!! Form::label('image', 'upload image', ['class' => 'form-control']) !!}
        {!! Form::file('image',  ['class' => 'form-control']) !!}
        @error('image')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        {!! Form::submit('Add item',  ['class'=> "btn btn-primary"]) !!}
        {!! Form::close() !!}
    </div>
@endsection
