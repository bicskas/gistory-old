@extends('layout.default')

@section('content')
    <section id="projektek">
        <div class="container">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Alrojektek</h1>
                    <a class="btn btn-primary btn-xs text-right" href="/project/{!! $projectid !!}/subproject/create">
                        <span class="glyphicon glyphicon-plus"></span> Új hozzáadása
                    </a>
                    <a href="/project" class="btn-info btn btn-xs">
                        <span class="glyphicon glyphicon-arrow-left"></span> Vissza a projecthez
                    </a>

                </div>
                <div class="panel-body">

                    <div class="row">
                        @foreach($lista as $l)
                            <div class="col-sm-6" id="item_{!! $l->id !!}">
                                <div class="panel panel-default">
                                    <div class="panel-heading">{!! $l->nev !!}</div>
                                    <div class="panel-body">
                                        {!! $l->leiras !!}
                                    </div>
                                    <div class="panel-footer">
                                        <a class="btn btn-primary btn-xs text-right" href="/network/{!! $l->project->id !!}/{!! $l->id !!}">
                                            <span class="glyphicon glyphicon-plus"></span> Kapcsolatok
                                        </a>
                                        <a class="btn btn-danger btn-xs torol" title="Töröl" href="{{$l->createLink($projectid)}}">
                                            <span class="glyphicon glyphicon-trash"></span> Töröl
                                        </a>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </section>


@endsection
