@extends('admin/admin')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h3 class="panel-title pull-left">{{trans_choice('admin.' . $aktiv_oldal, 2)}}</h3>
		<div class="pull-right">
			<a href="/admin/galeria" class="btn-info btn btn-xs">
				<span class="glyphicon glyphicon-arrow-left"></span> Vissza
			</a>
		</div>
	</div>
	{!! Form::bsDropzone($model) !!}
	{!! $keplista !!}
	<div class="panel-footer text-center">
	</div>
</div>
@endsection