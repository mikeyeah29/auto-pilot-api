<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Debt;

use Auth;

class DebtsController extends Controller
{
    public function index() {

    	$debts = Debt::where('user_id', '=', Auth::id())->orderBy('created_at', 'desc')->get();

        return response()->json([
        	'debts' => $debts
        ]);

    }

    public function store(Request $request) {
    	
    	$this->validate($request, [
    		'name' => 'required',
    		'amount' => 'required|int'
    	]);

		$debt = new Debt();
		
		$debt->user_id = Auth::id();
		$debt->name = $request->name;
		$debt->amount = $request->amount;

		$debt->save();

        return response()->json(['message' => 'Debt added']);

    }

    public function update(Request $request, $id) {
    	
        $this->validate($request, [
            'name' => 'required',
            'amount' => 'required|int'
        ]);

        $debt = Debt::findOrFail($id);

        if($debt->user_id !== Auth::id()){
            return response()->json(['message' => 'Cant do that'], 401);
        }

        $debt->name = $request->name;
        $debt->amount = $request->amount;

        $debt->save();

        return response()->json(['message' => 'Debt updated']);

    }

    public function pay(Request $request, $id) {

        $this->validate($request, [
            'amount' => 'required|int'
        ]);

        $debt = Debt::findOrFail($id);

        if($debt->user_id !== Auth::id()){
            return response()->json(['message' => 'Cant do that'], 401);
        }

        $debt->amount = $debt->amount - $request->amount;

        $debt->save();

        return response()->json(['message' => 'Debt updated']);

    }

    public function destroy($id) {
    	
    	$debts = Debt::findOrFail($id);

        if($debts->user_id === Auth::id()){
            $debts->delete();
            return response()->json(['message' => 'Debts deleted']);
        }

        return response()->json(['message' => 'Cant do that'], 401);

    }
}
