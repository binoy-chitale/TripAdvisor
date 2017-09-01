@extends('layouts.app')
@section('content')
<div class="modal fade" id="details" role="dialog">
    <div class="modal-dialog">
    	<div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body col-sm-12">
        	<div class="modal-image-div">
        		<img class="modal-image">
        	</div>
          
          <div>
          	<div class="col-sm-6 modal-rank-div"><span class="modal-rank"></span></div>
          	<div class="col-sm-6 modal-stars-div"><span class="modal-stars"></span></div>
      	  </div>

      	  <br>

          <div class="modal-description-div " ><span style="font-weight:700;">About: </span><span class="modal-description"></span></div>
          
          <div class="modal-phone-div "><span class="glyphicon glyphicon-phone"> <span class=" modal-phone"></span></span></div>
          <div class="modal-address-div "><span class="glyphicon glyphicon-map-marker"><span class="modal-address"></span></span></div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php $dayno=1; ?>
<div class="container appcontainer">
	<div class = "col-md-9">
	    <div class="row itenerary" style="display:flex;">
			@foreach($itenerary as $dayplan)
				<div id="column" class="daycolumn">	
					<div class="panelheaderdiv"><span class="dayno">Day {{$dayno}}: </span><span class="daydate">{{$dayplan['day']->format('d-m-Y')}}</span>
					</div>
					<div class="panelbodydiv">
							<ul class="sortable">
							@foreach($dayplan['plan'] as $item)
								<li class="ui-state-default day-item">
								@if(property_exists($item,"images"))
									<div class="img-wrapper col-sm-3">
										<img src="{{unserialize($item->images)[0]}}">
									</div>
									@else
									<div class="img-wrapper col-sm-3">
										<img src="{{ asset('images/lunch.png') }}">
									</div>
									@endif
									<div class="col-sm-9" id="expand">
										<h1 class="itemname">{{$item->name}}</h1>
										<?php
										if(strcasecmp($item->name, "lunch")!=0){
											$stars=(float)$item->stars;
											$stars=$stars*10;
										echo('<span class="stars-container stars'.$stars.'">★★★★★</span>');
										}
										?>
										<br>
										<span class="startend" id="startend"><span class="starttime">{{$item->startofvisit}}</span>-<span class="endtime">{{$item->endofvisit}}</span></span>
									</div>
									@php
									$start = DateTime::createFromFormat("H:i",$item->startofvisit);
									$end = DateTime::createFromFormat("H:i",$item->endofvisit);
									$duration =  $start->diff($end);
									@endphp
									<span class="duration" style="display:none">Stay for {{$duration->h}} hours</span>
									@if(property_exists($item,"latitude")&&property_exists($item,"longitude"))
									<span class="lat" style="display:none">{{$item->latitude}}</span><span class="lon" style="display:none">{{$item->longitude}}</span>
									<?php 
										$obj = clone $item;
										$obj->images = unserialize($obj->images)[0];
										$obj->phone = unserialize($obj->phone);
										$obj->address = unserialize($obj->address);
										$obj->start_time = unserialize($obj->start_time);
										$obj->end_time = unserialize($obj->end_time);
										$obj->split_ratings = unserialize($obj->split_ratings);
										$obj = json_encode($obj);

									?>
									<span id="myBtn" class="glyphicon glyphicon-info-sign open-Details" data-toggle="modal" data-target="#details" data-obj="{{$obj}}"></span>
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
					$obj = clone $attraction;
					$obj->images = unserialize($obj->images)[0];
					$obj->phone = unserialize($obj->phone);
					$obj->address = unserialize($obj->address);
					$obj->start_time = unserialize($obj->start_time);
					$obj->end_time = unserialize($obj->end_time);
					$obj->split_ratings = unserialize($obj->split_ratings);
					$obj = json_encode($obj);

				?>
				<span id="myBtn" class="glyphicon glyphicon-info-sign open-Details" data-toggle="modal" data-target="#details" data-obj="{{$obj}}"></span>	
				<?php
					$stars=(float)$attraction->stars;
					$stars=$stars*10;
					echo('<span class="stars-container stars-'.$stars.'" id="stars">★★★★★</span><br>');
				?>
				<span class="duration">Stay for {{$attraction->duration}} hours</span>
					<span class = "startend" id="startend">
						<span class="starttime" style="display:none;">10:00</span>
						@php
						$datetime = DateTime::createFromFormat("H:i","10:00");
						if($attraction->duration == ""){
							$attraction->duration = "2";
						}
						$datetime->add(new DateInterval("PT{$attraction->duration}H"));
						@endphp
						<span class="endtime" style="display:none;">{{$datetime->format("H:i")}}</span>
						</span>

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
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('js/date.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/drag.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/att_search.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('js/modal.js') }}"></script>
<script>
function myFunction() {
    window.print();
}
</script>
@endsection

@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
  .sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  .sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; }
  .sortable li span { position: absolute; margin-left: -1.3em; }
</style>
@endsection