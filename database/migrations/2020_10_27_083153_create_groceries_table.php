<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroceriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // these are the default groceries - they show up as default unless archived
        // because we dont buy them anymore I guess

        /*
                
            Status
            ------

            default -> is a default shopping list item
            other -> not needed when shopping ( might be a one off item or xmas present etc )

        */

        Schema::create('groceries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->enum('area', array('fresh', 'dairy', 'meat', 'baked', 'tinned', 'frozen', 'other'));
            $table->float('price')->default(0);
            $table->enum('status', array('default', 'other'))->defalult('default');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groceries');
    }
}
