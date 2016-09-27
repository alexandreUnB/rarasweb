@extends('layouts.admin')

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
                        <strong>
                            @if($professional->council_number)
                                {{$professional->council_number}}
                            @else
                                <span class="alert-warning">N/D</span>
                            @endif
                        </strong>
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
                                <span class="alert-warning">N/D</span>
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
                                <span class="alert-warning">N/D</span>
                            @endif
                        </strong>
                    </p>
                </div>

                <div class="col-xs-5">
                    <p>Facebook:
                        @if($professional->facebook)
                            <a href="{{$professional->facebook}}" target="_blank">{{$professional->facebook}}</a>
                        @else
                            <span class="alert-warning"><strong>N/D</strong></span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4">
                    <p>Email:
                        <strong>
                            @if($professional->email)
                                {{$professional->email}}
                            @else
                                <span class="alert-warning">N/D</span>
                            @endif
                        </strong>
                    </p>
                </div>

                <div class="col-xs-3">
                    <p>Ocupação:
                        <strong>
                            @if($professional->profession)
                                {{$professional->profession}}
                            @else
                                <span class="alert-warning">N/D</span>
                            @endif
                        </strong>
                    </p>

                </div>

                <div class="col-xs-5">
                    <p>Twitter:
                        @if($professional->twitter)
                            <a href="{{$professional->twitter}}" target="_blank">{{$professional->twitter}}</a>
                        @else
                            <span class="alert-warning text-bd"><strong>N/D</strong></span>
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
                                <span class="alert-warning">Não existem especialidades cadastradas para esse profissional</span>
                            @endforelse
                        </strong>
                    </p>
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