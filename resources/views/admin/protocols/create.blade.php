@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Adicionar Protocolo</h3>

    <form action="/admin/protocols/store" enctype="multipart/form-data" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="document">Portaria</label>
                <input type="text" name="document" class="form-control" value="{{old('document')}}"
                       autofocus required minlength="10" maxlength="50">
            </div>

            <div class="form-group col-xs-6">
                <label for="disorder_id">Desordem</label>
                <select class="form-control" name="disorder_id" id="disorder_id" required>
                    <option value="" hidden>Selecione ou digite o nome da desordem</option>
                    @foreach($disorders as $disorder)
                        <option value="{{$disorder->id}}" {{$disorder->id == old('disorder_id') ? "selected" : ""}}>
                            {{$disorder->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-push-3 col-xs-6">
                <label for="pdf">Documento PDF</label>
                <input type="file" accept="application/pdf" name="pdf" class="form-control" required>
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