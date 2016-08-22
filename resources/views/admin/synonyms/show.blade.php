@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$synonymous->name}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6">
                    <p>Nome: <strong>{{$synonymous->name}}</strong></p>
                </div>

                <div class="col-xs-6">
                    <p>Desordem: <strong>{{$synonymousDisorder->name}}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection