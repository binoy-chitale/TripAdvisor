<?php

use Illuminate\Database\Seeder;

class LondonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = File::get(storage_path('app/Dest/London/london.txt'));
        // $attraction = file_get_contents(storage_path('app/Dest/Paris/Paris.txt'));
        $attractions_json = json_decode($obj);
        $atts = $attractions_json->attractions;
        $days = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
        Log::info($atts);
        foreach($atts as $att) {
	        $timings = $att->all_timings;
	        $start_times = array();
		        $end_times = array();
	        $sugg_hours = $att->suggested_hours;
			preg_match_all('!\d+!', $sugg_hours, $matches); 
	        foreach($days as $day ) {
		        // $start =  explode(" - ",$timings->$day);
		        if($timings!="null" && $timings!=null){
			        $timesplit =  explode(" - ",$timings->$day);
			        if ($timesplit!=null) {
			        	$key=$day;
			        	$value=$timesplit[0];
			        	$arr = array($key=>$value);
			        	array_push($start_times, $arr);
						if($timesplit[0]!="null") {
							$value=$timesplit[1];
							$arr = array($key=>$value);
				        	array_push($end_times, $arr);
				        }
				        else {
				        	array_push($end_times, $arr);
				        }
			    	}
		    	}
		    }
	    	// var_dump($start_times);
	        // var_dump($att->images);
            // var_dump(serialize($att->images));
	        DB::table('attractions')->insert([
	            'name' => $att->name,
	            'start_time' => serialize($start_times),
	            'end_time' => serialize($end_times),
	            'duration' => $att->suggested_hours==null?"":$att->suggested_hours,
	            'rating' => $att->overall_calculated_rating,
	            'description' => $att->content,
	            'latitude' => $att->latlon=="null"?"":$att->latlon->lat,
	            'longitude' => $att->latlon=="null"?"":$att->latlon->lon,
	            'phone' => serialize($att->phone),
	            'address' => serialize($att->address),
	            'rank' => $att->rank,
	            'split_ratings' => serialize($att->ratings),
	            'images' => serialize($att->images),
	            'dest_id' =>4,
	        ]);
	        $attrid = (DB::table('attractions')->where('name', $att->name)->first())->id;
	        foreach($att->category as $cat) {
		        var_dump($cat);
		        DB::table('category')->insert([
		            'name' => $cat,
		            'attraction_id' => $attrid,
		        ]); 
		    }
	    }
    }
}
