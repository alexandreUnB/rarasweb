@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Editando Sinal - <strong>{{$sign->name}}</strong></h3>

    <form action="/admin/signs/update/{{$sign->id}}" method="post">
        {{csrf_field()}}
        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-6">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{$sign->name}}"
                       autofocus required minlength="5" maxlength="120">
            </div>

            <div class="form-group col-xs-6">
                <label for="frequency">Frequência</label>
                <select class="form-control" name="frequency" id="frequency" required>
                    @foreach($frequencies as $frequency)
                        <option value="{{$frequency}}" {{$sign->frequency ==
                        $frequency ? "selected" : ""}}>{{$frequency}}</option>
                    @endforeach
                </select>
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