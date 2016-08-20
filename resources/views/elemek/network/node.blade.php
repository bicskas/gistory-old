<h3>Nodes</h3>
{!! Form::open(['class' => 'form-inline','url' => "/network/$projectid/node",'method' => 'POST']) !!}

{{ Form::label('nev', 'Név') }}
{{ Form::text('nev','',['required' => 'required','class' => '','placeholder' => 'Név','autocomplete' => 'off']) }}

{!! Form::submit('Új hozzáadása',['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}

@foreach($nodes as $node)

    @endforeach