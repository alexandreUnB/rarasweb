@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Papeis que contém a Permissão: {{$permission->label}}</h3>

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

        {{--<th class="text-center" width="80">Detalhes</th>--}}
        {{--<th class="text-center" width="80">Editar</th>--}}
        {{--<th class="text-center" width="80">Deletar</th>--}}
        </thead>

        @forelse($roles as $role)
            <tbody>
            <td class="text-center table-geral">{{$role->id}}</td>
            <td class="text-center">{{$role->label}}</td>
            <td class="text-center">{{$role->name}}</td>
            {{--<td class="text-center">--}}
                {{--<a class="btn btn-default" href="/admin/users/{{$role->id}}/roles">--}}
                    {{--<i class="glyphicon glyphicon-eye-open"></i>--}}
                {{--</a>--}}
            {{--</td>--}}
            {{--<td class="text-center">--}}
                {{--<a class="btn btn-primary" href="/admin/permissions/edit/{{$role->id}}">--}}
                    {{--<i class="glyphicon glyphicon-pencil"></i>--}}
                {{--</a>--}}
            {{--</td>--}}
            {{--<td class="text-center">--}}
                {{--<a class="btn btn-danger" href="/admin/permissions/delete/{{$role->id}}">--}}
                    {{--<i class="glyphicon glyphicon-trash"></i>--}}
                {{--</a>--}}
            {{--</td>--}}
            </tbody>
        @empty
            <td colspan="90"><strong>Nenhum papel encontrado para esta regra</strong></td>
        @endforelse
    </table>
    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="/admin/permissions" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection