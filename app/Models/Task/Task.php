<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = ['todolist_id', 'name', 'description', 'status'];
}
