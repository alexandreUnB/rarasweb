@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$indicator->disorder->name}} - {{$indicator->indicatorType->name}}
                    {{$indicator->indicatorSource->name}} {{$indicator->year}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6">
                    <p>Doença: <strong>{{$indicator->disorder->name}}</strong></p>
                </div>

                <div class="col-xs-6">
                    <p>Tipo: <strong>{{$indicator->indicatorType->name}}</strong></p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <p>Fonte: <strong>{{$indicator->indicatorSource->name}}</strong></p>
                </div>

                <div class="col-xs-3">
                    <p>Ano: <strong>{{$indicator->year}}</strong></p>
                </div>

                <div class="col-xs-3">
                    <p>Quantidade: <strong>{{$indicator->amount}}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection