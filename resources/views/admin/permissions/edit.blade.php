@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Editando Permissão</h3>

    <form action="/admin/permissions/update/{{$permission->id}}" method="post">

        {{csrf_field()}}

        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="label">Descrição da Permissão</label>
                <input type="text" name="label" class="form-control" value="{{$permission->label}}"
                       autofocus required minlength="5" maxlength="45">
            </div>

            <div class="form-group col-xs-6">
                <label for="name">Slug da Permissão</label>
                <input type="text" name="name" class="form-control" value="{{$permission->name}}"
                       required minlength="5" maxlength="45">
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/permissions" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection