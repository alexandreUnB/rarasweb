@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Adicionar Profissional</h3>

    <form action="/admin/professionals/store" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-4">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}"
                       autofocus required minlength="2" maxlength="100">
            </div>

            <div class="form-group col-xs-4">
                <label for="surname">Sobrenome</label>
                <input type="text" name="surname" class="form-control"
                       value="{{old('surname')}}" required minlength="2" maxlength="100">
            </div>

            <div class="form-group col-xs-2">
                <label for="council_number">Nº Conselho</label>
                <input type="number" name="council_number" class="form-control"
                       value="{{old('council_number')}}" min="10" max="99999">
            </div>

            <div class="form-group col-xs-2">
                <label for="active">Ativo</label><br>
                {{$checked1 = ""}}
                {{$checked0 = ""}}

                @if(old('active'))
                    <span class="hide">{{old('active') == 1 ? $checked1 = "checked" : $checked0 = "checked"}}</span>
                @endif

                <input type="radio" name="active" value="1" {{$checked1}} required> Sim
                <input type="radio" name="active" value="0" {{$checked0}} required> Não
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-3">
                <label for="city">Cidade</label>
                <input type="text" name="city" class="form-control" value="{{old('city')}}" minlength="2" maxlength="45">
            </div>

            <div class="form-group col-xs-1">
                <label for="uf">UF</label>
                <input type="text" name="uf" class="form-control" value="{{old('uf')}}" minlength="2" maxlength="2">
            </div>

            <div class="form-group col-xs-1">
                <label for="ddd">DDD</label>
                <input type="number" name="ddd" class="form-control" value="{{old('ddd')}}" size="2">
            </div>

            <div class="form-group col-xs-2">
                <label for="telephone">Telefone</label>
                <input type="tel" name="telephone" class="form-control" value="{{old('telephone')}}" minlength="7" maxlength="9">
            </div>

            <div class="form-group col-xs-5">
                <label for="facebook">Facebook</label>
                <input type="url" name="facebook" class="form-control" value="{{old('facebook')}}" minlength="10" maxlength="60">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-4">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{old('email')}}" minlength="8" maxlength="40">
            </div>

            <div class="form-group col-xs-3">
                <label for="profession">Ocupação</label>
                <input type="text" name="profession" class="form-control" value="{{old('profession')}}" minlength="2" maxlength="40">
            </div>

            <div class="form-group col-xs-5">
                <label for="twitter">Twitter</label>
                <input type="url" name="twitter" class="form-control" value="{{old('twitter')}}" minlength="10" maxlength="60">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-push-3 col-xs-6">
                <label for="professionalSpecialties">Especialidades do Profissional</label>
                <div class="panel panel-default panel-body fixed-panel">
                    @foreach($specialties as $specialty)
                        {{$checked = ""}}

                        @if(old('professionalSpecialties'))
                            @foreach(old('professionalSpecialties') as $professionalSpecialty)
                                @if($specialty->id == $professionalSpecialty)
                                    <span class="hide">{{$checked = "checked"}}</span>
                                    @break
                                @endif
                            @endforeach
                        @endif

                        <input type="checkbox" name="professionalSpecialties[]" value="{{$specialty->id}}" {{$checked}}>
                        {{$specialty->name}} - {{$specialty->cbo}}<br>
                    @endforeach
                </div>
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/professionals" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection