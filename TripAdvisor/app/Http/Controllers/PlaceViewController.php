<?php

namespace TripAdvisor\Http\Controllers;

use Illuminate\Http\Request;
use TripAdvisor\Dest as Dest;
use TripAdvisor\Attraction as Attraction;

class PlaceViewController extends Controller
{
    //
    public function view($name, $placename){
    	$placename = str_replace('%20', ' ', $placename);
    	$destination = Dest::where('name',$name)->first();
        $attractions = Attraction::where('dest_id',$destination->id)->where('name',$placename)->get();

    	return view('placeview',['attractions'=> $attractions]);
    }
}
