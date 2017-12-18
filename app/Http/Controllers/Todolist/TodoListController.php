<?php

namespace App\Http\Controllers\Todolist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task\TodoList;
use App\Models\Task\Task;
use Auth;

class TodoListController extends Controller
{
    public function index(){

    	$sharedtodolists = Auth::user()->todolists()->where('status', 1)->where('created_user_id','<>', Auth::user()->id)->with('tasks')->orderBy('created_at', 'desc')->get();

    	$todolists = TodoList::where('status',1)->where(function($query) use ($sharedtodolists){
    		return $query->whereIn('id',$sharedtodolists->pluck('id')->toArray())->orWhere('created_user_id',Auth::user()->id);
    	})->with('tasks')->orderBy('created_at', 'desc')->paginate(5);

    	foreach($todolists as $todolist){
	    	$todolist->incomplete_tasks = $todolist->tasks->filter(function($task){
	    		return $task->status == 1;
	    	});

	    	$todolist->completed_tasks = $todolist->tasks->filter(function($task){
	    		return $task->status == 0;
	    	});
    	}

    	return view('todolists.index', compact('todolists'));
    }



    public function create(Request $request){
    	$data = $request->all();
    	
    	// create todolist
    	$todolist = TodoList::create([
    		'name' => $data['todoList_name'],
    		'status'=> 1,
    		'created_user_id' => Auth::user()->id,
    		'description' => ''
    	]);

    	$todolist->tasks = collect();

    	if(array_key_exists("tasks",$data)){
    		// create tasks
	    	foreach($data['tasks'] as $data_task){
	    		$task = Task::create([
	    			'todolist_id' => $todolist->id,
	    			'name' 		=> $data_task['name'],
	    			'status'	=> $data_task['status'],
	    			'description' => ''
	    		]);

	    		$todolist->tasks = $todolist->tasks->push($task);  
	    	}
    	}

    	$todolist->incomplete_tasks = $todolist->tasks->filter(function($task){
    		return $task->status == 1;
    	});

    	$todolist->completed_tasks = $todolist->tasks->filter(function($task){
    		return $task->status == 0;
    	});

    	return view('todolists.todolist-card',compact('todolist'));
    }

    public function get(Request $request){

    	$data = $request->all();

    	$todolist = TodoList::where('id', $data['todoListId'])->with('tasks')->first();

    	$todolist->incomplete_tasks = $todolist->tasks->filter(function($task){
    		return $task->status == 1;
    	});

    	$todolist->completed_tasks = $todolist->tasks->filter(function($task){
    		return $task->status == 0;
    	});



    	return $todolist->toJson();
    }

    public function update(Request $request){
    	$data = $request->all();

    	$todolist = TodoList::where('id', $data['todoListId'])->with('tasks')->first();

    	$tasksIdArr = [];

    	if(array_key_exists("tasks",$data)){
    		foreach ($data['tasks'] as $data_task) {
	    		if(array_key_exists('id', $data_task)){
	    			array_push($tasksIdArr, $data_task['id']);
	    		}
	    	}
    	}

    	$tasksToDelete = $todolist->tasks->filter(function($task) use ($tasksIdArr){
    		return !in_array($task->id, $tasksIdArr);
    	});

		foreach ($tasksToDelete as $taskToDelete) {
			$taskToDelete->delete();
		}

    	// update todolist task
    	if(array_key_exists("tasks",$data)){
    		foreach($data['tasks'] as $data_task){
	    		if(array_key_exists('id', $data_task)){
	    			$task = $todolist->tasks->filter(function($task) use ($data_task){
		    			return $task->id == $data_task['id'];
		    		})->first();

		    		$task = $task->update([
			    		'name' => $data_task['name'],
			    		'status' => $data_task['status']   	
			    	]); 
	    		}
	    		else{
	    			$task = Task::create([
		    			'todolist_id' => $todolist->id,
		    			'name' 		=> $data_task['name'],
		    			'status'	=> $data_task['status'],
		    			'description' => ''
		    		]);
	    		}
	    		 
	    	}
    	}
    	

    	$todolist = TodoList::where('id', $data['todoListId'])->with('tasks')->first();

    	$todolist->incomplete_tasks = $todolist->tasks->filter(function($task){
    		return $task->status == 1;
    	});

    	$todolist->completed_tasks = $todolist->tasks->filter(function($task){
    		return $task->status == 0;
    	});

    	return view('todolists.todolist-card',compact('todolist'));
    }

    public function delete(Request $request){
    	$data = $request->all();

    	$todolist = TodoList::where('id', $data['todoListId'])->first();

    	$result = $todolist->update([
    		'status' => 0
    	]);

    	if($result == true){
    		return 1;
    	}
    	else return 0;

    }

    public function getTodoListInTrash(){
    	$todolists = TodoList::where('status', 0)->where('created_user_id', Auth::user()->id)->with('tasks')->orderBy('created_at', 'desc')->paginate(20);

    	foreach($todolists as $todolist){
	    	$todolist->incomplete_tasks = $todolist->tasks->filter(function($task){
	    		return $task->status == 1;
	    	});

	    	$todolist->completed_tasks = $todolist->tasks->filter(function($task){
	    		return $task->status == 0;
	    	});
    	}

    	return view('todolists.trash', compact('todolists'));
    }

    public function putBackTodoList(Request $request){
    	$data = $request->all();

    	$todolist = TodoList::where('id', $data['todoListId'])->first();

    	$result = $todolist->update([
    		'status' => 1
    	]);

    	if($result == true){
    		return 1;
    	}
    	else return 0;

    }

    public function getTodoListMember(Request $request){
    	$data = $request->all();

    	$todolist = TodoList::where('id', $data['todoListId'])->with('users')->first();

    	return $todolist->toJson();
    }

    public function updateTodoListMember(Request $request){
    	$data = $request->all();

    	$returnData = array('resultcode' => 1, 'message' => 'Update todo-list collaborators successfully!');

    	// dd($data);

    	$todolist = TodoList::where('id', $data['todoListId'])->first();

    	//detach all member first
    	$detachResult = $todolist->users()->detach();

    	if(array_key_exists("userIds",$data)){
    		foreach ($data['userIds'] as $userId) {
	    		$attachResutlt = $todolist->users()->attach([$userId]);
	    	}
    	}

    	return $returnData;
    }

    public function search(Request $request){
    	$data = $request->all();

    	$sharedtodolists = Auth::user()->todolists()->where('status', 1)->where('created_user_id','<>', Auth::user()->id)->with('tasks')->where('name', $data['todoListName'])->orderBy('created_at', 'desc')->get();

    	$todolists = TodoList::where('status',1)->where(function($query) use ($sharedtodolists){
    		return $query->whereIn('id',$sharedtodolists->pluck('id')->toArray())->orWhere('created_user_id',Auth::user()->id);
    	})->where('name', $data['todoListName'])->orderBy('created_at', 'desc')->paginate(5);

    	foreach($todolists as $todolist){
	    	$todolist->incomplete_tasks = $todolist->tasks->filter(function($task){
	    		return $task->status == 1;
	    	});

	    	$todolist->completed_tasks = $todolist->tasks->filter(function($task){
	    		return $task->status == 0;
	    	});
    	}

    	return view('todolists.todolist-cards', compact('todolists'));
    }

}
