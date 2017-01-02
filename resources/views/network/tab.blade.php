<div role="tabpanel" class="tab-pane active" id="node">
    @include('elemek.network.subproject_node')
</div>
<div role="tabpanel" class="tab-pane" id="edge">
    @include('elemek.network.edge')
</div>

<div role="tabpanel" class="tab-pane" id="download">
    <div class="well" style="max-width:300px">
        <a href="/download/{{$projectid}}/nodes" class="btn btn-primary btn-block">Csúcsok
            letöltése</a>
        <a href="/download/{{$projectid}}/edges" class="btn btn-primary btn-block">Élek
            letöltése</a>
    </div>
</div>

<div role="tabpanel" class="tab-pane" id="svg-kep">
    <div id="svg" class="circular" data-json="/{{$file}}"></div>
</div>
<div role="tabpanel" class="tab-pane" id="force-graph">
    <div id="force" class="force" data-json="/{!! $forcefile !!}">
        <svg width="1000" height="800"></svg>
    </div>
</div>
<div role="tabpanel" class="tab-pane" id="statisztika">
    <div id="bar" data-nevek="{{$nevek}}" data-degree="{!! $degree !!}">
        <svg class="chart" width="1000" height="800"></svg>
    </div>
</div>