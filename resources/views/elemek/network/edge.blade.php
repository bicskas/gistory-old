<h5>Kapcsolatok</h5>
<ul class="list-group">

    @foreach($edges as $edge)
        @foreach($edge->edge as $m)
            <li class="list-group-item">{!! $edge->nev !!} -- {!! $m->nev !!}</li>
        @endforeach
    @endforeach

</ul>
