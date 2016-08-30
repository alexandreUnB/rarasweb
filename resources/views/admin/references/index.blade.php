@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Referências</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary" href={!!URL::to('admin/references/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>

            <div><span class="small">{{$references->total()}} referências</span></div>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/references/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Referência"
                           name="searchedReference" value="{{old('searchedReference')}}" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>

                <div class="input-group">
                    {{$checkedReference = ""}}
                    {{$checkedSource = ""}}
                    {{$checkedMapRelation = ""}}

                    <span class="hide">
                        @if(old('searchType') == 'referenceReference')
                            {{$checkedReference = "checked"}}
                        @elseif(old('searchType') == 'referenceSource')
                            {{$checkedSource = "checked"}}
                        @elseif(old('searchType') == 'referenceMapRelation')
                            {{$checkedMapRelation = "checked"}}
                        @endif
                    </span>

                    <input type="radio" name="searchType" value="referenceReference" {{$checkedReference}} required> Referência
                    <input type="radio" name="searchType" value="referenceSource" {{$checkedSource}} required> Fonte
                    <input type="radio" name="searchType" value="referenceMapRelation" {{$checkedMapRelation}} required> Map Relation
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Fonte</th>
        <th class="text-center">Referência</th>
        <th class="text-center">Map Relation</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($references as $reference)
            <tbody>
            <td class="text-center table-geral">{{$reference->id}}</td>
            <td class="text-td text-center">{{$reference->source}}</td>
            <td class="text-td text-center">{{$reference->reference}}</td>
            <td class="text-td text-center">{{$reference->map_relation}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/references/show/{{$reference->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/references/edit/{{$reference->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/references/delete/{{$reference->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $references->appends(Request::input())->links() !!}

@endsection