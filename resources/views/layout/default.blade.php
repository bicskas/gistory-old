<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="utf-8">
    {!! Html::style(elixir('css/app.css')) !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="description" content="{{isset($seo_desc) ? $seo_desc : ''}}@yield('desc')">
    <meta name="keywords" content="{{isset($seo_key) ? $seo_key : ''}}@yield('keywords')">
    <meta property="og:description" name="og:description"
          content="{{isset($og_desc) ? $og_desc : ''}}@yield('og_desc')">
    <meta property="og:title" name="og:title" content="{{isset($og_title) ? $og_title : ''}}@yield('og_title')">
    <meta property="og:image" name="og:image" content="{{isset($og_image) ? $og_image : ''}}@yield('og_image')">
    <title>{{isset($title) ? $title.' - ' : null}}Gistory</title>
    <link rel="shortcut icon" type="image/png" href="">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<header>
    <nav class="navbar navbar-inverse" id="menu">
        <div class="container">


            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url("/") }}">Gistory</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="/project">Projektek</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::user())
                        <ul class="nav navbar-nav navbar-right">
                            <li class="navbar-text">Belépve: <strong>{!! Auth::user()->name !!}</strong></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/admin/auth/logout"><span class="glyphicon glyphicon-log-out"></span> Kilépés</a></li>
                                </ul>
                            </li>
                        </ul>
                    @endif
                </ul>

            </div>
        </div>
    </nav>
</header>

@include('elemek.uzenet.errors')
@include('elemek.uzenet.warning')
@include('elemek.uzenet.uzenet')

@yield('content')

<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <p>{!! date('Y') !!} Kriszbacher Gergő</p>
            </div>
            <div class="col-sm-6 text-right">
                {!! HTML::mailto('kriszbacherg@gmail.com','Küldjön e-mailt',['class' => '']) !!}
            </div>
        </div>
    </div>
</footer>


<script src="//d3js.org/d3.v3.min.js"></script>
<script src="https://d3js.org/d3.v4.min.js"></script>
{!! HTML::script(elixir('js/vendor.js')) !!}
{!! HTML::script(elixir('js/app.js')) !!}
</body>
</html>
