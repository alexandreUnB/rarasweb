@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$specialty->name}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-8">
                    <p>Especialidade: <strong>{{$specialty->name}}</strong></p>
                </div>

                <div class="col-xs-4">
                    <p>CBO: <strong>{{$specialty->cbo}}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="/admin/specialties" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection