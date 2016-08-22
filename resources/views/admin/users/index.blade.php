@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Permissões</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary btn-superior" href={!!URL::to('admin/indicatorTypes/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/permissions/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Permissões"
                           name="search" value="{{old('search')}}" autofocus>
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
        <th class="text-center">Permissão</th>
        <th class="text-center">Slug</th>

        <th class="text-center" width="80">Detalhes</th>
        <th class="text-center" width="80">Editar</th>
        <th class="text-center" width="80">Deletar</th>
        </thead>

        @foreach($permissions as $permission)
            <tbody>
            <td class="text-center table-geral">{{$permission->id}}</td>
            <td class="text-center">{{$permission->label}}</td>
            <td class="text-center">{{$permission->name}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/permissions/{{$permission->id}}/roles">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/permissions/edit/{{$permission->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/permissions/delete/{{$permission->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $permissions->appends(Request::input())->links() !!}

@endsection