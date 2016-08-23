@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$indicatorSource->abbreviation}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6">
                    <p>Nome: <strong>{{$indicatorSource->name}}</strong></p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-striped table-hover">
                        <caption class="text-center text-td">Indicadores associados a essa fonte</caption>
                        <thead class="table-geral">
                        <th class="text-center">ID</th>
                        <th class="text-center">Desordem</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Fonte</th>
                        <th class="text-center">Ano</th>
                        <th class="text-center">Detalhes</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Deletar</th>
                        </thead>

                        @foreach($indicators as $indicator)
                            <tbody>
                            <td class="text-center table-geral">{{$indicator->id}}</td>
                            <td class="text-td text-center">{{$indicator->disorder->name}}</td>
                            <td class="text-td text-center">{{$indicator->indicatorType->name}}</td>
                            <td class="text-td text-center">{{$indicator->indicatorSource->abbreviation}}</td>
                            <td class="text-td text-center">{{$indicator->year}}</td>
                            <td class="text-center">
                                <a class="btn btn-default" href="/admin/indicators/show/{{$indicator->id}}">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="/admin/indicators/edit/{{$indicator->id}}">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-danger" href="/admin/indicators/delete/{{$indicator->id}}">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                            </tbody>
                        @endforeach
                    </table>

                    {!! $indicators->appends(Request::input())->links() !!}
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