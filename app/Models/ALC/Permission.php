<?php

namespace App\Models\ALC;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = ['code', 'name'];
}
