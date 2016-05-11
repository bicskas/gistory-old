<?php $attributes = $attributes + array(
	'id' => $id,
	'class' => 'form-control',
) ?>
<?php $multiple = in_array('multiple', $attributes) ?>

<div class="form-group">
	{!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
	{!! Form::select($id . ($multiple ? '[]' : ''), $options, ($multiple ? $model->$id->lists('id')->all() : $model->$id), $attributes) !!}
	@if ($help)
		<span class="help-block">{!! $help !!}</span>
	@endif
</div>
