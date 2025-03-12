@extends('layouts.base')
@section('body')
    <h1>Search</h1>

    There are {{ $searchResults->count() }} results.

    @foreach ($searchResults->groupByType() as $type => $modelSearchResults)
        <h2>{{ $type }}</h2>

        @foreach ($modelSearchResults as $searchResult)
            <ul>
                <a href="{{ $searchResult->url }}">{{ $searchResult->title }}</a>
            </ul>
        @endforeach
    @endforeach
@endsection