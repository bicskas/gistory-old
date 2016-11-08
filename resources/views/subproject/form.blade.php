@extends('layout.default')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left">{{trans_choice('admin.' . $aktiv_oldal, 1)}} szerkesztése</h3>
                <div class="pull-right">
                    <a href="/project/{!! $projectid !!}/subproject" class="btn-info btn btn-xs">
                        <span class="glyphicon glyphicon-arrow-left"></span> Vissza
                    </a>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::model($model, array('url' => $model->createLink($projectid), 'method' => $method, 'files' => true)) !!}
                {!! Form::hidden('_class_name', get_class($model)) !!}

                <?php $id = 'nev' ?>
                {!! Form::bsText($id, $model, ['required']) !!}

                <?php $id = 'leiras' ?>
                {!! Form::bsText($id, $model, []) !!}
                <hr>

                {!! Form::mentes() !!}

                {!! Form::close() !!}
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>
@endsection