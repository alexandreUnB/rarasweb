@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Protocolos</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary" href={!!URL::to('admin/protocols/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>

            <div><span class="small">{{$protocols->total()}} protocolos</span></div>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/protocols/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Desordem"
                           name="searchedProtocol" value="{{old('searchedProtocol')}}" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>

                <div class="input-group">
                    {{$checkedName = ""}}
                    {{$checkedOrphanumber = ""}}

                    <span class="hide">
                        @if(old('searchType') == 'protocolDisorderName')
                            {{$checkedName = "checked"}}
                        @elseif(old('searchType') == 'protocolDisorderOrphanumber')
                            {{$checkedOrphanumber = "checked"}}
                        @endif
                    </span>

                    <input type="radio" name="searchType" value="protocolDisorderName" {{$checkedName}} required> Nome
                    <input type="radio" name="searchType" value="protocolDisorderOrphanumber" {{$checkedOrphanumber}} required> Orphanumber
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Desordem</th>
        <th class="text-center">Orphanumber</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($protocols as $protocol)
            <tbody>
            <td class="text-center table-geral">{{$protocol->id}}</td>
            <td class="text-td">{{$protocol->disorder->name}}</td>
            <td class="text-td text-center">{{$protocol->disorder->orphanumber}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/protocols/show/{{$protocol->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/protocols/edit/{{$protocol->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/protocols/delete/{{$protocol->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $protocols->appends(Request::input())->links() !!}

@endsection