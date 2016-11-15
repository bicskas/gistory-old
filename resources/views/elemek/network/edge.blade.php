<h5>Kapcsolatok</h5>
<ul class="list-group">

    {{--{!! dd($subproject->edge()->first()->node1) !!}--}}
@foreach($subproject->edge as $edge)
        <li class="list-group-item">{!! $edge->node1->nev !!} -- {!! $edge->node2->nev !!} Súly: {!! $edge->weight !!}<a class="btn btn-danger btn-xs confirm pull-right" title="Töröl" href="{!! route('deleteedge',[$edge->id,]) !!}">
                        <span class="glyphicon glyphicon-trash"></span> Töröl
                </a></li>
    @endforeach


</ul>
