@extends('layout.default')

@section('content')
    <section id="network">
        <div class="container">
            <article id="edges-form">
                {!! Form::open() !!}



                {!! Form::submit() !!}
                {!! Form::close() !!}
            </article>


            <hr style="border-color: #bbb">
            <article id="letezok">
                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#node" aria-controls="home" role="tab"
                                                                  data-toggle="tab">Csúcsok</a></li>
                        <li role="presentation"><a href="#edge" aria-controls="profile" role="tab" data-toggle="tab">Élek</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="node">
                            @include('elemek.network.node')
                        </div>
                        <div role="tabpanel" class="tab-pane" id="edge">Edges</div>
                    </div>

                </div>
        </article>
        </div>
    </section>




@endsection