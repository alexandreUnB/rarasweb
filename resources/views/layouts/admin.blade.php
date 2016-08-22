<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link media="all" type="text/css" rel="stylesheet" href="{{public_path('assets\css\bootstrap.mim.css')}}">
    {!!Html::style('assets/css/bootstrap.min.css')!!}
    {!!Html::style('assets/css/estilo.css')!!}
    {!!Html::style('assets/css/font-awesome.min.css')!!}
    {!!Html::style('assets/css/metisMenu.min.css')!!}
    {!!Html::style('assets/css/sb-admin-2.css')!!}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top navbar-bottom" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <i class="icon-bar"></i>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">RarasWeb</a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                </ul>
            </li>

        </ul>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    @can('adm')
                        <li>
                            <a href="#"><i class="material-icons small-icon">lock</i> Administração<span
                                        class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href={!!URL::to('/admin/permissions')!!}><i class="material-icons small-icon">security</i>
                                        Permissões</a>
                                </li>
                                <li>
                                    <a href={!!URL::to('/admin/roles')!!}><i
                                                class="material-icons small-icon">vpn_key</i> Papéis</a>
                                </li>
                                <li>
                                    <a href={!!URL::to('/admin/users')!!}><i class="fa fa-users fa-fw"></i> Usuários</a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    <li>
                        <a href="#"><i class="fa fa-heartbeat"></i> Desordens<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href={!!URL::to('admin/disorders/create')!!}><i class='fa fa-plus fa-fw'></i>
                                    Adicionar</a>
                            </li>
                            <li>
                                <a href={!!URL::to('admin/disorders')!!}><i class='fa fa-list-ol fa-fw'></i>
                                    Desordens</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="material-icons small-icon">loyalty</i> Tipos de Desordem<span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/disordertypes/create')!!}"><i class='fa fa-plus fa-fw'></i>
                                    Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/disordertypes')!!}"><i class='fa fa-list-ol fa-fw'></i> Tipos
                                    de Desordem</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-file-pdf-o"></i> Protocolos<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/protocols/create')!!}"><i class='fa fa-plus fa-fw'></i>
                                    Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/protocols')!!}"><i class='fa fa-list-ol fa-fw'></i>
                                    Protocolos</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-balance-scale"></i> Leis<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/laws/create')!!}"><i class='fa fa-plus fa-fw'></i> Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/laws')!!}"><i class='fa fa-list-ol fa-fw'></i> Leis</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-clone"></i> Sinônimos<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/synonyms/create')!!}"><i class='fa fa-plus fa-fw'></i>
                                    Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/synonyms')!!}"><i class='fa fa-list-ol fa-fw'></i> Sinônimos</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-graduation-cap  "></i> Especialidades<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/specialties/create')!!}"><i class='fa fa-plus fa-fw'></i>
                                    Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/specialties')!!}"><i class='fa fa-list-ol fa-fw'></i>
                                    Especialidades</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-stethoscope"></i> Sinais<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/signs/create')!!}"><i class='fa fa-plus fa-fw'></i> Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/signs')!!}"><i class='fa fa-list-ol fa-fw'></i> Sinais</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-database"></i> Referências<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/references/create')!!}"><i class='fa fa-plus fa-fw'></i>
                                    Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/references')!!}"><i class='fa fa-list-ol fa-fw'></i>
                                    Referências</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-tags"></i> Tipos de Indicadores<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/indicatorTypes/create')!!}"><i class='fa fa-plus fa-fw'></i>
                                    Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/indicatorTypes')!!}"><i class='fa fa-list-ol fa-fw'></i>
                                    Tipos de Indicadores</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-university"></i> Fontes de Indicadores<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/indicatorSources/create')!!}"><i
                                            class='fa fa-plus fa-fw'></i> Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/indicatorSources')!!}"><i class='fa fa-list-ol fa-fw'></i>
                                    Fontes de Indicadores</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-bar-chart"></i> Indicadores<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/indicators/create')!!}"><i class='fa fa-plus fa-fw'></i>
                                    Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/indicators')!!}"><i class='fa fa-list-ol fa-fw'></i>
                                    Indicadores</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-user-md"></i> Profissionais<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/professionals/create')!!}"><i class='fa fa-plus fa-fw'></i>
                                    Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/professionals')!!}"><i class='fa fa-list-ol fa-fw'></i>
                                    Profissionais</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-hospital-o"></i> Centros de Tratamento<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!!URL::to('admin/treatmentCenters/create')!!}"><i
                                            class='fa fa-plus fa-fw'></i> Adicionar</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('admin/treatmentCenters')!!}"><i class='fa fa-list-ol fa-fw'></i>
                                    Centros de Tratamento</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
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