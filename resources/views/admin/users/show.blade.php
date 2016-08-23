@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$user->name}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4">
                    <p>Nome Completo: <strong>{{$user->name}} {{$user->surname}}</strong></p>
                </div>

                <div class="col-xs-4">
                    <p>E-mail: <strong>{{$user->email}}</strong></p>
                </div>

                <div class="col-xs-4">
                    <p>Papéis:</p>
                    @forelse($user->roles as $role)
                        <p><strong>{{$role->label}}</strong></p>
                    @empty
                        <p><strong>Nenhum papel associado a este usuário</strong></p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="/admin/users" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection