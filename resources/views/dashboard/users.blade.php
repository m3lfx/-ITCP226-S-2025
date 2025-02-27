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
        @push('scripts')
            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
            <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
            <script src="/vendor/datatables/buttons.server-side.js"></script>
            {!! $dataTable->scripts() !!}
        @endpush
        {{-- {{ $dataTable->scripts() }} --}}
    @endsection
