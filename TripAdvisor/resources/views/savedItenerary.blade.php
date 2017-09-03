@extends('layouts.app')
@section('content')
<script type="text/javascript">
	function renderPlan(name){
		// var content =  localStorage['itenerary'];
		console.log(name);
		var idname = name;
		// var div = document.getElementById(idname);
		// var content = div.innerHTML;
		// console.log(content);
		// localStorage['itenerary'] = content;
		window.location = "/viewtrip/"+idname;
		localStorage['name'] = idname;
	}
	
</script>
<div class = "container">
	<div class="panel-header"><h4>Saved Trips</h4></div>
	<div class = "panel-body">
		@if(!$trips->isEmpty())
		@foreach($trips as $trip)
		<div class="triplist col-sm-12">
			<div class="col-sm-6">
				<div class="tripname" >{{$trip->name}}</div>
				<div style = "display:none" id="{{$trip->name}}"></div>
			</div>
			<div class="col-sm-3">
				<button class=" iter" onclick ="renderPlan('{{$trip->name}}')">View</button>
			</div>
			<div class="col-sm-3">
				<button type="submit" onclick="window.location.href = '/plan/delete/{{$trip->id}}';" class="iter">Delete</button>
			</div>
		</div>
		@endforeach
		@else
		<h6>No trips to show</h6>
		@endif
	</div>
</div>
@endsection