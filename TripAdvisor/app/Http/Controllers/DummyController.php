<?php

namespace TripAdvisor\Http\Controllers;

use Illuminate\Http\Request;

class DummyController extends Controller
{
    //
    public function preview($name){
        $destination = Dest::where('name',$name)->first();
        $directory = $destination->directory;
        $attractions = Attraction::where('dest_id',$destination->id)->get();
        return view('categoryview',['attractions' =>$attractions, 'name'=>$name]);

    }
}
