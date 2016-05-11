@extends('layout/default')

@section('content')

	<h1>{{$title}}</h1>

	{!! $model->szoveg !!}

@endsection