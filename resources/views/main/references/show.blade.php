@extends('layouts.main')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$reference->source}} - {{$reference->reference}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-2">
                    <p>Fonte: <strong>{{$reference->source}}</strong></p>
                </div>

                <div class="col-xs-3">
                    <p>Referência: <strong>{{$reference->reference}}</strong></p>
                </div>

                <div class="col-xs-7">
                    <p>Map Relation: <strong>{{$reference->map_relation}}</strong></p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-striped table-hover">
                        <caption class="text-center text-td">Desordens relacionadas a essa referência</caption>
                        <thead class="table-geral">
                        <th class="text-center">ID</th>
                        <th class="text-center">Orphanumber</th>
                        <th class="text-center">Desordem</th>
                        <th class="text-center">Detalhes</th>
                        </thead>

                        @foreach($referenceDisorders as $referenceDisorder)
                            <tbody>
                            <td class="text-center table-geral">{{$referenceDisorder->id}}</td>
                            <td class="text-td text-center">{{$referenceDisorder->orphanumber}}</td>
                            <td class="text-td text-center">{{$referenceDisorder->name}}</td>
                            <td class="text-center">
                                <a class="btn btn-default" href="/admin/disorders/show/{{$referenceDisorder->id}}">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                            </td>
                            </tbody>
                        @endforeach
                    </table>

                    {!! $referenceDisorders->links() !!}
                </div>
            </div>
        </div>
    </div>

    <div id="actions" class="row text-right">
        <div class="col-xs-12">
            <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection