<script type="text/javascript">
	$('#create-todolist').on('click', function(){
		$('.create-update-todolist-title-modal').text('Create to-do list');
		$('#create-todolist-btn').text('Create');
		$('#new-todolist-modal').modal('show');
	});

	$('#new-todolist-modal').on('shown.bs.modal', function(){
		// Problem: User interaction doesn't provide desired results.
		// Solution: Add interactivity so the user can manage daily tasks

		var taskInput = document.getElementById("new-task");
		var addButton = document.getElementById("haha");
		var incompleteTasksHolder = document.getElementById("incomplete-tasks");
		var completedTasksHolder = document.getElementById("completed-tasks");

		//New Task List Item
		var createNewTaskElement = function(taskString) {
		  //Create List Item
		  var listItem = document.createElement("li");

		  //input (checkbox)
		  var checkBox = document.createElement("input"); // checkbox
		  //label
		  var label = document.createElement("label");
		  //input (text)
		  var editInput = document.createElement("input"); // text
		  //button.edit
		  var editButton = document.createElement("button");
		  //button.delete
		  var deleteButton = document.createElement("button");
		  
		      //Each element needs modifying

		      checkBox.type = "checkbox";
		      editInput.type = "text";

		      editButton.innerText = "Edit";
		      editButton.className = "edit";
		      deleteButton.innerText = "Delete";
		      deleteButton.className = "delete";
		      deleteButton.type = "button";
		      editButton.type = "button";

		      label.innerText = taskString;


		      // each element needs appending
		      listItem.appendChild(checkBox);
		      listItem.appendChild(label);
		      listItem.appendChild(editInput);
		      listItem.appendChild(editButton);
		      listItem.appendChild(deleteButton);

		      return listItem;
		  }

		// Add a new task
		var addTask = function() {
			
		  //Create a new list item with the text from #new-task:
		  if(taskInput.value != ''){
		  	var listItem = createNewTaskElement(taskInput.value);
		  
			//Append listItem to incompleteTasksHolder
			incompleteTasksHolder.appendChild(listItem);
			bindTaskEvents(listItem, taskCompleted);
		  }
		    
		  
		  taskInput.value = "";   
		}

		// Edit an existing task
		var editTask = function() {
			

			var listItem = this.parentNode;

			var editInput = listItem.querySelector("input[type=text]")
			var label = listItem.querySelector("label");

			var containsClass = listItem.classList.contains("editMode");
		    //if the class of the parent is .editMode 
		    if(containsClass) {
		      //switch from .editMode 
		      //Make label text become the input's value
		      label.innerText = editInput.value;
		  } else {
		      //Switch to .editMode
		      //input value becomes the label's text
		      editInput.value = label.innerText;
		  }
		  
		    // Toggle .editMode on the parent
		    listItem.classList.toggle("editMode");

		}


		// Delete an existing task
		var deleteTask = function() {
			
			var listItem = this.parentNode;
			var ul = listItem.parentNode;

		  //Remove the parent list item from the ul
		  ul.removeChild(listItem);
		}

		// Mark a task as complete 
		var taskCompleted = function() {
			
		  //Append the task list item to the #completed-tasks
		  var listItem = this.parentNode;
		  completedTasksHolder.appendChild(listItem);
		  bindTaskEvents(listItem, taskIncomplete);
		}

		// Mark a task as incomplete
		var taskIncomplete = function() {
			
		  // When checkbox is unchecked
		  // Append the task list item #incomplete-tasks
		  var listItem = this.parentNode;
		  incompleteTasksHolder.appendChild(listItem);
		  bindTaskEvents(listItem, taskCompleted);
		}

		var bindTaskEvents = function(taskListItem, checkBoxEventHandler) {
			
		  //select taskListItem's children
		  var checkBox = taskListItem.querySelector("input[type=checkbox]");
		  var editButton = taskListItem.querySelector("button.edit");
		  var deleteButton = taskListItem.querySelector("button.delete");
		  
		  //bind editTask to edit button
		  editButton.onclick = editTask;
		  
		  //bind deleteTask to delete button
		  deleteButton.onclick = deleteTask;
		  
		  //bind checkBoxEventHandler to checkbox
		  checkBox.onchange = checkBoxEventHandler;
		}

		var ajaxRequest = function() {
			
		}

		// Set the click handler to the addTask function
		//addButton.onclick = addTask;
		addButton.addEventListener("click", addTask);
		addButton.addEventListener("click", ajaxRequest);


		// Cycle over the incompleteTaskHolder ul list items
		for(var i = 0; i <  incompleteTasksHolder.children.length; i++) {
		    // bind events to list item's children (taskCompleted)
		    bindTaskEvents(incompleteTasksHolder.children[i], taskCompleted);
		}
		// Cycle over the completeTaskHolder ul list items
		for(var i = 0; i <  completedTasksHolder.children.length; i++) {
		    // bind events to list item's children (taskIncompleted)
		    bindTaskEvents(completedTasksHolder.children[i], taskIncomplete); 

		}
	});

function todoListData(todoListId){
	var todoListId = todoListId;
	var tasks = [];

	if(todoListId == 0){
		$('#incomplete-tasks').children('li').each(function(){
			var task = {
				name: $(this).hasClass('editMode') ? $(this).children('input[type="text"]').val() : $(this).children('label').text(),
				status: 1
			};

			tasks.push(task);
		});

		$('#completed-tasks').children('li').each(function(){
			var task = {
				name: $(this).hasClass('editMode') ? $(this).children('input[type="text"]').val() : $(this).children('label').text(),
				status: 0
			};

			tasks.push(task);
		});
	}
	else{
		$('#incomplete-tasks').children('li').each(function(){
			var task = {
				id: $(this).children('input[type="hidden"]').val(),
				name: $(this).hasClass('editMode') ? $(this).children('input[type="text"]').val() : $(this).children('label').text(),
				status: 1
			};

			tasks.push(task);
		});

		$('#completed-tasks').children('li').each(function(){
			var task = {
				id: $(this).children('input[type="hidden"]').val(),
				name: $(this).hasClass('editMode') ? $(this).children('input[type="text"]').val() : $(this).children('label').text(),
				status: 0
			};

			tasks.push(task);
		});
	}
	

	return {
		todoListId: todoListId,
		todoList_name: $('#todolist-name').val(),
		tasks: tasks
	};

}

function createTodoList(){
	$.ajax({
		url: '{{route('todolist.create')}}',
		type: 'POST',
		data: todoListData(0),
		success: function(data){
			$('#list-todolists').prepend(data);
			$('#new-todolist-modal').modal('hide');
		},
		error: function(){

		}
	});

}

function updateTodoList(){
	$.ajax({
		url: '{{route('todolist.update')}}',
		type: 'POST',
		data: todoListData($('#updatetodolistid').val()),
		success: function(data){
			$('.todo-card').each(function(){
				;
				if($(this).children('.todolist-detail').children('.todolist-detail-info').children('#todolistid').val() == $('#updatetodolistid').val()){
					
					$(this).replaceWith(data);
				}
			});

			$('#new-todolist-modal').modal('hide');
		},
		error: function(){

		}
	});
	
}

function getTodoList(todoListId){
	$.ajax({
		url: '{{route('todolist.get')}}',
		type: 'POST',
		data: todoListData(todoListId),
		success: function(data){
			var parsedData = jQuery.parseJSON( data );
			

			var JSONObject1 = parsedData.incomplete_tasks;

			// for (var i = 0; i < parsedData.incomplete_tasks.length; i++) {
			// 	$('#incomplete-tasks').append('<li><input type="checkbox"><input type="hidden" value="'+parsedData['incomplete_tasks'][i].id+'"><label>' + parsedData['incomplete_tasks'][i].name + '</label><input type="text" class="form-control"><button type="button" class="edit">Edit</button><button type="button" class="delete">Delete</button></li>');
			
			// }

			for (var key in JSONObject1) {
				if (JSONObject1.hasOwnProperty(key)) {
			      
			      $('#incomplete-tasks').append('<li><input type="checkbox"><input type="hidden" value="'+JSONObject1[key]["id"]+'"><label>' + JSONObject1[key]["name"] + '</label><input type="text" class="form-control"><button type="button" class="edit">Edit</button><button type="button" class="delete">Delete</button></li>');
			  }
			}

			var JSONObject2 = parsedData.completed_tasks;

			for (var key in JSONObject2) {
				if (JSONObject2.hasOwnProperty(key)) {
			      
			      $('#completed-tasks').append('<li><input type="checkbox" checked><input type="hidden" value="'+JSONObject2[key]["id"]+'"><label>' + JSONObject2[key]["name"] + '</label><input type="text" class="form-control"><button type="button" class="edit">Edit</button><button type="button" class="delete">Delete</button></li>');
			  }
			}

			// for (var j = 0; j < parsedData.completed_tasks.length; j++) {
			// 	$('#completed_tasks').append('<li><input type="checkbox" checked><label>' + parsedData['completed_tasks'][j].name + '</label><input type="text" class="form-control"><button class="edit">Edit</button><button class="delete">Delete</button></li>');
			
			// }

			$('#todolist-name').val(parsedData.name)

			$('#new-todolist-modal').modal('show');

		},
		error: function(){

		}
	});
}

function getUserByEmail(email){
	$.ajax({
		url: '{{route('users.getbyemail')}}',
		type: 'POST',
		data: {email:email},
		success: function(data){
			if(data == 0){
				bootbox.alert('Invalid User!');
			}
			else{
				var parsedData = $.parseJSON(data);
				
				var collaboratorElement = '<li class="collaborator-id" data-userid="'+ parsedData.id+'" >'+ parsedData.name +' - '+parsedData.email+'<i data-toggle="tooltip" title="Remove" class="fa fa-minus-circle remove-tdl-collaborator" aria-hidden="true"></i></li>';
				$('.todolist-collaborators-list').append(collaboratorElement);
				
			}
		},
		error: function(){

		}
	});
}

function todoListCollaboratorData(todoListId){
	var userIds = [];

	$('.collaborator-id').each(function(){
		var userId = $(this).data('userid');
		userIds.push(userId);
	});

	return {
		todoListId: todoListId,
		userIds: userIds
	};
}

function getTodoListCollaborator(todoListId){
	if($('.collaborator-id').length > 0){
		$('.collaborator-id').each(function(){
			$(this).remove();
		});
	}

	$.ajax({
		url: '{{route('todolist.getmember')}}',
		type: 'POST',
		data: {todoListId: todoListId},
		success: function(data){
			var parsedData = $.parseJSON(data);

			var usersArr = parsedData.users;

			for (var key in usersArr) {
				if (usersArr.hasOwnProperty(key)) {
			    	var collaboratorElement = '<li class="collaborator-id" data-userid="'+ usersArr[key]["id"] +'" >'+ usersArr[key]["name"] +' - '+usersArr[key]["email"]+'<i data-toggle="tooltip" title="Remove" class="fa fa-minus-circle remove-tdl-collaborator" aria-hidden="true"></i></li>';
					$('.todolist-collaborators-list').append(collaboratorElement);
			  }
			}

			// for (var i = 0; i < parsedData['users'].length; i++) {
			// 	var collaboratorElement = '<li class="collaborator-id" data-userid="'+ parsedData.id+'" >'+ parsedData.name +' - '+parsedData.email+'<i data-toggle="tooltip" title="Remove" class="fa fa-minus-circle remove-tdl-collaborator" aria-hidden="true"></i></li>';
			// 	$('.todolist-collaborators-list').append(collaboratorElement);
			// }
		},
		error: function(data){

		}
	});
	
}

function updateTodoListCollaborator(todoListId){
	$.ajax({
		url: '{{route('todolist.addmember')}}',
		type: 'POST',
		data: todoListCollaboratorData(todoListId),
		success: function(data){
			if(data.resultcode == 1){
				$('#todolist-collaborators-modal').modal('hide');
				// bootbox.alert('Update to-do list successfully');
			}
			else{

			}
		},
		error: function(data){

		}
	});
	
}


$('body').on('click', '.delete-tdl-btn', function(event){
	var todoListId = $(this).parents('.todolist-detail').children('.todolist-detail-info').children('#todolistid').val();
	var todoListElement = 

	bootbox.confirm({
		message: "Are you sure you want to delete this to-do list?",
		buttons: {
			confirm: {
				label: 'Yes',
				className: 'btn-primary'
			},
			cancel: {
				label: 'No',
				className: 'btn-default'
			}
		}, 
		callback: function(result){ 
			if(result){
				$.ajax({
					url: '{{route('todolist.delete')}}',
					type: 'POST',
					data: {
						todoListId : todoListId
					},
					success: function(data){
						if(data){
							bootbox.alert("Deleted successfully!");
						}
						else{
							bootbox.alert("Something went wrong, please try again later!");
						}

						$('.todo-card').each(function(){
							if($(this).children('.todolist-detail').children('.todolist-detail-info').children('#todolistid').val() == todoListId){
								$(this).remove();
							}
						});
					},
					error: function(){

					}
				});
			} 
		}
	});
});

$('body').on('click', '.putback-tdl-btn', function(event){
	var todoListId = $(this).parents('.todolist-detail').children('.todolist-detail-info').children('#todolistid').val();

	bootbox.confirm({
		message: "Are you sure you want to put back this to-do list?",
		buttons: {
			confirm: {
				label: 'Yes',
				className: 'btn-primary'
			},
			cancel: {
				label: 'No',
				className: 'btn-default'
			}
		}, 
		callback: function(result){ 
			if(result){
				$.ajax({
					url: '{{route('todolist.putback')}}',
					type: 'POST',
					data: {
						todoListId : todoListId
					},
					success: function(data){
						if(data){
							bootbox.alert("Put back successfully!");
						}
						else{
							bootbox.alert("Something went wrong, please try again later!");
						}

						$('.todo-card').each(function(){
							if($(this).children('.todolist-detail').children('.todolist-detail-info').children('#todolistid').val() == todoListId){
								$(this).remove();
							}
						});
					},
					error: function(){

					}
				});
			} 
		}
	});
});

$('body').on('click', '.collaborator-tdl-btn', function(){
	var todoListId = $(this).parents('.todolist-detail').children('.todolist-detail-info').children('#todolistid').val();
	getTodoListCollaborator(todoListId);
	$('#todolist-id').val(todoListId);
	$('#todolist-collaborators-modal').modal('show');
});

$('body').on('click', '#create-todolist-btn', function(){

	if($('#todolist-name').val() == ''){
		bootbox.alert('Please input to-do list name!');
	}

	else if($('#updatetodolistid').val()==0 && $('#todolist-name').val() != ''){
		createTodoList();
	}
	else if($('#updatetodolistid').val()!=0 && $('#todolist-name').val() != ''){
		updateTodoList();
	}
	
});

$('body').on('click', '.remove-tdl-collaborator', function(){
	$(this).parent('.collaborator-id').remove();
});

$('#save-todolist-collaborator-btn').on('click',function(){
	// if($('.collaborator-id').length > 0){
		updateTodoListCollaborator($('#todolist-id').val());
	// }
});


$('#add-new-collaborator').on('click', function(){
	// addTodoListMember($('#new-collaborator-email').val());
	getUserByEmail($('#new-collaborator-email').val());
	$('#new-collaborator-email').val('');
});

$('#new-todolist-modal').on('hidden.bs.modal', function(){
	document.getElementById('create-update-todolist-form').reset();
	$('#incomplete-tasks').html('');
	$('#completed-tasks').html('');
});

$('#todolist-collaborators-modal').on('hidden.bs.modal', function(){
	document.getElementById('todolist-collaborators-form').reset();
});

$('#search-todolist-btn').on('click', function(){
	$.ajax({
		url: '{{route('todolist.search')}}',
		type: 'POST',
		data: {todoListName: $('#search-todolist').val()},
		success: function(){
			$('#list-todolists').html('');
		},
		error: function(){

		}
	});
	
});

$(document).ready(function(){
	$('body').on('click', '.todolist-detail-info', function(){
		var thisCard = $(this);
		$('.create-update-todolist-title-modal').text('Update to-do list');
		$('#create-todolist-btn').text('Update');
		$('#updatetodolistid').val(thisCard.children('#todolistid').val());
		getTodoList($('#updatetodolistid').val());
		$('#new-todolist-modal').modal('show');
	});
	$('[data-toggle="tooltip"]').tooltip(); 
});



// var colorList = [ '000000', '993300', '333300', '003300', '003366', '000066' ];

// $('body').click(function () {
// 	picker.fadeOut();
// });

// $('.call-picker').click(function(event) {
// 	event.stopPropagation();
// 	// var picker = $('#color-picker');
// 	var picker = $(this).parent('.todolist-footer').children('#color-picker');

// 	for (var i = 0; i < colorList.length; i++ ) {
// 		picker.append('<li class="color-item" data-hex="' + '#' + colorList[i] + '" style="background-color:' + '#' + colorList[i] + ';"></li>');
// 	}

// 	picker.fadeIn();
// 	picker.children('li').hover(function() {
// 		var codeHex = $(this).data('hex');

// 		$('.color-holder').css('background-color', codeHex);
// 		$('#pickcolor').val(codeHex);
// 	});
// });
</script>
