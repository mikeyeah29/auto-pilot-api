<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;

use Auth;

class TransactionsController extends Controller
{
    public function ins() {

    	$ins = Transaction::where('user_id', '=', Auth::id())
                      ->where('direction', '=', 'in')
                      ->orderBy('date')->get();

      return response()->json([
        'ins' => $ins
      ]);

    }

    public function outs() {

      $outs = Transaction::where('user_id', '=', Auth::id())
                      ->where('direction', '=', 'out')
                      ->orderBy('date')->get();

      return response()->json([
        'outs' => $outs
      ]);

    }

    public function store(Request $request) {
    	
    	$this->validate($request, [
    		'name' => 'required',
    		'direction' => 'in:in,out',
        'date' => 'required|int',
        'amount' => 'required|int'
    	]);

      $transaction = new Transaction();

      $transaction->user_id = Auth::id();
      $transaction->name = $request->name;
      $transaction->direction = $request->direction;
      $transaction->date = $request->date;
      $transaction->amount = $request->amount;

      $transaction->save();

      return response()->json(['message' => 'Transaction added']);

    }

    public function update(Request $request, $id) {
    	
        $this->validate($request, [
          'name' => 'required',
          'date' => 'required|int',
          'amount' => 'required|int'
        ]);

        $transaction = Transaction::findOrFail($id);

        if($transaction->user_id !== Auth::id()){
            return response()->json(['message' => 'Cant do that'], 401);
        }

        $transaction->name = $request->name;
        $transaction->date = $request->date;
        $transaction->amount = $request->amount;

        $transaction->save();

        return response()->json(['message' => 'Transaction updated']);

    }

    public function destroy($id) {
    	
    	$transaction = Transaction::findOrFail($id);

        if($transaction->user_id === Auth::id()){
            $transaction->delete();
            return response()->json(['message' => 'Transaction deleted']);
        }

        return response()->json(['message' => 'Cant do that'], 401);

    }
}
