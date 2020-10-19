<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Budget;

use Auth;

class BudgetsController extends Controller
{
    public function index() {

    	$budgets = Budget::all();

    	$budgets = Budget::where('user_id', '=', Auth::id())->get();

        return response()->json([
        	'budgets' => $budgets
        ]);

    }

    public function store(Request $request) {
    	
    	$this->validate($request, [
    		'name' => 'required',
    		'allowance' => 'required|int'
    	]);

		$budget = new Budget();
		
		$budget->user_id = Auth::id();
		$budget->name = $request->name;
		$budget->allowance = $request->allowance;
		$budget->spent = 0;

		$budget->save();

        return response()->json(['message' => 'Budget added']);

    }

    public function update(Request $request, $id) {
    	
        $this->validate($request, [
            'name' => 'required',
            'allowance' => 'required|int',
            'spent' => 'required|int'
        ]);

        $budget = Budget::findOrFail($id);

        if($budget->user_id !== Auth::id()){
            return response()->json(['message' => 'Cant do that'], 401);
        }

        $budget->name = $request->name;
        $budget->allowance = $request->allowance;
        $budget->spent = $request->spent;

        $budget->save();

        return response()->json(['message' => 'Budget updated']);

    }

    public function spend(Request $request, $id) {
    	
        $this->validate($request, [
            'spent' => 'required|int'
        ]);

        $budget = Budget::findOrFail($id);

        if($budget->user_id !== Auth::id()){
            return response()->json(['message' => 'Cant do that'], 401);
        }

        $budget->spent = $request->spent;
        $budget->save();

        return response()->json(['message' => 'Spent updated']);

    }

    public function reset(Request $request, $id) {
    	
        $budget = Budget::findOrFail($id);

        if($budget->user_id !== Auth::id()){
            return response()->json(['message' => 'Cant do that'], 401);
        }

        $budget->spent = 0;
        $budget->save();

        return response()->json(['message' => 'Budget reset']);

    }

    public function destroy($id) {
    	
    	$budget = Budget::findOrFail($id);

        if($budget->user_id === Auth::id()){
            $budget->delete();
            return response()->json(['message' => 'Budget deleted']);
        }

        return response()->json(['message' => 'Cant do that'], 401);

    }
}
