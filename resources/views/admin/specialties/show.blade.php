@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$specialty->name}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-8">
                    <p>Especialidade: <strong>{{$specialty->name}}</strong></p>
                </div>

                <div class="col-xs-4">
                    <p>CBO: <strong>{{$specialty->cbo}}</strong></p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-striped table-hover">
                        <caption class="text-center text-td">Desordens associadas a essa especialidade</caption>
                        <thead class="table-geral">
                        <th class="text-center">ID</th>
                        <th class="text-center">Orphanumber</th>
                        <th class="text-center">Desordem</th>
                        <th class="text-center">Detalhes</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Deletar</th>
                        </thead>

                        @foreach($specialtyDisorders as $specialtyDisorder)
                            <tbody>
                            <td class="text-center table-geral">{{$specialtyDisorder->id}}</td>
                            <td class="text-td text-center">{{$specialtyDisorder->orphanumber}}</td>
                            <td class="text-td">{{$specialtyDisorder->name}}</td>
                            <td class="text-center">
                                <a class="btn btn-default" href="/admin/disorders/show/{{$specialtyDisorder->id}}">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="/admin/disorders/edit/{{$specialtyDisorder->id}}">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-danger" href="/admin/disorders/delete/{{$specialtyDisorder->id}}">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                            </tbody>
                        @endforeach
                    </table>

                    {!! $specialtyDisorders->links() !!}
                </div>
            </div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="/admin/specialties" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection