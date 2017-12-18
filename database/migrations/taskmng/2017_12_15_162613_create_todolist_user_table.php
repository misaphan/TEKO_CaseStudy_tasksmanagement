<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodolistUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todolist_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('todolist_id');
            $table->index('todolist_id', 'TodoListIndex');
            $table->integer('user_id');
            $table->index('user_id', 'UserIndex');
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
        Schema::dropIfExists('todolist_user');
    }
}
