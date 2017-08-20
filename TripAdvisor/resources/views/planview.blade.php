@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row" style="display:flex;">
		@foreach($itenerary as $dayplan)
			<div class="panel panel-default">	
				<p class="ui-state-default">{{$dayplan['day']->format('d-m-Y')}}</p>
				<ul class="sortable">
				@foreach($dayplan['plan'] as $item)
					<li class="ui-state-default">{{$item->name}}&nbsp {{$item->startofvisit}}&nbsp {{$item->endofvisit}}</li>
				@endforeach
				</ul>
			</div>
		@endforeach
	</div>

</div>
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('js/drag.js') }}"></script>
@endsection
@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
  .sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  .sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; }
  .sortable li span { position: absolute; margin-left: -1.3em; }
</style>
@endsection