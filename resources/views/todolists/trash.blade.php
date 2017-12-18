@extends('layouts.todolists')

@section('content')

<div class="">

	<!-- All deleted todo list showed here -->
	<div class="all-todolist row" id="list-todolists">
		@foreach($todolists as $todolist)
			@include('todolists.todolist-card',compact('todolist'))
		@endforeach

		{!! $todolists->render() !!}
	</div>
</div>

@stop

@section('js')
@include('todolists.script')
@stop