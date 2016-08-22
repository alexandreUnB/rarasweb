@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Tipos de Desordem</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary btn-superior" href={!!URL::to('admin/disordertypes/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/disordertypes/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Tipo de Desordem"
                           name="searchedDisorderType" value="{{old('searchedDisorderType')}}" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Tipo de Desordem</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($disorderTypes as $disorderType)
            <tbody>
            <td class="text-center table-geral">{{$disorderType->id}}</td>
            <td class="text-td">{{$disorderType->name}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/disordertypes/show/{{$disorderType->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/disordertypes/edit/{{$disorderType->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/disordertypes/delete/{{$disorderType->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $disorderTypes->appends(Request::input())->links() !!}

@endsection