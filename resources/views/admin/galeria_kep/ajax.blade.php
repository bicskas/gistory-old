<div class="keplista">
	@if (count($lista) > 0)
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>{{labels('kep')}}</th>
					<th class="text-right">Műveletek</th>
				</tr>
			</thead>
			<tbody class="rendezheto" data-action="/admin/ajax/sorrend/{{$aktiv_oldal}}">
				@foreach ($lista as $l)
				<tr id="item_{{$l->id}}">
					<td>{!! Html::image($l->getImage(), '', ['class' => 'img-responsive', 'width' => 50]) !!}</td>
					<td class="text-right">
						<?php /*
						<a class="btn btn-primary btn-xs" title="Szerkeszt" href="{{$l->adminLink()}}/edit" data-toggle="tooltip">
							<span class="glyphicon glyphicon-pencil"></span> Szerkeszt
						</a>
						 */ ?>
						<a class="btn btn-danger btn-xs torol" title="Töröl" href="{{$l->adminLink()}}" data-toggle="tooltip">
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
</div>
