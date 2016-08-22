@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Adicionar Sinônimo</h3>

    <form action="/admin/synonyms/store" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}"
                       autofocus required minlength="2" maxlength="150">
            </div>

            <div class="form-group col-xs-6">
                <label for="disorder_id">Doença</label>
                <select class="form-control" name="disorder_id" id="disorder_id" required>
                    <option value="" hidden>Selecione ou digite a desordem</option>
                    @foreach($disorders as $disorder)
                        <option value="{{$disorder->id}}" {{$disorder->id ==
                        old('disorder_id') ? "selected" : ""}}>{{$disorder->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/synonyms" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection