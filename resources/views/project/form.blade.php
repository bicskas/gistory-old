@extends('admin/admin')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h3 class="panel-title pull-left">{{trans_choice('admin.' . $aktiv_oldal, 1)}} szerkesztése</h3>
		<div class="pull-right">
			<a href="/{{$aktiv_oldal}}" class="btn-info btn btn-xs">
				<span class="glyphicon glyphicon-arrow-left"></span> Vissza
			</a>
		</div>
	</div>
	<div class="panel-body">
		{!! Form::model($model, array('url' => $model->createLink(), 'method' => $method, 'files' => true)) !!}
		{!! Form::hidden('_class_name', get_class($model)) !!}
		
		<?php $id = 'cim' ?>
		{!! Form::bsText($id, $model, ['required']) !!}
		
		<?php $id = 'leiras' ?>
		{!! Form::bsText($id, $model, [], 'Automatikusan generálódik, de felülírható') !!}

		<?php $id = 'szoveg' ?>
		{!! Form::bsTextarea($id, $model, ['class' => 'form-control ckeditor']) !!}

		<hr>

		{!! Form::mentes() !!}
		
		{!! Form::close() !!}
	</div>
	<div class="panel-footer">
	</div>
</div>
@endsection