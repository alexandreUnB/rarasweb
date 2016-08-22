@extends('layouts.main')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$professional->name}} {{$professional->surname}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4">
                    <p>Nome: <strong>{{$professional->name}}</strong></p>
                </div>

                <div class="col-xs-4">
                    <p>Sobrenome: <strong>{{$professional->surname}}</strong></p>
                </div>

                <div class="col-xs-2">
                    <p>Nº Conselho:
                        <strong>{{$professional->council_number ? $professional->council_number : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-2">
                    <p>Ativo:
                        <strong>{{$professional->active ? "Sim" : "Não"}}</strong>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4">
                    <p>Cidade:
                        <strong>
                            @if($professional->city)
                                {{$professional->city}} - {{$professional->uf}}
                            @else
                                N/D
                            @endif
                        </strong>
                    </p>
                </div>

                <div class="col-xs-3">
                    <p>Telefone:
                        <strong>
                            @if($professional->telephone)
                                {{$professional->ddd}} {{$professional->telephone}}
                            @else
                                N/D
                            @endif
                        </strong>
                    </p>
                </div>

                <div class="col-xs-5">
                    <p>Facebook:
                        @if($professional->facebook)
                            <a href="{{$professional->facebook}}" target="_blank">{{$professional->facebook}}</a>
                        @else
                            <strong>N/D</strong>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4">
                    <p>Email:
                        <strong>{{$professional->email ? $professional->email : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-3">
                    <p>Ocupação:
                        <strong>{{$professional->profession ? $professional->profession : "N/D"}}</strong>
                    </p>

                </div>

                <div class="col-xs-5">
                    <p>Twitter:
                        @if($professional->twitter)
                            <a href="{{$professional->twitter}}" target="_blank">{{$professional->twitter}}</a>
                        @else
                            <strong>N/D</strong>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <p>Especialidade(s):
                        <strong>
                            @forelse($specialties as $specialty)
                                {{$specialty->name}} {{$specialty->cbo}}

                                @if($countSpecialties)
                                    <strong>-</strong>
                                    <span class="hide">{{$countSpecialties--}}</span>
                                @endif
                            @empty
                                <span class="alert-warning">Não existe especialidade cadastrada para esse profissional</span>
                            @endforelse
                        </strong>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-striped table-hover">
                        <caption class="text-center text-td">Desordens relacionadas a esse profissional</caption>
                        <thead class="table-geral">
                        <th class="text-center">ID</th>
                        <th class="text-center">Orphanumber</th>
                        <th class="text-center">Desordem</th>
                        <th class="text-center">Detalhes</th>
                        </thead>

                        @foreach($professionalDisorders as $professionalDisorder)
                            <tbody>
                            <td class="text-center table-geral">{{$professionalDisorder->id}}</td>
                            <td class="text-td text-center">{{$professionalDisorder->orphanumber}}</td>
                            <td class="text-td">{{$professionalDisorder->name}}</td>
                            <td class="text-center">
                                <a class="btn btn-default" href="/admin/disorders/show/{{$professionalDisorder->id}}">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                            </td>
                            </tbody>
                        @endforeach
                    </table>
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