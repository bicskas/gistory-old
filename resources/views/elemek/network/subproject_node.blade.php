
{{--Új csúcs hozzáadása--}}
<h3>Nodes</h3>
{!! Form::open(['class' => 'form-inline','url' => "/network/$projectid/node",'method' => 'POST']) !!}

{{ Form::label('nev', 'Név') }}
{{ Form::text('nev','',['required' => 'required','class' => '','placeholder' => 'Név','autocomplete' => 'off']) }}

{!! Form::submit('Új hozzáadása',['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}

<hr style="border-color: #ddd">


{{--Csúcsok felsorolása és csoportok változtatása--}}
{!! Form::open(['url' => "/network/$projectid/$subproject->id/group",'method' => 'POST']) !!}


<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>Név</th>
            <th>Csoport</th>
            <th class="text-right">Műveletek</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($nodes as $n => $node)
            <tr id="item_{{$node->id}}">
                <td>{!! $node->nev !!} [Fokszám: {!! $degrees[$n] !!}]</td>
                <td>
                    <div class="form-group">
                        {{--{{ Form::label('csoport', 'Csoport: ') }}--}}
                        {{ Form::text('csoport['.$node->id.']', $node->subproject()->where('subproject_id', $subproject->id)->first()->pivot->group,['class' => '','placeholder' => 'Csoport']) }}
                    </div>
                </td>
                <td class="text-right">
                    <a class="btn btn-danger btn-xs torol" title="Töröl" href="{{$node->createLink()}}">
                        <span class="glyphicon glyphicon-trash"></span> Töröl
                    </a>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="text-right">
                {!! Form::submit('Mentés',['class' => 'btn-primary btn']) !!}
            </td>
        </tr>
        </tbody>
    </table>
</div>

{!! Form::close() !!}
