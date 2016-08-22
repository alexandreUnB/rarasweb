@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Editando Especialidade - <strong>{{$specialty->name}} - {{$specialty->cbo}}</strong></h3>

    <form action="/admin/specialties/update/{{$specialty->id}}" method="post">
        {{csrf_field()}}
        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{$specialty->name}}"
                       autofocus required minlength="5" maxlength="50">
            </div>

            <div class="form-group col-xs-2">
                <label for="cbo">CBO</label>
                <input type="text" name="cbo" class="form-control"
                       value="{{$specialty->cbo}}" required minlength="7" maxlength="7">
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