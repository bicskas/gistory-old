@extends('layout.default')

@section('content')
    <section id="nodes">
        <div class="container">
            <a href="/project" class="btn-info btn btn-xs">
                <span class="glyphicon glyphicon-arrow-left"></span> Vissza a projecthez
            </a>
            @include('elemek.network.node')
        </div>
    </section>
@endsection