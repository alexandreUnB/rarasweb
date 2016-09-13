@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Editando Fonte de Indicador - <strong>{{$indicatorSource->name}}</strong></h3>

    <form action="/admin/indicatorSources/update/{{$indicatorSource->id}}" method="post">
        {{csrf_field()}}
        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{$indicatorSource->name}}"
                       autofocus required minlength="2" maxlength="200">
            </div>

            <div class="form-group col-xs-6">
                <label for="abbreviation">Sigla</label>
                <input type="text" name="abbreviation" class="form-control" value="{{$indicatorSource->abbreviation}}"
                       required minlength="2" maxlength="20">
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/indicatorSources" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection