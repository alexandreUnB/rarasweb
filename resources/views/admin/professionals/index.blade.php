@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Profissionais</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary" href={!!URL::to('admin/professionals/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>

            <div><span class="small">{{$professionals->total()}} profissionais</span></div>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/professionals/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Profissional"
                           name="searchedProfessional" value="{{old('searchedProfessional')}}" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>

                <div class="input-group">
                    {{$checkedName = ""}}
                    {{$checkedCity = ""}}
                    {{$checkedSpecialty = ""}}

                    <span class="hide">
                        @if(old('searchType') == 'professionalName')
                            {{$checkedName = "checked"}}
                        @elseif(old('searchType') == 'professionalCity')
                            {{$checkedCity = "checked"}}
                        @elseif(old('searchType') == 'professionalSpecialty')
                            {{$checkedSpecialty = "checked"}}
                        @endif
                    </span>

                    <input type="radio" name="searchType" value="professionalName" {{$checkedName}} required> Nome
                    <input type="radio" name="searchType" value="professionalCity" {{$checkedCity}} required> Cidade
                    <input type="radio" name="searchType" value="professionalSpecialty" {{$checkedSpecialty}} required> Especialidade
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Nome do Profissional</th>
        <th class="text-center">Cidade - UF</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($professionals as $professional)
            <tbody>
            <td class="text-center table-geral">{{$professional->id}}</td>
            <td class="text-td">{{$professional->name}} {{$professional->surname}}</td>
            <td class="text-td text-center">{{$professional->city}} - {{$professional->uf}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/professionals/show/{{$professional->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/professionals/edit/{{$professional->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/professionals/delete/{{$professional->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $professionals->appends(Request::input())->links() !!}

@endsection