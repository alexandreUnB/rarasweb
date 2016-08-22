@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$sign->name}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-8">
                    <p>Nome: <strong>{{$sign->name}}</strong></p>
                </div>

                <div class="col-xs-4">
                    <p>Frequência: <strong>{{$sign->frequency}}</strong></p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-striped table-hover">
                        <caption class="text-center text-td">Desordens associadas a esse sinal</caption>
                        <thead class="table-geral">
                        <th class="text-center">ID</th>
                        <th class="text-center">Orphanumber</th>
                        <th class="text-center">Desordem</th>
                        <th class="text-center">Detalhes</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Deletar</th>
                        </thead>

                        @foreach($signDisorders as $signDisorder)
                            <tbody>
                            <td class="text-center table-geral">{{$signDisorder->id}}</td>
                            <td class="text-td text-center">{{$signDisorder->orphanumber}}</td>
                            <td class="text-td">{{$signDisorder->name}}</td>
                            <td class="text-center">
                                <a class="btn btn-default" href="/admin/disorders/show/{{$signDisorder->id}}">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="/admin/disorders/edit/{{$signDisorder->id}}">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-danger" href="/admin/disorders/delete/{{$signDisorder->id}}">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                            </tbody>
                        @endforeach
                    </table>

                    {!! $signDisorders->links() !!}
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