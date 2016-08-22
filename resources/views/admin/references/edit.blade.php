@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Editando Referência - <strong>{{$reference->source}} - {{$reference->reference}}</strong></h3>

    <form action="/admin/references/update/{{$reference->id}}" method="post">
        {{csrf_field()}}
        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="source">Fonte</label>
                <select class="form-control" name="source" id="source" required>
                    @foreach($sources as $source)
                        <option value="{{$source}}" {{$reference->source ==
                        $source ? "selected" : ""}}>{{$source}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-xs-6">
                <label for="name">Referência</label>
                <input type="text" name="reference" class="form-control"
                       value="{{$reference->reference}}" required minlength="2" maxlength="10">
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection