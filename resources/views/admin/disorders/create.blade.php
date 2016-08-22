@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Adicionar Desordem</h3>

    <form action="/admin/disorders/store" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-5">
                <label for="name">Nome da Desordem</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}"
                       autofocus required minlength="4" maxlength="120">
            </div>

            <div class="form-group col-xs-2">
                <label for="orphanumber">Orphanumber</label>
                <input type="number" name="orphanumber" class="form-control"
                       value="{{old('orphanumber')}}" required min="1" max="999999">
            </div>

            <div class="form-group col-xs-5">
                <label for="disorderType">Tipo de Desordem</label>
                <select class="form-control" name="disorderType" id="disorderType_id" required>
                    <option value="" hidden>Selecione ou digite o tipo de desordem</option>
                    @foreach($disorderTypes as $disorderType)
                        <option value="{{$disorderType->id}}" {{$disorderType->id ==
                        old('disorderType') ? "selected" : ""}}>{{$disorderType->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-4">
                <label for="disorderSpecialties">Especialidades da Desordem</label>
                <div class="panel panel-default panel-body fixed-panel">
                    @foreach($specialties as $specialty)
                        {{$checked = ""}}

                        @if(old('disorderSpecialties'))
                            @foreach(old('disorderSpecialties') as $disorderSpecialty)
                                @if($specialty->id == $disorderSpecialty)
                                    <span class="hide">{{$checked = "checked"}}</span>
                                    @break
                                @endif
                            @endforeach
                        @endif

                        <input type="checkbox" name="disorderSpecialties[]" value="{{$specialty->id}}" {{$checked}}>
                        {{$specialty->name}} - {{$specialty->cbo}}<br>
                    @endforeach
                </div>
            </div>

            <div class="form-group col-xs-8">
                <label for="disorderReferences">Referências da Desordem</label>
                <div class="panel panel-default panel-body fixed-panel">
                    @foreach($references as $reference)
                        {{$checked = ""}}

                        @if(old('disorderReferences'))
                            @foreach(old('disorderReferences') as $disorderReference)
                                @if($reference->id == $disorderReference)
                                    <span class="hide">{{$checked = "checked"}}</span>
                                    @break
                                @endif
                            @endforeach
                        @endif

                        <input type="checkbox" name="disorderReferences[]" value="{{$reference->id}}" {{$checked}}>
                        {{$reference->source}} - {{$reference->reference}} - {{$reference->map_relation}}<br>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-push-1 col-xs-10">
                <label for="disorderSigns">Sinais da Desordem</label>
                <div class="panel panel-default panel-body fixed-panel">
                    @foreach($signs as $sign)
                        {{$checked = ""}}

                        @if(old('disorderSigns'))
                            @foreach(old('disorderSigns') as $disorderSign)
                                @if($sign->id == $disorderSign)
                                    <span class="hide">{{$checked = "checked"}}</span>
                                    @break
                                @endif
                            @endforeach
                        @endif

                        <input type="checkbox" name="disorderSigns[]" value="{{$sign->id}}" {{$checked}}>
                        {{$sign->name}} - {{$sign->frequency}}<br>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-12">
                <label for="description">Descrição</label>
                <textarea class="form-control vresize" rows="5" id="description" name="description"
                          maxlength="10000">{{old('description')}}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-12">
                <label for="drugs">Medicamentos</label>
                <textarea class="form-control vresize" rows="5" id="drugs" name="drugs"
                          maxlength="5000">{{old('drugs')}}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-12">
                <label for="procedures">Procedimentos</label>
                <textarea class="form-control vresize" rows="5" id="procedures" name="procedures"
                          maxlength="5000">{{old('procedures')}}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-12">
                <label for="references">Referências Bibliográficas</label>
                <textarea class="form-control vresize" rows="5" id="references" name="references"
                          maxlength="5000">{{old('references')}}</textarea>
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/disorders" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection