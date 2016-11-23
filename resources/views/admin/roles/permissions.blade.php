@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Permissões relacionadas ao Papel de: {{$role->display_name}}</h3>


    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center" width="20">ID</th>
        <th class="text-center">Nome</th>
        <th class="text-center">Slug</th>

        {{--<th class="text-center" width="80">Detalhes</th>--}}
        {{--<th class="text-center" width="80">Editar</th>--}}
        {{--<th class="text-center" width="80">Deletar</th>--}}
        </thead>

        @forelse($permissions as $permission)
            <tbody>
            <td class="text-center table-geral">{{$permission->id}}</td>
            <td class="text-center">{{$permission->display_name}}</td>
            <td class="text-center">{{$permission->name}}</td>
            {{--<td class="text-center">--}}
                {{--<a class="btn btn-default" href="/admin/users/{{$permission->id}}/roles">--}}
                    {{--<i class="glyphicon glyphicon-eye-open"></i>--}}
                {{--</a>--}}
            {{--</td>--}}
            {{--<td class="text-center">--}}
                {{--<a class="btn btn-primary" href="/admin/permissions/edit/{{$permission->id}}">--}}
                    {{--<i class="glyphicon glyphicon-pencil"></i>--}}
                {{--</a>--}}
            {{--</td>--}}
            {{--<td class="text-center">--}}
                {{--<a class="btn btn-danger" href="/admin/permissions/delete/{{$permission->id}}">--}}
                    {{--<i class="glyphicon glyphicon-trash"></i>--}}
                {{--</a>--}}
            {{--</td>--}}
            </tbody>
        @empty
            <td colspan="90"><strong>Nenhuma permissão encontrada para este papel</strong></td>
        @endforelse
    </table>
    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="/admin/roles" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection