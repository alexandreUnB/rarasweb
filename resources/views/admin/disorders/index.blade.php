@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Desordens</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary btn-superior" href={!!URL::to('admin/disorders/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/disorders/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Desordem"
                           name="searchedDisorder" value="{{old('searchedDisorder')}}" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>

                <div class="input-group">
                    {{$checkedName = ""}}
                    {{$checkedOrphanumber = ""}}

                    <span class="hide">
                        @if(old('searchType') == 'disorderName')
                            {{$checkedName = "checked"}}
                        @elseif(old('searchType') == 'disorderOrphanumber')
                            {{$checkedOrphanumber = "checked"}}
                        @endif
                    </span>

                    <input type="radio" name="searchType" value="disorderName" {{$checkedName}} required> Nome
                    <input type="radio" name="searchType" value="disorderOrphanumber" {{$checkedOrphanumber}} required> Orphanumber
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Nome da Desordem</th>
        <th class="text-center">Orphanumber</th>
        <th class="text-center">CID-10</th>
        <th class="text-center">Omim</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>


        @foreach($disorders as $disorder)
            <tbody>
            <td class="text-center table-geral">{{$disorder->id}}</td>
            <td class="text-td">{{$disorder->name}}</td>
            <td class="text-td text-center">{{$disorder->orphanumber}}</td>
            <td class="text-td text-center">
                @if($disorder->references()->where('source', 'ICD-10')->first())
                    {{$disorder->references()->where('source', 'ICD-10')->orderBy('reference')->first()->reference}}
                @else
                    -
                @endif
            </td>
            <td class="text-td text-center">
                @if($disorder->references()->where('source', 'OMIM')->first())
                    {{$disorder->references()->where('source', 'OMIM')->orderBy('reference')->first()->reference}}
                @else
                    -
                @endif
            </td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/disorders/show/{{$disorder->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/disorders/edit/{{$disorder->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/disorders/delete/{{$disorder->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $disorders->appends(Request::input())->links() !!}

@endsection