@extends('layouts.app')

@section('content')
	@foreach($users as $index => $user)
		{{ $user->name }}
	@endforeach
@stop