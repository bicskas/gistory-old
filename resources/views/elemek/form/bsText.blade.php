<?php $attributes = $attributes + array(
	'id' => $id,
	'class' => 'form-control',
	'placeholder' => labels($id),
) ?>
<?php $type = array_get($attributes, 'type', 'text') ?>

<div class="form-group">
	{!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
	{!! Form::$type($id, $model->$id, $attributes) !!}
	@if ($help)
		<span class="help-block">{!! $help !!}</span>
	@endif
</div>
