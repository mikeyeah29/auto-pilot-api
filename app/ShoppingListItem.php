<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Grocery;

class ShoppingListItem extends Model
{
	protected $table = 'shopping_list_items';

    public function grocery() {
    	// dd($this->hasOne(Grocery::class, 'id', 'grocery_id')->get());
    	return $this->hasOne(Grocery::class, 'id', 'grocery_id'); //->get();
    }
}
