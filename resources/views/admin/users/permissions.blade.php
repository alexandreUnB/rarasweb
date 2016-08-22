@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Papeis da Permissão: {{$permission->label}}</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary btn-superior" href={!!URL::to('admin/indicatorTypes/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center" width="20">ID</th>
        <th class="text-center">Nome</th>
        <th class="text-center">Slug</th>

        <th class="text-center" width="80">Detalhes</th>
        <th class="text-center" width="80">Editar</th>
        <th class="text-center" width="80">Deletar</th>
        </thead>

        @forelse($permissions as $permission)
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
        @empty
            <td colspan="90"><strong>Nenhuma permissão encontrada para este papel</strong></td>
        @endforelse
    </table>

@endsection