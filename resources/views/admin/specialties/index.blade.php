@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Especialidades</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary" href={!!URL::to('admin/specialties/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>

            <div><span class="small">{{$specialties->total()}} especialidades</span></div>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/specialties/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Especialidade"
                           name="searchedSpecialty" value="{{old('searchedSpecialty')}}" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>

                <div class="input-group">
                    {{$checkedName = ""}}
                    {{$checkedCBO = ""}}

                    <span class="hide">
                        @if(old('searchType') == 'specialtyName')
                            {{$checkedName = "checked"}}
                        @elseif(old('searchType') == 'specialtyCBO')
                            {{$checkedCBO = "checked"}}
                        @endif
                    </span>

                    <input type="radio" name="searchType" value="specialtyName" {{$checkedName}} required> Nome
                    <input type="radio" name="searchType" value="specialtyCBO" {{$checkedCBO}} required> CBO
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Especialidade</th>
        <th class="text-center">CBO</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($specialties as $specialty)
            <tbody>
            <td class="text-center table-geral">{{$specialty->id}}</td>
            <td class="text-td">{{$specialty->name}}</td>
            <td class="text-td text-center">{{$specialty->cbo}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/specialties/show/{{$specialty->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/specialties/edit/{{$specialty->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/specialties/delete/{{$specialty->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $specialties->appends(Request::input())->links() !!}

@endsection