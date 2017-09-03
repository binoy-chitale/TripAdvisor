<?php

namespace TripAdvisor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use DB;
use TripAdvisor\Itenerary as Itenerary;
class SavedController extends Controller
{
    public function saved(){
        return view('savedItenerary');
    }
    public function viewtrips($name){
    	return view('viewtrip',['name'=>$name]);
    }
    public function saveitenerary(Request $request){
    	$data = $request->all();
    	// Log::info($data);
    	$name = $data['name'];
    	// Log::info($name);
    	$itenerary = $data['save-itenerary'];
    	$id = Auth::id();
    	DB::table('itenerary')->insert([
		            'layout' => $itenerary,
		            'user_id' => $id,
		            'city' => $data['city'],
		            'name' => $name,
		]);
    }
    public function showSavedTrips($city){
    	$savedTrips = Itenerary::where([
		    ['city', '=', $city],
		    ['user_id', '=', Auth::id()],
		])->get();
	   return view('savedItenerary',['trips'=>$savedTrips]);
    }

    public function delete($id){
        $city = DB::table('itenerary')->where('id', $id)->pluck('city');
        $city = $city[0];
        DB::table('itenerary')->where('id', $id)->delete();
        $savedTrips = Itenerary::where([
            ['city', '=', $city],
            ['user_id', '=', Auth::id()],
        ])->get();
        return redirect()->action(
           'SavedController@showSavedTrips', ['city' => $city]
        );
    }
}
