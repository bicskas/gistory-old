@extends('admin/admin')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h3 class="panel-title pull-left">{{trans_choice('admin.' . $aktiv_oldal, 1)}} szerkesztése</h3>
		<div class="pull-right">
			<a href="/admin/{{$aktiv_oldal}}" class="btn-info btn btn-xs">
				<span class="glyphicon glyphicon-arrow-left"></span> Vissza
			</a>
			<a href="/admin/{{$aktiv_oldal}}/create" class="btn-primary btn btn-xs">
				<span class="glyphicon glyphicon-plus"></span> Új hozzáadása
			</a>
		</div>
	</div>
	<div class="panel-body">
		{!! Form::model($model, array('url' => $model->adminLink(), 'method' => $method, 'files' => true)) !!}
		{!! Form::hidden('_class_name', get_class($model)) !!}
		
		
		<?php $id = 'menu_id' ?>
		{!! Form::bsSelect($id, $model, $menuk) !!}
	
		<?php $id = 'tipus' ?>
		{!! Form::bsSelect($id, $model, $tipusok, ['class' => 'form-control menu_tipus', 'required']) !!}
		
		<?php $id = 'szoveg_id' ?>
		{!! Form::bsSelect($id, $model, $szovegek, ['required']) !!}

		<?php $id = 'nev' ?>
		{!! Form::bsText($id, $model, ['required']) !!}

		<?php $id = 'link' ?>
		{!! Form::bsText($id, $model, [], 'Automatikusan generálódik, de felülírható') !!}

		@foreach (['seotitle', 'seokeywords', 'seodescription', 'ogtitle', 'ogdescription'] as $id)
			<div class="form-group">
				{!! Form::bsText($id, $model) !!}
			</div>
		@endforeach

		<div class="form-group">
			<?php $id = 'ujablak' ?>
			{!! Form::bsCheckbox($id, $model, 1) !!}
			
			<div class="checkbox">
				<?php $id = 'aktiv' ?>
				<label>
					{!! Form::checkbox($id, 1, $model->exists ? $model->$id : true, ['id' => $id]) !!}
					{{labels($id)}}
				</label>
			</div>
		</div>

		<?php $id = 'kep' ?>
		{!! Form::bsKep($id, $model) !!}

		<hr>

		{!! Form::mentes() !!}

		{!! Form::close() !!}
	</div>
	<div class="panel-footer">
	</div>
</div>
@endsection