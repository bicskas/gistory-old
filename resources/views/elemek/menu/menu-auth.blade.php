<ul class="nav navbar-nav">
    <li><a href="/project">Projektek</a></li>
    <li><a href="/team">Csoportok</a></li>
</ul>

<ul class="nav navbar-nav navbar-right">
        <ul class="nav navbar-nav navbar-right">
            <li class="navbar-text">Belépve: <strong>{!! Auth::user()->name !!}</strong></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/auth/logout"><span class="glyphicon glyphicon-log-out"></span> Kilépés</a></li>
                </ul>
            </li>
        </ul>
</ul>