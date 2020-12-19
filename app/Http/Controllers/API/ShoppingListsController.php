<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ShoppingList;
use App\ShoppingListItem;
use App\Grocery;

use Auth;

class ShoppingListsController extends Controller
{
    public function index() {

    	$lists = ShoppingList::where('user_id', '=', Auth::id())->orderBy('created_at', 'desc')->get();

        return response()->json([
        	'shopping_lists' => $lists
        ]);

    }

    public function store(Request $request) {
    	
    	$this->validate($request, [
    		'name' => 'required'
    	]);

		$list = new ShoppingList();
		
		$list->user_id = Auth::id();
		$list->name = $request->name;

		$list->save();

        // insert mulpel
        if(isset($request->grocery_ids) && sizeof($request->grocery_ids) > 0) {

            $items = [];

            foreach ($request->grocery_ids as $gId) {
                $items[] = [
                    'shopping_list_id' => $list->id, 
                    'grocery_id' => $gId,
                    'in_basket' => 0
                ];
            }

            ShoppingListItem::insert($items);
        }

        return response()->json(['message' => 'List added', 'listId' => $list->id]);

    }

    public function show(Request $request, $id) {

        $list = ShoppingList::with('items.grocery')->findOrFail($id);

        return response()->json([
            'message' => 'ok', 
            'shopping_list' => $list
        ]);

    }

    public function addItem(Request $request, $id, $groceryId) {

        $list = ShoppingList::findOrFail($id);

        if($list->user_id !== Auth::id()){
            return response()->json(['message' => 'Cant do that'], 401);
        }
    	
        $list->addGroceryItem($groceryId);

        return response()->json(['message' => 'Item added to list']);

        // $this->validate($request, [
        //     'name' => 'required',
        //     'amount' => 'required|int'
        // ]);

        // $debt = Debt::findOrFail($id);

        // if($debt->user_id !== Auth::id()){
        //     return response()->json(['message' => 'Cant do that'], 401);
        // }

        // $debt->name = $request->name;
        // $debt->amount = $request->amount;

        // $debt->save();

        // return response()->json(['message' => 'Debt updated']);

    }

    public function destroy($id) {
    	
    	$list = ShoppingList::findOrFail($id);

        if($list->user_id === Auth::id()){
            $list->delete();
            return response()->json(['message' => 'Shopping list deleted']);
        }

        return response()->json(['message' => 'Cant do that'], 401);

    }

    public function removeItem(Request $request, $id, $itemId) {

        $list = ShoppingList::findOrFail($id);

        if($list->user_id !== Auth::id()){
            return response()->json(['message' => 'Cant do that'], 401);
        }

        $list->removeGroceryItem($itemId);

        return response()->json(['message' => 'item removed']);
    }
}
