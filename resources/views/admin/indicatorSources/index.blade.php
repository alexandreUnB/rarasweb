@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Fontes de Indicador</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary btn-superior" href={!!URL::to('admin/indicatorSources/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/indicatorSources/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Fonte de Indicador"
                           name="searchedIndicatorSource" value="{{old('searchedIndicatorSource')}}" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Fonte de Indicador</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($indicatorSources as $indicatorSource)
            <tbody>
            <td class="text-center table-geral">{{$indicatorSource->id}}</td>
            <td class="text-td">{{$indicatorSource->name}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/indicatorSources/show/{{$indicatorSource->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/indicatorSources/edit/{{$indicatorSource->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/indicatorSources/delete/{{$indicatorSource->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $indicatorSources->appends(Request::input())->links() !!}

@endsection