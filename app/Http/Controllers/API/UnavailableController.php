<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UnavailableDate;
use Auth;

class UnavailableController extends Controller
{
    public function index()
    {
    	$dates = UnavailableDate::where('user_id', Auth::id())
                    ->where('date', '>=', date("Y-m-d"))
                    ->orderby('date', 'asc')->get();

        return response()->json([
        	'dates' => $dates
        ]);
    }

    public function store(Request $request){

    	$this->validate($request, [
            'date' => 'required|date'
        ]);

        $date = new UnavailableDate();
        $date->user_id = Auth::id();
        $date->date = $request->date;
        $date->reason = $request->reason;
        $date->save();

        return response()->json(['message' => 'Unavailable date added']);
    }

    public function destroy($id)
    {
    	$date = UnavailableDate::findOrFail($id);

        if($date->user_id === Auth::id()){
            $date->delete();
            return response()->json(['message' => 'Date deleted']);
        }

		return response()->json(['message' => 'Cant do that'], 401);
    }
}
