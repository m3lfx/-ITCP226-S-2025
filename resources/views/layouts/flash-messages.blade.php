@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{ $message }}</strong>
       
</div>
@endif


@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible alert-block">
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	<strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
	<button type="button" class="close" data-bs-dismiss="alert">×</button>	
	<strong>{{ $message }}</strong>
</div>
@endif
@if ($errors->any())

<div class="alert  alert-block alert-danger">
	<button type="button" class="close" data-bs-dismiss="alert"></button>	
	@foreach ($errors->all() as $message)
		{{$message}}

	@endforeach
</div>
@endif

{{-- {{dd($errors)}} --}}
