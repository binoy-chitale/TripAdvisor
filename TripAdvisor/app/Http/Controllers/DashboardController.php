<?php

namespace TripAdvisor\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use TripAdvisor\Dest as Dest;
use TripAdvisor\Attraction as Attraction;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dash($name)
    {
        $destination = Dest::where('name',$name)->first();
        $directory = $destination->directory;
        $attractions = Attraction::where('dest_id',$destination->id)->get();
        // return view('dashboard',['dest' =>$destination,'attractions' =>$attractions]);
        return view('dashboard',['attractions' =>$attractions, 'name'=>$name]);
    }
}
