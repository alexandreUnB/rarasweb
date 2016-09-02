@extends('layouts.admin')

@section('content')

    {{--@include('layouts.alerts')--}}

    <h3 class="page-header">Adicionar Referência</h3>

    <form action="/admin/references/store" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="source">Fonte</label>
                <select class="form-control" name="source" id="source" required>
                    <option value="" hidden>Selecione ou digite a fonte</option>
                    @foreach($sources as $source)
                        <option value="{{$source}}" {{$source == old('source') ?
                        "selected" : ""}}>{{$source}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-xs-6">
                <label for="reference">Referência</label>
                <input type="text" name="reference" class="form-control"
                       value="{{old('reference')}}" required minlength="2" maxlength="10">
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/references" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection