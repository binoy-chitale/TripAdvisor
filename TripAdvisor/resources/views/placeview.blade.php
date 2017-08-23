@extends('layouts.app')
@section('content')

<?php
foreach($attractions as $attraction)
	$image = unserialize($attraction->images);
	$attr= $attraction;
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<body>

<div class="container col-md-12">
  <div id="myCarousel" class="carousel slide col-md-6" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
    	<?php
    	for($i=0;$i<sizeof($image);$i++){
    		if($i==0){
      			echo '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
  			}
      		else{
      			echo '<li data-target="#myCarousel" data-slide-to="'.$i.'"></li>';
  			}
  		}
      	?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
	    <?php
	    for($i=0;$i<sizeof($image);$i++){
	    	if($i==0){
	      		echo '<div class="item active"><img src="'.$image[$i].'" style="background-size:cover"></div>';
	  		}
	  		else{
		      	echo '<div class="item"><img src="'.$image[$i].'" style="background-size:cover"></div>';
	    	}
	  	}
      ?>
    </div>	
	
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <div class="col-md-6">
    	<div class="attraction-title">{{$attr->name}}</div>
    	<hr class="horizontal-rule" align=center>
    	<br>
    	<?php
    	if(!preg_match('/ *reviews$/', $attr->description)){
    		echo '<div class="attraction-description">'.$attr->description.'</div>';
    	}

    	echo '<br><div class="attraction-description">'.$attr->rank.'</div>';

    	echo '<br><div class="attraction-address">';
    
    	$address = unserialize($attr->address);
    	echo '<span class="glyphicon glyphicon-map-marker"></span>';
    	if(!is_null($address->street_address)){
    		echo'&nbsp<span>'.$address->street_address.'</span>';
    	}
    	if(!is_null($address->locality)){
    		echo'<span> '.$address->locality.'</span>';
    	}
    	if(!is_null($address->country)){
    		echo'<span> '.$address->country.'</span><div>';
    	}
    	$phone = unserialize($attr->phone);
    	if(sizeof($phone)>0){
    		echo '<div><span class="glyphicon glyphicon-phone"></span>';
	    	echo '<span> '.$phone[0].'</span><div>';
	    }
	    echo '<br/><div class="ratings">User Ratings:';
	    $split= unserialize($attr->split_ratings);
		echo '<div>Excellent: '.$split->Excellent.'<div>';
		echo '<div>Very Good: '.$split->{'Very good'}.'<div>';
		echo '<div>Average: '.$split->Average.'<div>';
		echo '<div>Poor: '.$split->Poor.'<div>';
		echo '<div>Terrible: '.$split->Terrible.'<div>';
		echo '</div><br/>';

		echo '<div class="ratings">Attraction Rating:<div>'.substr($attr->rating,0,5).'</div></div>';
    	?>


   </div>

</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection

