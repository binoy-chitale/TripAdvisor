@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
		@foreach($itenerary as $dayplan)
			<div class="panel-heading" style="text-align:center;"><h1>{{$dayplan['day']->format("d-m-Y")}}</h1> </div>
			<div class="panel-body">
				@foreach($dayplan['plan'] as $item)
					<p>{{$item->name}}&nbsp {{$item->startofvisit}}&nbsp {{$item->endofvisit}}</p>
				@endforeach
			</div>
		@endforeach    
	</div>
</div>
@endsection