@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Indicadores</h3>

    <div class="row">
        <div class="col-xs-8">
            <a class="btn btn-primary btn-superior" href={!!URL::to('admin/indicators/create')!!}>
                <i class="glyphicon glyphicon-plus"> Novo</i>
            </a>
        </div>

        <div class="col-xs-4 text-right">
            <form role="search" action="/admin/indicators/search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Indicador"
                           name="searchedIndicator" value="{{old('searchedIndicator')}}" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>

                <div class="input-group">
                    {{$checkedDisorder = ""}}
                    {{$checkedType = ""}}
                    {{$checkedSource = ""}}
                    {{$checkedYear = ""}}

                    <span class="hide">
                        @if(old('searchType') == 'indicatorDisorder')
                            {{$checkedDisorder = "checked"}}
                        @elseif(old('searchType') == 'indicatorType')
                            {{$checkedType = "checked"}}
                        @elseif(old('searchType') == 'indicatorSource')
                            {{$checkedSource = "checked"}}
                        @elseif(old('searchType') == 'indicatorYear')
                            {{$checkedYear = "checked"}}
                        @endif
                    </span>

                    <input type="radio" name="searchType" value="indicatorDisorder" {{$checkedDisorder}} required> Desordem
                    <input type="radio" name="searchType" value="indicatorType" {{$checkedType}} required> Tipo
                    <input type="radio" name="searchType" value="indicatorSource" {{$checkedSource}} required> Fonte
                    <input type="radio" name="searchType" value="indicatorYear" {{$checkedYear}} required> Ano
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Desordem</th>
        <th class="text-center">Tipo</th>
        <th class="text-center">Fonte</th>
        <th class="text-center">Ano</th>
        <th class="text-center">Detalhes</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Deletar</th>
        </thead>

        @foreach($indicators as $indicator)
            <tbody>
            <td class="text-center table-geral">{{$indicator->id}}</td>
            <td class="text-td text-center">{{$indicator->disorder->name}}</td>
            <td class="text-td text-center">{{$indicator->indicatorType->name}}</td>
            <td class="text-td text-center">{{$indicator->indicatorSource->name}}</td>
            <td class="text-td text-center">{{$indicator->year}}</td>
            <td class="text-center">
                <a class="btn btn-default" href="/admin/indicators/show/{{$indicator->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-primary" href="/admin/indicators/edit/{{$indicator->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-danger" href="/admin/indicators/delete/{{$indicator->id}}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    {!! $indicators->appends(Request::input())->links() !!}

@endsection