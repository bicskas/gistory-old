<?php $attributes = $attributes + array(
	'id' => $id,
	'class' => 'form-control',
	'placeholder' => labels($id),
) ?>

<div class="form-group">
	{!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
	{!! Form::textarea($id, $model->$id, $attributes) !!}
	@if ($help)
		<span class="help-block">{!! $help !!}</span>
	@endif
</div>
