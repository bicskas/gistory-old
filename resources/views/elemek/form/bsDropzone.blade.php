<div class="panel-body">
	<div class="well szuro">
		{!! Form::open(array('class' => 'dropzone', 'id' => 'dropzone', 'method' => 'POST', 'data-ajaxurl' => '/admin/' . $aktiv_oldal . '?id=' . $model->id, 'data-ajaxtarget' => $keplista)) !!}
			{!! Form::hidden('id', $model->id) !!}
			<div class="fallback">
				{!! Form::file('file') !!}
			</div>
		{!! Form::close() !!}
	</div>
</div>
