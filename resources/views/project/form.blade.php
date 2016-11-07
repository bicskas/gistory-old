@extends('layout.default')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left">{{trans_choice('admin.' . $aktiv_oldal, 1)}} szerkesztése</h3>
                <div class="pull-right">
                    <a href="/{{$aktiv_oldal}}" class="btn-info btn btn-xs">
                        <span class="glyphicon glyphicon-arrow-left"></span> Vissza
                    </a>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::model($model, array('url' => $model->createLink(), 'method' => $method, 'files' => true)) !!}
                {!! Form::hidden('_class_name', get_class($model)) !!}

                <?php $id = 'cim' ?>
                {!! Form::bsText($id, $model, ['required']) !!}

                <?php $id = 'leiras' ?>
                {!! Form::bsText($id, $model, []) !!}

                <?php $id = 'szoveg' ?>
                {!! Form::bsTextarea($id, $model, ['class' => 'form-control ckeditor']) !!}

                <?php $id = 'teams' ?>
                {!! Form::bsSelect($id, $model, $teams, ['class' => 'form-control bs-select', 'multiple']) !!}

                <hr>

                {!! Form::mentes() !!}

                {!! Form::close() !!}
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>
@endsection