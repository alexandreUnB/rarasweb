@extends('layouts.admin')

@section('content')

    <h3 class="page-header">Sinônimos</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary" href={!!URL::to('admin/synonyms/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>

            <div><span class="small">{{$synonyms->total()}} sinônimos</span></div>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/synonyms/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nome do Sinônimo" name="search" value="{{old('search')}}" autofocus>
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
        <th class="text-center">Nome do Sinônimo</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($synonyms as $synonymous)
            <tbody>
            <td class="text-center table-geral">{{$synonymous->id}}</td>
            <td class="text-td">{{$synonymous->name}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/synonyms/show/{{$synonymous->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/synonyms/edit/{{$synonymous->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/synonyms/delete/{{$synonymous->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $synonyms->appends(Request::input())->links() !!}

@endsection