@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Editando Lei - <strong>{{$law->name_law}}</strong></h3>

    <form action="/admin/laws/update/{{$law->id}}" enctype="multipart/form-data" method="post">
        {{csrf_field()}}
        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="name_law">Nome</label>
                <input type="text" name="name_law" class="form-control" value="{{$law->name_law}}"
                       autofocus required minlength="10" maxlength="50">
            </div>

            <div class="form-group col-xs-5">
                <label for="pdf">Documento PDF</label>
                <input type="file" accept="application/pdf" name="pdf" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-12">
                <label for="resume">Resumo</label>
                <textarea class="form-control vresize" rows="5" id="resume" name="resume"
                          minlength="10" maxlength="5000">{{$law->resume}}</textarea>
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/laws" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection