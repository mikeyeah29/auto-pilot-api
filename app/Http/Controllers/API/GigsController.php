<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Gig;
use Auth;

class GigsController extends Controller
{
    public function index()
    {
    	$gigs = Gig::where('user_id', '=', Auth::id())
                    ->where('date', '>=', date("Y-m-d"))
                    ->orderby('date', 'asc')
                    ->get();

        return response()->json([
        	'gigs' => $gigs
        ]);
    }

    public function store(Request $request){

    	$this->validate($request, [
    		'date' => 'required|date',
    		'venue' => 'required'
    	]);

    	$gig = new Gig();
    	$gig->user_id = Auth::id();
    	$gig->date = $request->date;
    	$gig->venue = $request->venue;
    	$gig->address_line_one = $request->address_line_one;
    	$gig->postcode = $request->postcode;
    	$gig->revenue = $request->revenue;
    	$gig->rider = $request->rider;
    	$gig->save();

    	return response()->json(['message' => 'gig added']);
    }

    public function destroy($id)
    {
    	$gig = Gig::findOrFail($id);

        if($gig->user_id === Auth::id()){
            $gig->delete();
            return response()->json(['message' => 'Gig deleted']);
        }

        return response()->json(['message' => 'Cant do that'], 401);
    }
}
