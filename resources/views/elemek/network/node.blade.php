<h3>Nodes</h3>
{!! Form::open(['class' => 'form-inline','url' => "/network/$projectid/node",'method' => 'POST']) !!}

{{ Form::label('nev', 'Név') }}
{{ Form::text('nev','',['required' => 'required','class' => '','placeholder' => 'Név','autocomplete' => 'off']) }}

{!! Form::submit('Új hozzáadása',['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
<hr style="border-color: #ddd">
<h5>Nevek</h5>
<ul class="list-group">

    @foreach($nodes as $node)
        <li class="list-group-item">{!! $node->nev !!}<span class="pull-right"><a class="btn btn-danger btn-xs torol" title="Töröl" href="{{$node->createLink()}}">
                                            <span class="glyphicon glyphicon-trash"></span> Töröl
                                        </a></span></li>
    @endforeach

</ul>
