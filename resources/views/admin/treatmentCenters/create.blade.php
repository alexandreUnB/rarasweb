@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Adicionar Centro de Tratamento</h3>

    <form action="/admin/treatmentCenters/store" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-5">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}"
                       autofocus required minlength="8" maxlength="200">
            </div>

            <div class="form-group col-xs-2">
                <label for="abbreviation">Sigla</label>
                <input type="text" name="abbreviation" class="form-control"
                       value="{{old('abbreviation')}}" minlength="2" maxlength="20">
            </div>

            <div class="form-group col-xs-4">
                <label for="address">Endereço</label>
                <input type="text" name="address" class="form-control"
                       value="{{old('address')}}" required minlength="5" maxlength="100">
            </div>

            <div class="form-group col-xs-1">
                <label for="number">Número</label>
                <input type="number" name="number" class="form-control" value="{{old('number')}}" min="1" max="99999">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-3">
                <label for="neighborhood">Bairro</label>
                <input type="text" name="neighborhood" class="form-control"
                       value="{{old('neighborhood')}}" minlength="3" maxlength="30">
            </div>

            <div class="form-group col-xs-3">
                <label for="complement">Complemento</label>
                <input type="text" name="complement" class="form-control" value="{{old('complement')}}" minlength="2" maxlength="60">
            </div>

            <div class="form-group col-xs-2">
                <label for="cep">CEP</label>
                <input type="number" name="cep" class="form-control" value="{{old('cep')}}" required size="8">
            </div>
            <div class="form-group col-xs-3">
                <label for="city">Cidade</label>
                <input type="text" name="city" class="form-control"
                       value="{{old('neighborhood')}}" required minlength="3" maxlength="45">
            </div>

            <div class="form-group col-xs-1">
                <label for="uf">UF</label>
                <input type="text" name="uf" class="form-control" value="{{old('uf')}}" required minlength="2" maxlength="2">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-2">
                <label for="postal_code">Caixa Postal</label>
                <input type="number" name="postal_code" class="form-control" value="{{old('postal_code')}}" min="10" max="99999999">
            </div>

            <div class="form-group col-xs-5">
                <label for="contact1">Responsável 1</label>
                <input type="text" name="contact1" class="form-control" value="{{old('contact1')}}" minlength="5" maxlength="50">
            </div>

            <div class="form-group col-xs-5">
                <label for="contact2">Responsável 2</label>
                <input type="text" name="contact2" class="form-control" value="{{old('contact2')}}" minlength="5" maxlength="50">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-1">
                <label for="ddd">DDD</label>
                <input type="number" name="ddd" class="form-control" value="{{old('ddd')}}" required size="2">
            </div>

            <div class="form-group col-xs-2">
                <label for="phone_number">Telefone Principal</label>
                <input type="tel" name="phone_number" class="form-control"
                       value="{{old('phone_number')}}" required minlength="7" maxlength="9">
            </div>

            <div class="form-group col-xs-2">
                <label for="general_number">Telefone Geral</label>
                <input type="tel" name="general_number" class="form-control"
                       value="{{old('general_number')}}" minlength="7" maxlength="9">
            </div>

            <div class="form-group col-xs-2">
                <label for="extension">Ramal</label>
                <input type="number" name="extension" class="form-control" value="{{old('extension')}}" min="10" max="9999">
            </div>

            <div class="form-group col-xs-5">
                <label for="site">Site</label>
                <input type="url" name="site" class="form-control" value="{{old('site')}}" minlength="10" maxlength="60">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-4">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{old('email')}}" minlength="8" maxlength="40">
            </div>

            <div class="form-group col-xs-2">
                <label for="latitude">Latitude</label>
                <input type="text" name="latitude" class="form-control" value="{{old('latitude')}}" minlength="8" maxlength="20">
            </div>

            <div class="form-group col-xs-2">
                <label for="references">Longitude</label>
                <input type="text" name="longitude" class="form-control" value="{{old('longitude')}}" minlength="8" maxlength="20">
            </div>

            <div class="form-group col-xs-2">
                <label for="cnes">CNES</label>
                <input type="text" name="cnes" class="form-control" value="{{old('cnes')}}" minlength="3" maxlength="45">
            </div>

            <div class="form-group col-xs-2">
                <label for="open24">Aberto 24h</label><br>
                {{$checked1 = ""}}
                {{$checked0 = ""}}

                @if(old('open24'))
                    <span class="hide">{{old('open24') == 1 ? $checked1 = "checked" : $checked0 = "checked"}}</span>
                @endif

                <input type="radio" name="open24" value="1" {{$checked1}}> Sim
                <input type="radio" name="open24" value="0" {{$checked0}}> Não
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-push-3 col-xs-6">
                <label for="centerSpecialties">Especialidades Atendidas</label>
                <div class="panel panel-default panel-body fixed-panel">
                    @foreach($specialties as $specialty)
                        {{$checked = ""}}

                        @if(old('centerSpecialties'))
                            @foreach(old('centerSpecialties') as $centerSpecialtiy)
                                @if($specialty->id == $centerSpecialtiy)
                                    <span class="hide">{{$checked = "checked"}}</span>
                                    @break
                                @endif
                            @endforeach
                        @endif

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
                <a href="/admin/treatmentCenters" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection