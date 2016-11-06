<h5>Kapcsolatok</h5>
<ul class="list-group">

    {{--{!! dd($subproject->edge()->first()->node1) !!}--}}
@foreach($subproject->edge as $edge)
        <li class="list-group-item">{!! $edge->node1->nev !!} -- {!! $edge->node2->nev !!}</li>
    @endforeach


</ul>
