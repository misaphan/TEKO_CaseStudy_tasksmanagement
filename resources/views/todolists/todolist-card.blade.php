<div class="col-xs-6 col-md-3 col-lg-3 col-sm-3 todo-card">
	<div class="todolist-detail">
		<div class="todolist-detail-info">
			<input type="hidden" name="todolistid" id="todolistid" value="{{$todolist->id}}">
			<div class="todolist-header">
				<h4 class="todolist-name"><strong>{{$todolist->name}}</strong></h4>
			</div>
			<div class="todolist-task">
				<div class="todolist-uncompleted">
					<ul>
						@foreach($todolist->incomplete_tasks as $task)
						<li>
							<input type="hidden" value="{{$task->id}}">
							<input type="checkbox" disabled><label>{{$task->name}}</label>
						</li>
						@endforeach
					</ul>
				</div>

				<div class="todolist-completed">
					<ul>
						@foreach($todolist->completed_tasks as $task)
						<li>
							<input type="hidden" value="{{$task->id}}">
							<input type="checkbox" checked disabled><label>{{$task->name}}</label>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		

		<div class="todolist-footer text-right">
			@if($todolist->status == 1)
				@if($todolist->isAuthor())
				<a data-toggle="tooltip" title="Members" class="collaborator-tdl-btn"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
				@endif

				<!-- <a data-toggle="tooltip" title="Color" name="custom_color" id="pickcolor" class="color-tdl-btn call-picker"><i class="fa fa-paint-brush" aria-hidden="true"></i></a>
				<div class="color-picker" id="color-picker" style="display: none"></div> -->
				@if($todolist->isAuthor())
				<a data-toggle="tooltip" title="Delete" class="delete-tdl-btn"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
				@endif
			@else
				<a data-toggle="tooltip" title="Put Back" class="putback-tdl-btn"><i class="fa fa-share" aria-hidden="true"></i></a>
			@endif

			<!-- <div class="color-wrapper"> -->
				<!-- <p>Choose color (# hex)</p> -->
				<!-- <input type="text" name="custom_color" placeholder="#FFFFFF" id="pickcolor" class="call-picker"> -->
				<!-- <div class="color-holder call-picker"></div> -->
				<!-- <div class="color-picker" id="color-picker" style="display: none"></div> -->
			<!-- </div> -->

		</div>
	</div>
</div>