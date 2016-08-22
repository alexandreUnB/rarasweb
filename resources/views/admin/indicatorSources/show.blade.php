@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$indicatorSource->name}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6">
                    <p>Nome: <strong>{{$indicatorSource->name}}</strong></p>
                </div>

                <div class="col-xs-6">
                    <p>Sigla: <strong>{{$indicatorSource->abbreviation}}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="/admin/indicatorSources" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection