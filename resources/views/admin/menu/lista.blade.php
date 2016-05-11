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
		<div class="alert alert-info">
			<p>A menüpontok között mindenképpen kell lennie aktív <i>Termék</i> és <i>Kapcsolat</i> típusú menüpontnak, hogy az oldal hiánytalanul működhessen!</p>
		</div>
	</div>
	@if (count($lista) > 0)
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>{{labels('nev')}}</th>
					<th>{{labels('menu_id')}}</th>
					<th>{{labels('tipus')}}</th>
					<th>{{labels('aktiv')}}</th>
					<th class="text-right">Műveletek</th>
				</tr>
			</thead>
			<tbody class="rendezheto" data-action="/admin/ajax/sorrend/{{$aktiv_oldal}}">
				@foreach ($lista as $l)
				<tr id="item_{{$l->id}}">
					<td>{{$l->nev}}</td>
					<td>{{object_get($l->szulo, 'nev', '-')}}</td>
					<td>{{trans('admin.enum.menu.tipus.' . $l->tipus)}}</td>
					<td><span class="glyphicon glyphicon-{{$l->aktiv ? 'ok' : 'minus'}}"></span></td>
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
	<div class="panel-footer">
	</div>
</div>
@endsection