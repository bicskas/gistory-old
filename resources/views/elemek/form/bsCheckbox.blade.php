<?php $attributes = $attributes + array(
	'id' => $id,
) ?>

<div class="checkbox">
	<label>
		{!! Form::checkbox($id, $value, $model->$id, ['id' => $id . $value]) !!}
		{{labels($id)}}
	</label>
	@if ($help)
		<span class="help-block">{!! $help !!}</span>
	@endif
</div>
