@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Centros de Tratamento</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary btn-superior" href={!!URL::to('admin/treatmentCenters/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/treatmentCenters/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Centro de Tratamento"
                           name="searchedCenter" value="{{old('searchedCenter')}}" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>

                <div class="input-group">
                    {{$checkedName = ""}}
                    {{$checkedCity = ""}}
                    {{$checkedSpecialty = ""}}

                    <span class="hide">
                        @if(old('searchType') == 'centerName')
                            {{$checkedName = "checked"}}
                        @elseif(old('searchType') == 'centerCity')
                            {{$checkedCity = "checked"}}
                        @elseif(old('searchType') == 'centerSpecialty')
                            {{$checkedSpecialty = "checked"}}
                        @endif
                    </span>

                    <input type="radio" name="searchType" value="centerName" {{$checkedName}} required> Nome
                    <input type="radio" name="searchType" value="centerCity" {{$checkedCity}} required> Cidade
                    <input type="radio" name="searchType" value="centerSpecialty" {{$checkedSpecialty}} required> Especialidade
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Nome do Centro</th>
        <th class="text-center">Cidade - UF</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($treatmentCenters as $treatmentCenter)
            <tbody>
            <td class="text-center table-geral">{{$treatmentCenter->id}}</td>
            <td class="text-td">{{$treatmentCenter->name}}</td>
            <td class="text-td text-center">{{$treatmentCenter->city}} - {{$treatmentCenter->uf}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/treatmentCenters/show/{{$treatmentCenter->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/treatmentCenters/edit/{{$treatmentCenter->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/treatmentCenters/delete/{{$treatmentCenter->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $treatmentCenters->appends(Request::input())->links() !!}

@endsection