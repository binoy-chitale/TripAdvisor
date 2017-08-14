<?php

namespace TripAdvisor\Http\Controllers;
use Illuminate\Http\Request;
use TripAdvisor\Dest as Dest;
use TripAdvisor\Attraction as Attraction;
use TripAdvisor\Category as Category;
use DB;

class CategoryController extends Controller{

    public function calculateDistance($lat1, $lon1, $lat2, $lon2){      
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $km = $miles*1.609344;
        return $km;
    }

    public function findNextStop($dist, $visit, $currentStop){
            $list = [];
            $flag=0;
            $n = 0;
            $radius= 5;
            foreach ($distarray[$currentStop] as $key => $value) {
                $lat1 = (float)$value['latitude'];
                $lon1 = (float)$value['longitude'];
            }
            foreach ($dist as $keyinner => $valueinner) {
                if($n>20){
                    $radius = $radius + 3;
                    $n = 0;
                }
                if($keyinner!=$currentStop && !in_array($keyinner, $visit)){
                    $lat2 = (float)$valueinner[0]['latitude'];
                    $lon2 = (float)$valueinner[0]['longitude'];
                    
                    $var = $this->calculateDistance($lat1, $lon1, $lat2, $lon2);
                    if($var<$radius){
                        if(sizeof($list)<5){
                            $list[$keyinner]=$var;
                        }
                        else{
                            $flag = 1;   
                            break;
                        }
                    }
                    else{
                        $n++;
                    }
                }                    
        
            if($flag==1){
                break;
            }
        }
        asort($list);
        return $list;    
    }

    public function viewCategories($name){
        $destination = Dest::where('name',$name)->first();
        $attractions = Attraction::where('dest_id',$destination->id)->get();
        
        $attractionid = $attractions->map(function ($attractions) {
    		return collect($attractions->toArray())
        	->only(['id'])
        	->all();	
		});

        $categories = Category::select('name')->whereIn('attraction_id', $attractionid)->groupBy('name')->get();

        return view('categoryview',['name'=>$name, 'categories'=>$categories, 'attractions'=>$attractions] );
    }

    public function getCategories($name){
    	if(isset($_POST['catvalues'])){    		
    	    $catvalues = $_POST['catvalues'];
            $userselectedcategories = [];
            foreach ($catvalues as $catvalues) {
                array_push($userselectedcategories,str_replace('%20', ' ', $catvalues));
            }

            $attractions = json_decode($_POST['attractions']);

            $attractionidlist=[];
            $attractiondistance=[];
            $rating = [];
            $distarray = [];
            $visit = [];

            foreach($attractions as $item) {
                $rating[ $item->{'id'}] = $item->{'rating'};
                array_push($attractionidlist, $item->{'id'});
                $distarray[$item->{'id'}] = array( ['latitude' => $item->{'latitude'}, 'longitude' => $item->{'longitude'}] );
            }
            
            $list = Category::select('attraction_id', DB::raw('count(*) as count'))->whereIn('attraction_id',$attractionidlist)->whereIn('name' ,$userselectedcategories)->groupBy('attraction_id')->get();    
            
            foreach ($list as $list) {
                $rating[$list->attraction_id] = $rating[$list->attraction_id] + $list->count*0.005;
            }

            arsort($rating);
            $sorteddistarray = [];

            foreach ($rating as $key => $value) {
                $sorteddistarray[$key] = $distarray[$key];
            }
            foreach ($rating as $key => $value) {
                $currentStop = $key;
                array_push($visit, $key);
                break;
            }
            for($i=0;$i<5;$i++){
                $value = $this->findNextStop($sorteddistarray, $visit, $currentStop);
                foreach ($value as $key => $val) {
                    $currentStop = $key;
                    array_push($visit, $currentStop);
                    break;
                }
            }

            return view('planview',['currentStop'=>$currentStop, 'distarray'=>$distarray, 'visit'=>$visit]);
        }
    }
}
