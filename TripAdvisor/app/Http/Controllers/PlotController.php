<?php

namespace TripAdvisor\Http\Controllers;

use Illuminate\Http\Request;

class PlotController extends Controller
{
    public function plot($name){
    	$locations = [];
    	if(!empty($_POST)){
    		$itenerary = json_decode($_POST['itenerary']);
    		foreach ($itenerary as $dayplan) {
    			$daylocations=[];
    			foreach ($dayplan->plan as $plan) {
    				$latlon = [];
    				if(property_exists ( $plan , "latitude") && property_exists ( $plan , "longitude")){
	    				array_push($latlon, $plan->name);
	    				array_push($latlon, $plan->latitude);
	    				array_push($latlon, $plan->longitude);
	    				array_push($daylocations, $latlon);
	    			}
    			}
    			array_push($locations, $daylocations);
    		}
    		return view('mapview',['locations'=>json_encode($locations)]);
    	}
    }
}
