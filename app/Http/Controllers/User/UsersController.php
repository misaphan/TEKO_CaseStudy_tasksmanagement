<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    public function __construct(){

    }

    public function index(){
    	$users = User::with('roles')->get();
    	foreach ($users as $key => $user) {
    		$user->role = $user->roles->first();
    	}


    	return view('user.index', compact('users'));
    }

    public function getUserByEmail(Request $request){
    	$data = $request->all();

    	$user = User::where('email', $data['email'])->first();

    	if(gettype($user) == 'NULL'){
    		return 0;
    	}
    	else{
    		return $user->toJson();
    	}
    }
}
