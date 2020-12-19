<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Grocery;

use Auth;

class GroceriesController extends Controller
{
    public function index(Request $request) {

        if(isset($_GET['status'])) {

            $groceries = Grocery::where('user_id', '=', Auth::id())
                                ->where('status', '=', $_GET['status'])->orderBy('created_at', 'desc')->get();

        }else{

            $groceries = Grocery::where('user_id', '=', Auth::id())->orderBy('created_at', 'desc')->get();

        }

        return response()->json([
        	'groceries' => $groceries
        ]);

    }

    public function store(Request $request) {
    	
    	$this->validate($request, [
    		'name' => 'required',
    		'area' => 'in:fresh,dairy,meat,baked,tinned,frozen,other',
            'price' => 'required',
            'status' => 'in:default,other'
    	]);

		$grocery = new Grocery();
		
		$grocery->user_id = Auth::id();
		$grocery->name = $request->name;
		$grocery->area = $request->area;
        $grocery->price = $request->price;
        $grocery->status = $request->status;

		$grocery->save();

        return response()->json(['message' => 'Grocery added']);

    }

    public function update(Request $request, $id) {
    	
        $this->validate($request, [
            'name' => 'required',
            'area' => 'in:fresh,dairy,meat,baked,tinned,frozen,other',
            'price' => 'required',
            'status' => 'in:default,other'
        ]);

        $grocery = Grocery::findOrFail($id);

        if($grocery->user_id !== Auth::id()){
            return response()->json(['message' => 'Cant do that'], 401);
        }

        $grocery->name = $request->name;
        $grocery->area = $request->area;
        $grocery->price = $request->price;
        $grocery->status = $request->status;

        $grocery->save();

        return response()->json(['message' => 'Grocery updated']);

    }

    public function toggleStatus(Request $request, $id) {

        $this->validate($request, [
            'status' => 'in:default,other'
        ]);

        $grocery = Grocery::findOrFail($id);

        if($grocery->user_id !== Auth::id()){
            return response()->json(['message' => 'Cant do that'], 401);
        }

        $grocery->status = $request->status;

        $grocery->save();

        return response()->json(['message' => 'Grocery status updated']);

    }

    public function destroy($id) {
    	
    	$grocery = Grocery::findOrFail($id);

        if($grocery->user_id === Auth::id()){
            $grocery->delete();
            return response()->json(['message' => 'Grocery deleted']);
        }

        return response()->json(['message' => 'Cant do that'], 401);

    }
}
