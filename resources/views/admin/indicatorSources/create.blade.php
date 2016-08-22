@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Adicionar Fonte de Indicador</h3>

    <form action="/admin/indicatorSources/store" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}"
                       autofocus required minlength="2" maxlength="45">
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