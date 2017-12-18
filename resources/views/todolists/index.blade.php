@extends('layouts.todolists')

@section('content')

<div class="">
	<div class="todo-list-toolbar row form-group">
		<div class="create-new-todolist col-xs-12 col-sm-4 col-md-4 col-lg-3">
			<button class="btn-success btn pull-left" id="create-todolist">New to-do list</button>
		</div>

		<!-- <div class="search-todolist-box col-xs-12 col-sm-8 col-md-8 col-lg-5">
			<input type="text" class="form-control" name="search-todolist" id="search-todolist" placeholder="Search to-do list">
		</div> -->
		<!-- <div class="input-group search-todolist-box col-xs-12 col-sm-8 col-md-8 col-lg-5">
			<input type="text" class="form-control" id="search-todolist" placeholder="Search to-do list">
			<div class="input-group-btn">
				<button class="btn btn-default" type="button" id="search-todolist-btn">
					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</div>
		</div> -->
	</div>


	<!-- All todo list showed here -->
	<div class="all-todolist row" id="list-todolists">
		@foreach($todolists as $todolist)
		@include('todolists.todolist-card',compact('todolist'))
		@endforeach

		{!! $todolists->render() !!}
	</div>


</div>


<!-- Create new/ edit to-do list modal -->
<div class="modal fade" id="new-todolist-modal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title create-update-todolist-title-modal"><strong>New to-do list</strong></h4>
			</div>
			<div class="modal-body">
				<form id="create-update-todolist-form">
					<input type="hidden" name="updatetodolistid" id="updatetodolistid" value="">
					<div class="form-group">
						<input type="text" name="todolist-name" id="todolist-name" class="form-control" placeholder="To-do list name" value="">
					</div>

					<div class="form-group">
						<div class="create-todolist-container">
							<p>
								<label for="new-task">Add Task</label><input id="new-task" type="text" class="form-control"><button type="button" id="haha">Add</button>
							</p>

							<h3>Todo</h3>
							<ul id="incomplete-tasks">
								<!-- <li><input type="checkbox"><label>Pay Bills</label><input type="text" class="form-control"><button class="edit">Edit</button><button class="delete">Delete</button></li>
									<li class="editMode"><input type="checkbox"><label>Go Shopping</label><input type="text" value="Go Shopping"><button class="edit">Edit</button><button class="delete">Delete</button></li> -->

								</ul>

								<h3>Completed</h3>
								<ul id="completed-tasks">
									<!-- <li><input type="checkbox" checked><label>See the Doctor</label><input type="text" class="form-control"><button class="edit">Edit</button><button class="delete">Delete</button></li> -->
								</ul>
							</div>
						</div>

					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" id="create-todolist-btn">Create</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- To-do list collaborators modal -->
	<div class="modal fade" id="todolist-collaborators-modal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<input type="hidden" name="todolist-id" id="todolist-id" value="">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><strong>To-do list collaborator</strong></h4>
				</div>
				<div class="modal-body">
					<form id="todolist-collaborators-form">
						<div class="todolist-collaborators-add">
							<div class="form-group row">
								<label class="col-xs-12 col-sm-4 col-md-4 text-right">Add new collaborator</label>
								<input class="form-control col-xs-9 col-sm-6 col-md-6" type="text" name="new-collaborator-email" placeholder="Collaborator Email" id="new-collaborator-email">
								<a class="col-xs-3 col-sm-2 col-md-2" id="add-new-collaborator"><i class="fa fa-plus" aria-hidden="true"></i></a>
							</div>
						</div>

						<div class="todolist-collaborators-list">
							<!-- <span class="todolist-collaborator-email row">hahahaha@email.com<i class="fa fa-minus" aria-hidden="true"></i></span> -->
							<li class="" data-userid="" >{{Auth::user()->name}} - {{Auth::user()->email}} (owner)</li>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" id="save-todolist-collaborator-btn">Save</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	@stop

	@section('js')
	@include('todolists.script')
	@stop