@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Adicionar Lei</h3>

    <form action="/admin/laws/store" enctype="multipart/form-data" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="name_law">Nome</label>
                <input type="text" name="name_law" class="form-control" value="{{old('name_law')}}"
                       autofocus required minlength="10" maxlength="50">
            </div>

            <div class="form-group col-xs-6">
                <label for="pdf">Documento PDF</label>
                <input type="file" accept="application/pdf" name="pdf" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-12">
                <label for="resume">Resumo</label>
                <textarea class="form-control vresize" rows="5" id="resume" name="resume"
                          minlength="10" maxlength="5000">{{old('resume')}}</textarea>
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