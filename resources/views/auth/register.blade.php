@extends('layout/default')

@section('content')

{!! Form::open(['method' => 'POST']) !!}

	<div class="form-group">
		<?php $id = 'name' ?>
		{!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
		{!! Form::text($id, null, ['id' => $id, 'class' => 'form-control', 'placeholder' => labels($id), 'required']) !!}
	</div>

	<div class="form-group">
		<?php $id = 'email' ?>
		{!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
		{!! Form::email($id, null, ['id' => $id, 'class' => 'form-control', 'placeholder' => labels($id), 'required']) !!}
	</div>

	<div class="form-group">
		<?php $id = 'password' ?>
		{!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
		{!! Form::password($id, ['id' => $id, 'class' => 'form-control', 'placeholder' => labels($id), 'required']) !!}
	</div>

	<div class="form-group">
		<?php $id = 'password_confirmation' ?>
		{!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
		{!! Form::password($id, ['id' => $id, 'class' => 'form-control', 'placeholder' => labels($id), 'required']) !!}
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-primary">Regisztráció</button>
	</div>

{!! Form::close() !!}

@endsection
