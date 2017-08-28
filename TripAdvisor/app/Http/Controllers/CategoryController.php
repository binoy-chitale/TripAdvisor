<?php

namespace TripAdvisor\Http\Controllers;
use Illuminate\Http\Request;
use TripAdvisor\Dest as Dest;
use TripAdvisor\Attraction as Attraction;
use TripAdvisor\Category as Category;
use Illuminate\Support\Facades\Input;
use DB;
use DateInterval;
use DatePeriod;
use DateTime;
class CategoryController extends Controller{

    var $attractions;
    var $attractiondistance=[];
    var $rating = [];
    var $distarray = [];
    var $visit = [];
    var $itenerary = [];
    var $sorteddistarray = [];
    var $attractionidlist=[];
    var $userselectedcategories = [];   
    var $marked=[];
    var $catvalues =[];
    public function calculateDistance($lat1, $lon1, $lat2, $lon2){      
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $km = $miles*1.609344;
        return $km;
    }

    public function findNextStop($dist,$currentStop){
        $list = [];
        $flag=0;
        $n = 0;
        $radius= 2;
        foreach ($dist[$currentStop] as $key => $value) {
            $lat1 = (float)$value['latitude'];
            $lon1 = (float)$value['longitude'];
        }
        while (true) {
            $reset=0;
            foreach ($dist as $keyinner => $valueinner) {
                if($n>20){
                    $radius = $radius + 1;
                    $n = 0;
                    $reset=1;
                    break;
                }
                if($keyinner!=$currentStop && !in_array($keyinner, $this->visit)&& !in_array($keyinner, $this->marked)){
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
            if($reset==0){
                break;
            }        
        }
        asort($list);
        reset($list);
        return key($list);    
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
    	if(!empty($_POST)){
            if(array_key_exists('catvalues',$_POST)){ 		
    	       $this->catvalues = $_POST['catvalues'];
            }
            $date=$_POST['date'];
            $date= explode(' - ', $date);
            $start = new DateTime($date[0]);
            $end = new DateTime($date[1]);
            $end = $end->modify( '+1 day' );
            $this->attractions = json_decode($_POST['attractions']);
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($start, $interval, $end);
            $this->makeRatingsList();
            $this->updateRatingsWithCategories();            
            arsort($this->rating);
            $this->makeSortedDistArray();
            foreach ($period as $day) {
                array_push($this->itenerary,$this->getDayPlan($day));
            }
            return view('planview',['attractions'=>$this->attractions, 'visit'=>$this->visit,'itenerary'=>$this->itenerary,'name'=>$name]);
        }
        else{
            return redirect('/plan/'.$name);
        }
    }
    public function makeRatingsList(){
        foreach($this->attractions as $item) {
                $this->rating[ $item->{'id'}] = $item->{'rating'};
                array_push($this->attractionidlist, $item->{'id'});
                $this->distarray[$item->{'id'}] = array( ['latitude' => $item->{'latitude'}, 'longitude' => $item->{'longitude'}] );
            }
    }
    public function updateRatingsWithCategories(){
        $list = Category::select('attraction_id', DB::raw('count(*) as count'))->whereIn('attraction_id',$this->attractionidlist)->whereIn('name' ,$this->catvalues)->groupBy('attraction_id')->get();    
        foreach ($list as $list) {
            $this->rating[$list->attraction_id] = $this->rating[$list->attraction_id] + $list->count*0.1;
            $this->rating[$list->attraction_id] = (string)$this->rating[$list->attraction_id];     
        }
    }
    public function getDayPlan($day) {
        $day->setTime(10,0);
        $currentStop;
        $itenerary=array();
        $itenerary['plan']=array();
        $itenerary['day']="";
        $eod = clone $day;
        $eod->setTime(20,0);
        $this->marked=[];
        $lunchFlag=0;
        foreach ($this->rating as $key => $value) {
            if((!in_array($key, $this->marked))&&($bool=(!in_array($key,$this->visit)))&&($att=$this->isOpen($key,clone $day))) {
                $currentStop = $key;
                array_push($this->visit, $key);
                $hours =$att->duration;
                if($hours==""){
                    $hours=2;
                }
                foreach ($this->attractions as $attraction) {
                    if($attraction->id == $currentStop){
                        $attraction->startofvisit=$day->format("H:i");
                        $temp = clone $day;
                        $temp->add(new DateInterval("PT{$hours}H"));
                        $attraction->endofvisit=$temp->format("H:i");
                        array_push($itenerary['plan'],$attraction);
                    }
                }
                $day->add(new DateInterval("PT{$hours}H"));
                if($lunchFlag==0&&$this->checkIfLunchTime($day)) {
                    $temp=clone $day;
                    $day->add(new DateInterval("PT{$this->getLunchTime()}H"));
                    $lunch = new \stdClass();
                    $lunch->name = "Lunch";
                    $lunch->startofvisit=$temp->format("H:i");
                    $lunch->endofvisit=$day->format("H:i");
                    array_push($itenerary['plan'],$lunch);
                    $lunchFlag=1;
                }
                break;
            }
            array_push($this->marked, $key);
        }
        $this->marked=[];
        while($day<$eod) {
            $currentStop=$this->findNextStop($this->sorteddistarray,$currentStop);
            if($lunchFlag==0&&$this->checkIfLunchTime($day)) {
                    $temp=clone $day;
                    $day->add(new DateInterval("PT{$this->getLunchTime()}H"));
                    $lunch = new \stdClass();
                    $lunch->name = "lunch break";
                    $lunch->startofvisit=$temp->format("H:i");
                    $lunch->endofvisit=$day->format("H:i");
                    array_push($itenerary['plan'],$lunch);
                    $lunchFlag=1;
                }
            if($att=$this->isOpen($currentStop,clone $day)) {
                array_push($this->visit,$currentStop);
                $day->add(new DateInterval("PT{$this->getTravelTime()}S"));
                $hours =$att->duration;
                if($hours==""){
                    $hours=2;
                }
                foreach ($this->attractions as $attraction) {
                    if($attraction->id == $currentStop){
                        $attraction->startofvisit=$day->format("H:i");
                        $temp = clone $day;
                        $temp->add(new DateInterval("PT{$hours}H"));
                        $attraction->endofvisit=$temp->format("H:i");
                        array_push($itenerary['plan'],$attraction);
                    }
                }
                
                $day->add(new DateInterval("PT{$hours}H"));
            }
            array_push($this->marked, $currentStop);
        }
        $itenerary['day']=$day;
        return $itenerary;
    }
    public function makeSortedDistArray(){
        foreach ($this->rating as $key => $value) {
            $this->sorteddistarray[$key] = $this->distarray[$key];
        }
    }
    public function getTravelTime(){
        $stop1 = (array_values($this->visit)[count($this->visit)-2]);
        $stop2 = (array_values($this->visit)[count($this->visit)-1]);
        foreach ($this->distarray[$stop1] as $key => $value) {
            $lat1 = (float)$value['latitude'];
            $lon1 = (float)$value['longitude'];
        }
        foreach ($this->distarray[$stop2] as $key => $value) {
            $lat2 = (float)$value['latitude'];
            $lon2 = (float)$value['longitude'];
        }
        // $url="https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$lon1."&destinations=".$lat2.",".$lon2;
        // $json = file_get_contents($url); 
        // $result = json_decode($json, true);
        // return ($result['rows']['0']['elements']['0']['duration']['value']);
        // return $min;
        $distance= $this->calculateDistance($lat1,$lon2,$lat2,$lon2);
        $time=$distance*3600/4.28;
        return round($time);
    }
    public function isOpen($id,$day) {
        $days = array("Mon"=>0,"Tue"=>1,"Wed"=>2,"Thu"=>3,"Fri"=>4,"Sat"=>5,"Sun"=>6);
        foreach ($this->attractions as $attraction) {
            if($attraction->id == $id){
                $starttimes = unserialize($attraction->start_time);
                $endtimes = unserialize($attraction->end_time);
                $start;
                $end;
                $startstr;
                $endstr;
                $hours = $attraction->duration;
                if($hours==""){
                    $hours=2;
                }
                if(empty($starttimes) || $starttimes[$days[$day->format('D')]][$day->format('D')]=="null"){
                    $start=(new Datetime("9:30 am"));
                    $startstr=$start->format("H:i");
                }
                if(empty($endtimes) || $endtimes[$days[$day->format('D')]][$day->format('D')]=="null" ||$endtimes[$days[$day->format('D')]][$day->format('D')]==null){
                    $end = (new Datetime("8:30 pm"));
                    $endstr=$end->format("H:i");
                }
                else{
                    $start = (new Datetime($starttimes[$days[$day->format('D')]][$day->format('D')]));
                    $startstr=$start->format("H:i");
                    $end = (new Datetime($endtimes[$days[$day->format('D')]][$day->format('D')]));
                    $endstr=$end->format("H:i");
                }
                // $day->add(new DateInterval("PT{$hours}H"))->format("H:i");
                $daystr=$day->format("H:i");
                if($startstr<= $daystr)
                {
                    $day->add(new DateInterval("PT{$hours}H"));
                    $daystr=$day->format("H:i");
                    if($daystr<$endstr)
                    {
                        return $attraction;
                    }
                }
                else{
                    return false;
                }
            }
        }
    }
    public function checkIfLunchTime($day){
        if($day->format("H:i")>="12:00") {
            return true;
        }
        return false;
    }
    public function getLunchTime(){
        return 2;
    }
}