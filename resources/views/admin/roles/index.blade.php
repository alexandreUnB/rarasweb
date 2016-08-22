@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Papeis</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary btn-superior" href={!!URL::to('admin/roles/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/roles/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Papeis"
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
        <th class="text-center" width="10">ID</th>
        <th class="text-center">Papel</th>
        <th class="text-center">Slug</th>

        <th class="text-center" width="80">Permissões</th>
        <th class="text-center" width="80">Editar</th>
        <th class="text-center" width="80">Deletar</th>
        </thead>

        @foreach($roles as $role)
            <tbody>
            <td class="text-center table-geral">{{$role->id}}</td>
            <td class="text-center">{{$role->label}}</td>
            <td class="text-center">{{$role->name}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/roles/{{$role->id}}/permissions">
                    <i class="material-icons small-icon">security</i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/roles/edit/{{$role->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            @if($role->name == 'adm')
                <td class="text-center">
                    <a class="btn btn-danger" href="">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                </td>
            @else
                <td class="text-center">
                    <a class="btn btn-danger" href="/admin/roles/delete/{{$role->id}}">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                </td>
            @endif
            </tbody>
        @endforeach
    </table>
    {!! $roles->appends(Request::input())->links() !!}


@endsection