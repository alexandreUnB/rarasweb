@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Adicionar Sinal</h3>

    <form action="/admin/signs/store" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}"
                       autofocus required minlength="5" maxlength="120">
            </div>

            <div class="form-group col-xs-6">
                <label for="frequency">Frequência</label>
                <select class="form-control" name="frequency" id="frequency" required>
                    <option value="" hidden>Selecione ou digite a frequência</option>
                    @foreach($frequencies as $frequency)
                        <option value="{{$frequency}}" {{$frequency == old('frequency') ?
                        "selected" : ""}}>{{$frequency}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/signs" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection