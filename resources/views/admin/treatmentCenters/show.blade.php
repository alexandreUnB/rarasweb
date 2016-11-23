@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$treatmentCenter->name}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-5">
                    <p>Nome: <strong>{{$treatmentCenter->name}}</strong></p>
                </div>

                <div class="col-xs-2">
                    <p>Sigla:
                        <strong>{{$treatmentCenter->abbreviation ? $treatmentCenter->abbreviation : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-4">
                    <p>Endereço:
                        <strong>{{$treatmentCenter->address ? $treatmentCenter->address : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-1">
                    <p>Nº:
                        <strong>{{$treatmentCenter->number ? $treatmentCenter->number : "N/D"}}</strong>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3">
                    <p>Bairro:
                        <strong>{{$treatmentCenter->neighborhood ? $treatmentCenter->neighborhood : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-3">
                    <p>Complemento:
                        <strong>{{$treatmentCenter->complement ? $treatmentCenter->complement : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-2">
                    <p>CEP:
                        <strong>{{$treatmentCenter->cep ? $treatmentCenter->cep : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-3">
                    <p>Cidade:
                        <strong>{{$treatmentCenter->city ? $treatmentCenter->city : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-1">
                    <p>UF:
                        <strong>{{$treatmentCenter->uf ? $treatmentCenter->uf : "N/D"}}</strong>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-2">
                    <p>Caixa Postal:
                        <strong>{{$treatmentCenter->postal_code ? $treatmentCenter->postal_code : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-5">
                    <p>Responsável 1:
                        <strong>{{$treatmentCenter->contact1 ? $treatmentCenter->contact1 : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-5">
                    <p>Responsável 2:
                        <strong>{{$treatmentCenter->contact2 ? $treatmentCenter->contact2 : "N/D"}}</strong>
                    </p>
                </div>
            </div>


            <div class="row">
                <div class="col-xs-1">
                    <p>DDD:
                        <strong>{{$treatmentCenter->ddd ? $treatmentCenter->ddd : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-2">
                    <p>Telefone Principal:
                        <strong>{{$treatmentCenter->phone_number ? $treatmentCenter->phone_number : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-2">
                    <p>Telefone Geral:
                        <strong>{{$treatmentCenter->general_number ? $treatmentCenter->general_number : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-2">
                    <p>Ramal:
                        <strong>{{$treatmentCenter->extension ? $treatmentCenter->extension : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-5">
                    <p>Site:
                        @if($treatmentCenter->site)
                            <a href="{{$treatmentCenter->site}}" target="_blank">{{$treatmentCenter->site}}</a>
                        @else
                            <strong>N/D</strong>
                        @endif
                    </p>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-4">
                    <p>Email:
                        <strong>{{$treatmentCenter->email ? $treatmentCenter->email : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-2">
                    <p>Latitude:
                        <strong>{{$treatmentCenter->latitude ? $treatmentCenter->latitude : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-2">
                    <p>Longitude:
                        <strong>{{$treatmentCenter->longitude ? $treatmentCenter->longitude : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-2">
                    <p>CNES:
                        <strong>{{$treatmentCenter->cnes ? $treatmentCenter->cnes : "N/D"}}</strong>
                    </p>
                </div>

                <div class="col-xs-2">
                    <p>Aberto 24h:
                        <strong>
                            @if($treatmentCenter->open24 == 1)
                                Sim
                            @elseif($treatmentCenter->open24 == 0)
                                Não
                            @else
                                N/D
                            @endif
                        </strong>
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
                                <span class="alert-warning">Não existem especialidades cadastradas para esse centro</span>
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