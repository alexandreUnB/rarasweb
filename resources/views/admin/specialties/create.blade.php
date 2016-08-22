@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Adicionar Especialidade</h3>

    <form action="/admin/specialties/store" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}"
                       autofocus required minlength="5" maxlength="50">
            </div>

            <div class="form-group col-xs-2">
                <label for="cbo">CBO</label>
                <input type="text" name="cbo" class="form-control"
                       value="{{old('cbo')}}" required minlength="7" maxlength="7">
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/specialties" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection