<?php

namespace App\Models\ALC;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['code', 'name'];
}
