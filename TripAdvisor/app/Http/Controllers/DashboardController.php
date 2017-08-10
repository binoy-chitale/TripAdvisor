<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dest as Dest;
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
        //$destination = Dest::where('name',$name)->first();
        $destination = Dest::where('name',$name)->first();
        $directory = $destination->directory;
        return view('dashboard',['dest' =>$destination]);
    }
}
