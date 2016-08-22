@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Editando Centro de Tratamento - <strong>{{$treatmentCenter->name}}</strong></h3>

    <form action="/admin/treatmentCenters/update/{{$treatmentCenter->id}}" method="post">
        {{csrf_field()}}
        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-5">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{$treatmentCenter->name}}"
                       autofocus required minlength="8" maxlength="200">
            </div>

            <div class="form-group col-xs-2">
                <label for="abbreviation">Sigla</label>
                <input type="text" name="abbreviation" class="form-control"
                       value="{{$treatmentCenter->abbreviation}}" minlength="2" maxlength="20">
            </div>

            <div class="form-group col-xs-4">
                <label for="address">Endereço</label>
                <input type="text" name="address" class="form-control"
                       value="{{$treatmentCenter->address}}" required minlength="5" maxlength="100">
            </div>

            <div class="form-group col-xs-1">
                <label for="number">Número</label>
                <input type="number" name="number" class="form-control"
                       value="{{$treatmentCenter->number}}" min="1" max="99999">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-3">
                <label for="neighborhood">Bairro</label>
                <input type="text" name="neighborhood" class="form-control"
                       value="{{$treatmentCenter->neighborhood}}" minlength="3" maxlength="30">
            </div>

            <div class="form-group col-xs-3">
                <label for="complement">Complemento</label>
                <input type="text" name="complement" class="form-control"
                       value="{{$treatmentCenter->complement}}" minlength="2" maxlength="60">
            </div>

            <div class="form-group col-xs-2">
                <label for="cep">CEP</label>
                <input type="number" name="cep" class="form-control" value="{{$treatmentCenter->cep}}" required size="8">
            </div>
            <div class="form-group col-xs-3">
                <label for="city">Cidade</label>
                <input type="text" name="city" class="form-control"
                       value="{{$treatmentCenter->neighborhood}}" required minlength="3" maxlength="45">
            </div>

            <div class="form-group col-xs-1">
                <label for="uf">UF</label>
                <input type="text" name="uf" class="form-control"
                       value="{{$treatmentCenter->uf}}" required minlength="2" maxlength="2">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-2">
                <label for="postal_code">Caixa Postal</label>
                <input type="number" name="postal_code" class="form-control"
                       value="{{$treatmentCenter->postal_code}}" min="10" max="99999999">
            </div>

            <div class="form-group col-xs-5">
                <label for="contact1">Responsável 1</label>
                <input type="text" name="contact1" class="form-control"
                       value="{{$treatmentCenter->contact1}}" minlength="5" maxlength="50">
            </div>

            <div class="form-group col-xs-5">
                <label for="contact2">Responsável 2</label>
                <input type="text" name="contact2" class="form-control"
                       value="{{$treatmentCenter->contact2}}" minlength="5" maxlength="50">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-1">
                <label for="ddd">DDD</label>
                <input type="number" name="ddd" class="form-control" value="{{$treatmentCenter->ddd}}" required size="2">
            </div>

            <div class="form-group col-xs-2">
                <label for="phone_number">Telefone Principal</label>
                <input type="tel" name="phone_number" class="form-control"
                       value="{{$treatmentCenter->phone_number}}" required minlength="7" maxlength="9">
            </div>

            <div class="form-group col-xs-2">
                <label for="general_phone">Telefone Geral</label>
                <input type="tel" name="general_phone" class="form-control"
                       value="{{$treatmentCenter->general_phone}}" minlength="7" maxlength="9">
            </div>

            <div class="form-group col-xs-2">
                <label for="extension">Ramal</label>
                <input type="number" name="extension" class="form-control"
                       value="{{$treatmentCenter->extension}}" min="10" max="9999">
            </div>

            <div class="form-group col-xs-5">
                <label for="site">Site</label>
                <input type="url" name="site" class="form-control" value="{{$treatmentCenter->site}}" minlength="10" maxlength="60">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-4">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{$treatmentCenter->email}}" minlength="8" maxlength="40">
            </div>

            <div class="form-group col-xs-2">
                <label for="latitude">Latitude</label>
                <input type="text" name="latitude" class="form-control"
                       value="{{$treatmentCenter->latitude}}" minlength="8" maxlength="20">
            </div>

            <div class="form-group col-xs-2">
                <label for="references">Longitude</label>
                <input type="text" name="longitude" class="form-control"
                       value="{{$treatmentCenter->longitude}}" minlength="8" maxlength="20">
            </div>

            <div class="form-group col-xs-2">
                <label for="cnes">CNES</label>
                <input type="text" name="cnes" class="form-control" value="{{$treatmentCenter->cnes}}" minlength="3" maxlength="45">
            </div>

            <div class="form-group col-xs-2">
                <label for="open24">Aberto 24h</label><br>
                <input type="radio" name="open24" value="1" {{$treatmentCenter->open24 == 1 ? "checked" : ""}}> Sim
                <input type="radio" name="open24" value="0" {{$treatmentCenter->open24 == 0 ? "checked" : ""}}> Não
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-push-3 col-xs-6">
                <label for="centerSpecialties">Especialidades Atendidas</label>
                <div class="panel panel-default panel-body fixed-panel">
                    @foreach($specialties as $specialty)
                        {{$checked = ""}}

                        @forelse($centerSpecialties as $centerSpecialty)
                            @if($specialty->id == $centerSpecialty->id)
                                <span class="hide">{{$checked = "checked"}}</span>
                                @break
                            @endif
                        @empty
                        @endforelse

                        <input type="checkbox" name="centerSpecialties[]" value="{{$specialty->id}}" {{$checked}}>
                        {{$specialty->name}} - {{$specialty->cbo}}<br>
                    @endforeach
                </div>
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection