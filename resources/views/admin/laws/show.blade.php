@extends('layouts.admin')

@section('content')

    <div class="panel panel-primary panel-show">
        <div class="panel-heading text-center">
            <h4><strong>{{$law->name_law}}</strong></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <p>Resumo:
                        <textarea class="form-control vresize" rows="5" id="resume" name="resume" disabled>{{$law->resume}}</textarea>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <iframe class="form-modal" width="100%" height="800" src="{{"../../../laws/" . $law->name_pdf }}"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-xs-12">
            <a href="/admin/laws" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection