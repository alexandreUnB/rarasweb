<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    {!!Html::style('assets/css/bootstrap.min.css')!!}
    {!!Html::style('assets/css/estilo.css')!!}
    {!!Html::style('assets/css/font-awesome.min.css')!!}
    {!!Html::style('assets/css/metisMenu.min.css')!!}
    {!!Html::style('assets/css/sb-admin-2.css')!!}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
<div class="container">

    <nav class="navbar navbar-default navbar-static-top navbar-bottom" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <i class="icon-bar"></i>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            @role(['admin','tec'])
            <a class="navbar-brand" href="/admin">Painel de Controle</a>
            @endrole

            @role(['med','user'])
            <a class="navbar-brand" href="">RarasWeb</a>
            @endrole

        </div>

        <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/register') }}">Criar Conta</a></li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

    <div>
        @include('layouts.alerts')
        @yield('content')
    </div>


</div>


{!!Html::script('assets/js/jquery-2.2.3.min.js')!!}
{!!Html::script('assets/js/bootstrap.min.js')!!}
{!!Html::script('assets/js/metisMenu.min.js')!!}
{!!Html::script('assets/js/sb-admin-2.js')!!}

@section('scripts')

@show
</body>
</html>