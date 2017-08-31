@extends('layouts.app')
@section('content')
<?php $dayno=1; ?>
<div class="container appcontainer">
	<div class = "col-md-9">
	    <div class="row itenerary" style="display:flex;">
			@foreach($itenerary as $dayplan)
				<div id="column"class="daycolumn">	
					<div class="panelheaderdiv"><span class="dayno">Day {{$dayno}}: </span><span class="daydate">{{$dayplan['day']->format('d-m-Y')}}</span>
					</div>
					<div class="panelbodydiv">
							<ul class="sortable">
							@foreach($dayplan['plan'] as $item)
								<li class="ui-state-default day-item" id="expand">
								@if(property_exists($item,"images"))
								<div class="img-wrapper col-sm-3">
									<img src="{{unserialize($item->images)[0]}}"></span>
								</div>
								@else
								<div class="img-wrapper col-sm-3">
									<img src="{{ asset('images/lunch.png') }}"></span>
								</div>
								@endif
								<div class="col-sm-9">
									<h1 class="itemname">{{$item->name}}</h1>
									<?php
									if(strcasecmp($item->name, "lunch")!=0){
										$stars=(int)$item->stars;
										$stars=$item->stars*10;
									echo('<span class="stars-container stars'.$stars.'" id="stars">★★★★★</span>');
									}
									?>
									<br>
									<span class="startend" id="startend"><span class="starttime">{{$item->startofvisit}}</span>-<span class="endtime">{{$item->endofvisit}}</span></span>
									<div id="attrcontent">
								        <ul>
								            <li>This is just some random content.</li>
								            <li>This is just some random content.</li>
								            <li>This is just some random content.</li>
								            <li>This is just some random content.</li>
								        </ul>
								    </div>
								</div>
								@php
								$start = DateTime::createFromFormat("H:i",$item->startofvisit);
								$end = DateTime::createFromFormat("H:i",$item->endofvisit);
								$duration =  $start->diff($end);
								@endphp
								<span class="duration" style="display:none">Stay for {{$duration->h}} hours</span>
								@if(property_exists($item,"latitude")&&property_exists($item,"longitude"))
								<span class="lat" style="display:none">{{$item->latitude}}</span><span class="lon" style="display:none">{{$item->longitude}}</span>
								@endif
								</li>
							@endforeach
							</ul>
					</div>
				</div>
				<?php $dayno=$dayno+1;?>
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
			<ul  class="sortable side-sortable">
			@foreach($attractions as $attraction)
			<li class="sidebar-list">
					@if(sizeof($attraction->images)!=0)
					<div class ="row">
					<div class="img-wrapper col-sm-3">	
						<img class="tn-img" src="{{unserialize($attraction->images)[0]}}"></img>
					</div>
					@endif
					@php
					$datetime = DateTime::createFromFormat("H:i","10:00");
					if($attraction->duration == ""){
						$attraction->duration = "2";
					}
					$datetime->add(new DateInterval("PT{$attraction->duration}H"));
					@endphp
					<div class="col-sm-9">
					<h1 class="itemname">{{$attraction->name}}</h1>
					<?php
							if(strcasecmp($item->name, "lunch")!=0){
								$stars=(int)$item->stars;
								$stars=$item->stars*10;
							echo('<span class="stars-container stars-'.$stars.'" id="stars">★★★★★</span><br>');
							}
						?>
					<span class="duration">Stay for {{$attraction->duration}} hours</span>
						<span class = "startend" style="display:none;">
							<span class="starttime">10:00</span>-
							@php
							$datetime = DateTime::createFromFormat("H:i","10:00");
							if($attraction->duration == ""){
								$attraction->duration = "2";
							}
							$datetime->add(new DateInterval("PT{$attraction->duration}H"));
							@endphp
							<span class="endtime">{{$datetime->format("H:i")}}</span>
						</span>
					</div>
					</div>
					@if(property_exists($attraction,"latitude")&&property_exists($attraction,"longitude"))
						<span class="lat" style="display:none">{{$attraction->latitude}}</span><span class="lon" style="display:none">{{$attraction->longitude}}</span>
					@endif
			</li>
			@endforeach
			</ul>
		</div>
	</div>
</div>
<div id="plot">
    <button type="submit" class="btn btn-primary btn-circle btn-lg"><i class="glyphicon glyphicon-map-marker"></i></button>
    <span id="dest">{{$name}}</span>
</div>
<div id="Normal">
    <button onclick="myFunction()" class="btn btn-primary btn-circle btn-lg"><i class="glyphicon glyphicon-print"></i></button>
</div>
<script>
function myFunction() {
    window.print();
}
</script>
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('js/date.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/drag.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/att_search.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('js/displaycontent.js') }}"></script>

@endsection

@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
  .sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  .sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; }
  .sortable li span { position: absolute; margin-left: -1.3em; }
</style>
@endsection