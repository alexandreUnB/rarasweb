@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Leis</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary btn-superior" href={!!URL::to('admin/laws/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/laws/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nome da Lei"
                           name="searchedLaw" value="{{old('searchedLaw')}}" autofocus>
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
        <th class="text-center">Nome</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($laws as $law)
            <tbody>
            <td class="text-center table-geral">{{$law->id}}</td>
            <td class="text-td text-center">{{$law->name_law}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/laws/show/{{$law->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/laws/edit/{{$law->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/laws/delete/{{$law->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $laws->appends(Request::input())->links() !!}

@endsection