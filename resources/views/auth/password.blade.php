@extends('layout/default')

@section('content')

{!! Form::open(['method' => 'POST']) !!}

	<div class="form-group">
		<?php $id = 'email' ?>
		{!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
		{!! Form::email($id, null, ['id' => $id, 'class' => 'form-control', 'placeholder' => labels($id), 'required']) !!}
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-primary">Új jelszó kérése</button>
	</div>

{!! Form::close() !!}

@endsection
