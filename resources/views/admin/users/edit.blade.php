@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Editando Tipo de Indicador - <strong>{{$user->name}}</strong></h3>

    <form action="/admin/users/update/{{$user->id}}" method="post">
        {{csrf_field()}}
        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-3">
                <label for="name">Nome</label>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Nome">
            </div>


            <div class="form-group col-xs-3">
                <label for="surname">Sobrenome</label>
                <input type="text" class="form-control" name="surname" value="{{ $user->surname }}"
                       placeholder="Sobrenome">

            </div>

            <div class="form-group col-xs-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="E-Mail">
            </div>

            <div class="form-group col-xs-3">
                <label for="roleUsers">Papeis do usuário</label>
                <div class="panel panel-default panel-body fixed-panel">
                    @foreach($roles as $role)
                        {{$checked = ""}}

                        @forelse($user->roles as $userRole)
                            @if($role->id == $userRole->id)
                                <span class="hide">{{$checked = "checked"}}</span>
                                @break
                            @endif
                        @empty
                        @endforelse

                        <input type="checkbox" name="roleUsers[]" value="{{$role->id}}" {{$checked}}>
                        {{$role->display_name}}<br>
                    @endforeach
                </div>
            </div>
        </div>

        <hr/>

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/users" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection