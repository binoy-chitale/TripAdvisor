<?php

namespace TripAdvisor\Http\Controllers;

use Illuminate\Http\Request;
use TripAdvisor\Dest as Dest;
class HomeController extends Controller
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
    public function index()
    {
        
        $destinations = Dest::all();
        return view('home',['dests' =>$destinations]);
    }
}
