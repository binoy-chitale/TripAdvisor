<?php

namespace TripAdvisor\Http\Controllers;
use Illuminate\Http\Request;
use TripAdvisor\Dest as Dest;
use TripAdvisor\Attraction as Attraction;
use TripAdvisor\Category as Category;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
class CategoryController extends Controller
{
    //
    public function viewCategories($name){
        $destination = Dest::where('name',$name)->first();
        $attractions = Attraction::where('dest_id',$destination->id)->get();
        $attractionid = $attractions->map(function ($attractions) {
    		return collect($attractions->toArray())
        	->only(['id'])
        	->all();	
		});
		
        $categories = Category::select('name')->whereIn('attraction_id', $attractionid)->groupBy('name')->get();

        return view('categoryview',['attractions' =>$attractions, 'name'=>$name, 'categories'=>$categories] );
    }

    public function getCategories($name){
        if(isset($_POST['catvalues'])){	
            // $destination = Dest::where('name',$name)->first();
    		// $attractions = unserialize($attractions);
    		// $userselectedcategories = Attraction::where('dest_id', $destination->id)->whereIn('name', $_POST['catvalues']);
    		$start = strtotime($_POST['start_date']);
            $end = strtotime($_POST['start_date']);
            return view('planview',['attractions'=>$_POST['attractions'],'categories'=>$_POST['catvalues'], 'name'=>$name]);

    	}
    }
}
