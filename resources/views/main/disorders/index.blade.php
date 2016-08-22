@extends('layouts.main')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Desordens</h3>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-geral">
        <th class="text-center">ID</th>
        <th class="text-center">Nome da Desordem</th>
        <th class="text-center">Orphanumber</th>
        <th class="text-center">CID-10</th>
        <th class="text-center">Omim</th>
        <th class="text-center">Detalhes</th>
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
                <a class="btn btn-default" href="/disorders/show/{{$disorder->id}}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
            </tbody>
        @endforeach
    </table>

    <div id="actions" class="row">
        <div class="col-xs-6">
            {!! $disorders->links() !!}
        </div>

        <div class="col-xs-6 text-right">
            <a href="/" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection