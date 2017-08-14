<?php

use Illuminate\Database\Seeder;

class AttractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paths = DB::table('dest')->pluck('directory')->toArray();
        // var_dump($paths);
        foreach($paths as $path) {
	        $destid=DB::table('dest')->where('directory',$path)->first()->id;
	        $obj = File::get(storage_path($path));
	        // $attraction = file_get_contents(storage_path('app/Dest/Paris/Paris.txt'));
	        $attractions_json = json_decode($obj);
	        // var_dump($attractions_json);
	        $atts = $attractions_json->attractions;
	        $days = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
	        foreach($atts as $att) {
		        // var_dump($att->name);
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
		            'dest_id' =>$destid,
		        ]);
		        $attrid = (DB::table('attractions')->where('name', $att->name)->first())->id;
		        foreach($att->category as $cat) {
			        DB::table('category')->insert([
			            'name' => $cat,
			            'attraction_id' => $attrid,
			        ]); 
			    }
		    }
		}
    }
}
