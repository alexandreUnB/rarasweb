@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Editando Protocolo - <strong>{{$protocol->disorder->name}}</strong></h3>

    <form action="/admin/protocols/update/{{$protocol->id}}" enctype="multipart/form-data" method="post">
        {{csrf_field()}}
        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="document">Portaria</label>
                <input type="text" name="document" class="form-control" value="{{$protocol->document}}"
                       autofocus required minlength="10" maxlength="50">
            </div>

            <div class="form-group col-xs-6">
                <label for="pdf">Documento PDF</label>
                <input type="file" accept="application/pdf" name="pdf" class="form-control">
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/protocols" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection