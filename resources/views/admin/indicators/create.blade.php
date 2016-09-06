@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Adicionar Indicador</h3>

    <form action="/admin/indicators/store" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="disorder_id">Desordem</label>
                <select class="form-control" name="disorder_id" id="disorder_id" required>
                    <option value="" hidden>Selecione ou digite o nome da desordem</option>
                    @foreach($disorders as $disorder)
                        <option value="{{$disorder->id}}" {{$disorder->id ==old('disorder_id') ?
                                        "selected" : ""}}>{{$disorder->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-xs-6">
                <label for="indicatorType_id">Tipo</label>
                <select class="form-control" name="indicatorType_id" id="indicatorType_id" autofocus required>
                    <option value="" hidden>Selecione ou digite o tipo do indicador</option>
                    @foreach($indicatorTypes as $indicatorType)
                        <option value="{{$indicatorType->id}}" {{$indicatorType->id == old('indicatorType_id') ?
                        "selected" : ""}}>{{$indicatorType->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="indicatorSource_id">Fonte</label>
                <select class="form-control" name="indicatorSource_id" id="indicatorSource_id" required>
                    <option value="" hidden>Selecione ou digite a fonte do indicador</option>
                @foreach($indicatorSources as $indicatorSource)
                        <option value="{{$indicatorSource->id}}" {{$indicatorSource->id == old('indicatorSource_id') ?
                        "selected" : ""}}>{{$indicatorSource->abbreviation}} - {{$indicatorSource->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-xs-3">
                <label for="year">Ano</label>
                <input type="number" name="year" class="form-control"
                       value="{{old('year')}}" placeholder="aaaa" required size="4" min="1990" max="2016">
            </div>

            <div class="form-group col-xs-3">
                <label for="amount">Quantidade</label>
                <input type="number" name="amount" class="form-control"
                       value="{{old('amount')}}" required min="1" max="1000000000">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-12">
                <label for="reference">Referência</label>
                <textarea class="form-control vresize" rows="5" id="reference" name="reference"
                          required maxlength="1000">{{old('reference')}}</textarea>
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/indicators" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection