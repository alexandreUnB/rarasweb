@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Sinais</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary" href={!!URL::to('admin/signs/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>

            <div><span class="small">{{$signs->total()}} sinais</span></div>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/signs/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nome do Sinal"
                           name="searchedSign" value="{{old('searchedSign')}}" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Nome do Sinal</th>
        <th class="text-center">Frequência</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($signs as $sign)
            <tbody>
            <td class="text-center table-geral">{{$sign->id}}</td>
            <td class="text-td">{{$sign->name}}</td>
            <td class="text-td text-center">{{$sign->frequency}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/signs/show/{{$sign->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/signs/edit/{{$sign->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/signs/delete/{{$sign->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $signs->appends(Request::input())->links() !!}

@endsection