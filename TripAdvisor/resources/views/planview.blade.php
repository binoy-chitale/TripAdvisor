@extends('layouts.app')
@section('content')
<div class="container appcontainer">
	<div class = "col-md-9">
	    <div class="row itenerary" style="display:flex;">
			@foreach($itenerary as $dayplan)
				<div id="column"class="daycolumn">	
					<div class="panelheaderdiv"><h4>{{$dayplan['day']->format('d-m-Y')}}</h4></div>
						<div class="panelbodydiv">
							<ul class="sortable">
							@foreach($dayplan['plan'] as $item)
								<li class="ui-state-default day-item">
								@if(property_exists($item,"images"))
								<div>
									<img src="{{unserialize($item->images)[0]}}"></span>
								</div>
								@endif
								<span class="itemname">{{$item->name}}</span><div class="startend"><span class="starttime">{{$item->startofvisit}}</span>-<span class="endtime">{{$item->endofvisit}}</span></div></li>
							@endforeach
							</ul>
						</div>
				</div>
			@endforeach
		</div>
	</div>
	<div class="col-md-3" id="fixed-div">
		<ul class="sortable invisible-list"><button class="btn trashbutton" ><span>Remove</span></button></ul>
		<form class="search-form">
            <span class="form-group has-feedback">
                <label for="search" class="sr-only">Search</label>
                <input type="text" class="form-control" name="search" id="search" placeholder="Search">
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </span>
        </form>
		<div class="scrollable-sidebar">
			<ul  class="sortable">
			@foreach($attractions as $attraction)
			<li class="sidebar-list">
					<img class="tn-img" src="{{unserialize($attraction->images)[0]}}"></img>
					<span class="itemname">{{$attraction->name}}</span>
					<div class = "startend">
						<span class="starttime" style="display:none;">10:00</span>
						@php
						$datetime = DateTime::createFromFormat("H:i","10:00");
						if($attraction->duration == ""){
							$attraction->duration = "2";
						}
						$datetime->add(new DateInterval("PT{$attraction->duration}H"));
						@endphp
						<span class="endtime" style="display:none;">{{$datetime->format("H:i")}}</span>
					</div>
			</li>
			@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('js/date.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/drag.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/att_search.js') }}"></script>
@endsection
@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
  .sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  .sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; }
  .sortable li span { position: absolute; margin-left: -1.3em; }
</style>
@endsection