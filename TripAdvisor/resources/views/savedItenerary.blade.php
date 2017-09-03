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
	<div class = "panel-body">
		@if(!$trips->isEmpty())
		@foreach($trips as $trip)
		<br><button onclick = "renderPlan('{{$trip->name}}')"class="btn-plan btn" id="loadexisting" style="font-size:14px; margin-top: 20px; border: 2px solid; border-radius: 4px; border-color:#454545; font-weight:600;">{{$trip->name}}</button>
		<div style = "display:none" id="{{$trip->name}}"></div>
		@endforeach
		@endif
	</div>
</div>
@endsection