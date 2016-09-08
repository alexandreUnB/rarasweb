@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Editando Tipo de Desordem - <strong>{{$disorderType->name}}</strong></h3>

    <form action="/admin/disordertypes/update/{{$disorderType->id}}" method="post">
        {{csrf_field()}}
        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{$disorderType->name}}"
                       autofocus required minlength="5" maxlength="100">
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/disordertypes" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection