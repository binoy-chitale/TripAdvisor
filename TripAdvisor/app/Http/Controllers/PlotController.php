<?php

namespace TripAdvisor\Http\Controllers;

use Illuminate\Http\Request;

class PlotController extends Controller
{
    public function plot($name){
    	
    return view('mapview');
    }
}
