<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;

use Auth;


class TodoList extends Model
{
    protected $table = 'todolists';
    protected $fillable = ['todolist_id', 'name', 'description', 'created_user_id', 'status'];

    public function tasks(){
    	return $this->hasMany(\App\Models\Task\Task::class,'todolist_id','id');
    }

    public function users(){
    	return $this->belongsToMany(\App\User::class, 'todolist_user', 'todolist_id', 'user_id');
    }

    public function isAuthor(){
    	return $this->created_user_id == Auth::user()->id;
    }
}
