@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Usuários</h3>

    <div class="row">
        {{--<div class="col-xs-8">--}}
            {{--<a class="btn btn-primary btn-superior" href={!!URL::to('admin/indicatorTypes/create')!!}>--}}
                {{--<i class="glyphicon glyphicon-plus"> Novo</i>--}}
            {{--</a>--}}
        {{--</div>--}}

        <div class="col-xs-4 col-xs-offset-8 text-right">
            <form role="search" action="/admin/users/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Usuário"
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
            <th class="text-center" width="40">ID</th>
            <th class="text-center">Nome</th>
            <th class="text-center">Sobrenome</th>
            <th class="text-center">Email</th>

            <th class="text-center" width="80">Detalhes</th>
            <th class="text-center" width="80">Editar</th>
            <th class="text-center" width="80">Deletar</th>
        </thead>

        @foreach($users as $user)
            <tbody>
            <td class="text-center table-geral">{{$user->id}}</td>
            <td class="text-center">{{$user->name}}</td>
            <td class="text-center">{{$user->surname}}</td>
            <td class="text-center">{{$user->email}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/users/{{$user->id}}/roles">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/users/edit/{{$user->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/users/delete/{{$user->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $users->appends(Request::input())->links() !!}

@endsection