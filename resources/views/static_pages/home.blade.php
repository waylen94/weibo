@extends('layouts.default')
@section('content')
	<div class="jumbotron">
		<h1>Hello Laravel</h1>>
		<p class = "lead">
			this is a naughty or nice testing project  sssss
		</p>
		<p>
		everything begin here
		</p>
		<p>
			<a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">Sign In Now</a>
			
		</p>
		
	</div>
@stop