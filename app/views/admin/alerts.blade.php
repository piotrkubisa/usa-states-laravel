<div id="Alerts">
	<div class="container">
@if($errors->any())
	<div class="col-md-8 col-md-offset-2">
	@foreach($errors->all() as $error)
	{{ HTML::alert('danger', $error, 'Whoops') }}
	@endforeach
	</div>
@endif
@if(Session::get('successAlerts'))
	<div class="col-md-8 col-md-offset-2">
	@foreach(Session::get('successAlerts') as $error)
	{{ HTML::alert('success', $error, 'Success') }}
	@endforeach
	</div>
@endif
	</div>
</div>