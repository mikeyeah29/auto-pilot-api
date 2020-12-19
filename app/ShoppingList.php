<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\ShoppingListItem;

class ShoppingList extends Model
{
	protected $table = 'shopping_lists';

	public function items() {
		return $this->hasMany(ShoppingListItem::class, 'shopping_list_id');
	}

	public function addGroceryItem($groceryId) {
		$item = new ShoppingListItem();
		$item->shopping_list_id = $this->id;
		$item->grocery_id = $groceryId;
		$item->in_basket = 0;
		$item->save();
	}

	public function removeGroceryItem($itemId) {
		$item = ShoppingListItem::findOrFail($itemId);
		$item->delete();
	}

	public static function boot() {
        parent::boot();

        static::deleting(function($list) { // before delete() method call this
             $list->items()->delete();
        });
    }
}
