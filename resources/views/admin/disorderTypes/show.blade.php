@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$disorderType->name}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-striped table-hover">
                        <caption class="text-center text-td">Desordens associadas a esse tipo</caption>
                        <thead class="table-geral">
                        <th class="text-center">ID</th>
                        <th class="text-center">Orphanumber</th>
                        <th class="text-center">Desordem</th>
                        <th class="text-center">Detalhes</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Deletar</th>
                        </thead>

                        @foreach($disorders as $disorder)
                            <tbody>
                            <td class="text-center table-geral">{{$disorder->id}}</td>
                            <td class="text-td text-center">{{$disorder->orphanumber}}</td>
                            <td class="text-td">{{$disorder->name}}</td>
                            <td class="text-center">
                                <a class="btn btn-default" href="/admin/disorders/show/{{$disorder->id}}">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="/admin/disorders/edit/{{$disorder->id}}">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-danger" href="/admin/disorders/delete/{{$disorder->id}}">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                            </tbody>
                        @endforeach
                    </table>

                    {!! $disorders->links() !!}
                </div>
            </div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="/admin/disordertypes" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection