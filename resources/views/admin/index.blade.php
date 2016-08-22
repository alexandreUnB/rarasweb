@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="paineis panel panel-primary">
                <div class="tp-painel panel-heading "> <h4 class="h4-main-panel text-center"> Desordens </h4> </div>
                <div class="panel-body">
                    <p> Desordens <span class="badge">   {{number_format($sunDisorders, 0, '.', '.')}} </span> </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="paineis panel panel-primary">
                <div class="tp-painel panel-heading "> <h4 class="h4-main-panel text-center"> Profissionais </h4> </div>
                <div class="panel-body">
                    <p> Profissionais <span class="badge">   {{number_format($sunProfessionals, 0, '.', '.')}} </span> </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="paineis panel panel-primary">
                <div class="tp-painel panel-heading "> <h4 class="h4-main-panel text-center"> Sinais </h4> </div>
                <div class="panel-body">
                    <p> Sinais <span class="badge">   {{number_format($sunSigns, 0, '.', '.')}} </span> </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="paineis panel panel-primary">
                <div class="tp-painel panel-heading "> <h4 class="h4-main-panel text-center"> Sinônimos </h4> </div>
                <div class="panel-body">
                    <p> Sinônimos <span class="badge">   {{number_format($sunSynonymous, 0, '.', '.')}} </span> </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="paineis panel panel-primary">
                <div class="tp-painel panel-heading "> <h4 class="h4-main-panel text-center"> Especialidades </h4> </div>
                <div class="panel-body">
                    <p> Especialidades <span class="badge">   {{number_format($sunSpecialties, 0, '.', '.')}} </span> </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="paineis panel panel-primary">
                <div class="tp-painel panel-heading "> <h4 class="h4-main-panel text-center"> Indicadores </h4> </div>
                <div class="panel-body">
                    <p> Indicadores <span class="badge">   {{number_format($sunIndicators, 0, '.', '.')}} </span> </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-4 col-md-4">
            <div class="paineis panel panel-primary">
                <div class="tp-painel panel-heading "> <h4 class="h4-main-panel text-center"> Centros de Tratamento </h4> </div>
                <div class="panel-body">
                    <p> Centros de Tratamentos <span class="badge"> {{number_format($sunTreatmentCenters, 0, '.', '.')}} </span> </p>
                </div>
            </div>
        </div>
    </div>

@endsection