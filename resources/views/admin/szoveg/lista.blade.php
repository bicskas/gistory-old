@extends('admin/admin')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h3 class="panel-title pull-left">{{trans_choice('admin.' . $aktiv_oldal, 2)}}</h3>
		<div class="pull-right">
			<a class="btn btn-primary btn-xs" href="/admin/{{$aktiv_oldal}}/create">
				<span class="glyphicon glyphicon-plus"></span> Új hozzáadása
			</a>
		</div>
	</div>
	<div class="panel-body">
		<div class="well szuro">
			{!! Form::open(['method' => 'GET', 'class' => 'form-inline']) !!}
				<div class="form-group">
					<?php $id = 'cim' ?>
					{!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
					{!! Form::text($id, Input::get($id), ['id' => $id, 'class' => 'form-control', 'placeholder' => labels($id)]) !!}
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-filter"></span> Szűrés</button>
					<a href="/admin/{{$aktiv_oldal}}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span> Szűrő törlése</a>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
	@if (count($lista) > 0)
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>{{labels('cim')}}</th>
					<th>{{labels('szoveg')}}</th>
					<th class="text-right">Műveletek</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($lista as $l)
				<tr id="item_{{$l->id}}">
					<td>{{$l->cim}}</td>
					<td>{{str_limit(strip_tags($l->szoveg))}}</td>
					<td class="text-right">
						<a class="btn btn-primary btn-xs" title="Szerkeszt" href="{{$l->adminLink()}}/edit">
							<span class="glyphicon glyphicon-pencil"></span> Szerkeszt
						</a>
						<a class="btn btn-danger btn-xs torol" title="Töröl" href="{{$l->adminLink()}}">
							<span class="glyphicon glyphicon-trash"></span> Töröl
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@else
	<div class="panel-body">
		<p>Ennek a listának még nincs eleme.</p>
	</div>
	@endif
	<div class="panel-footer text-center">
		{!! $lista->render() !!}
	</div>
</div>
@endsection