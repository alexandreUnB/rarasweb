@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$protocol->disorder->name}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <iframe class="form-modal" width="100%" height="800" src="{{"../../../protocols/" . $protocol->name_pdf }}"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="/admin/protocols" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection