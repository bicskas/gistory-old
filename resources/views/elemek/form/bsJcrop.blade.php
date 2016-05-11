<div class="form-group">
	{!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
	{!! Form::file($id, ['id' => $id, 'class' => 'form-control', 'placeholder' => labels($id)]) !!}
</div>
@if ($model->getImage())
	<a href="/admin/kep/torol/{{$model->className()}}/{{$model->id}}" class="confirm btn btn-danger btn-xs">
		<span class="glyphicon glyphicon-trash"></span> Töröl
	</a>
	@foreach (config('kepmeretek.' . $model->className(), array()) as $ar => $widths)
		<div class="form-group">
			<label>1:{{$ar}} arány</label>
			{!! Html::image($model->getImage() . '?r=' . rand(0,1000), '', ['class' => 'img-responsive jcrop', 'data-aspect-ratio' => $ar, 'data-selection' => $model->getKivagasok($ar)]) !!}
		</div>
	@endforeach
@endif
