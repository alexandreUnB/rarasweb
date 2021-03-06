@extends('layouts.main')

@section('content')

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Desordem</a></li>
            <li><a href="#tab2" data-toggle="tab">Sinônimos</a></li>
            <li><a href="#tab3" data-toggle="tab">Sinais</a></li>
            <li><a href="#tab4" data-toggle="tab">Referências</a></li>
            <li><a href="#tab5" data-toggle="tab">Indicadores</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <div class="panel panel-primary panel-show">
                    <div class="panel-heading text-center">
                        <h4><strong>{{$disorder->name}}</strong></h4>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <p>Orphanumber: <strong>{{$disorder->orphanumber}}</strong></p>
                            </div>

                            <div class="col-xs-5">
                                <p>Tipo de Desordem:
                                    <strong>
                                        @if($disorderType)
                                            {{$disorderType->name}}
                                        @else
                                            <span class="alert-warning">Não existe tipo associado</span>
                                        @endif
                                    </strong>
                                </p>
                            </div>

                            <div class="col-xs-1">
                                <p>CID-10:</p>
                            </div>

                            <div class="col-xs-3">
                                <strong>
                                    @forelse($icds as $icd)
                                        {{$icd}}

                                        @if($countICDs)
                                            -
                                            <span class="hide">{{$countICDs--}}</span>
                                        @endif
                                    @empty
                                        -
                                    @endforelse
                                </strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-8">
                                @if($protocol)
                                    {{--<div class="modal fade" id="modal" tabindex="-1">--}}
                                        {{--<div class="modal-dialog modal-lg">--}}
                                            {{--<div class="modal-content" >--}}
                                                {{--<div class="modal-header">--}}
                                                    {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                                                    {{--<h4 class="modal-title text-center">Protocolo</h4>--}}
                                                {{--</div>--}}
                                                {{--<div class="modal-body">--}}
                                                    {{--<iframe class="form-modal" width="100%" height="500"--}}
                                                            {{--src="{{"../../../protocols/".$protocol->name_pdf }}"></iframe>--}}
                                                {{--</div>--}}
                                                {{--<div class="modal-footer">--}}
                                                    {{--<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <p>Protocolo:
                                        {{--<a href="#" data-toggle="modal" data-target="#modal">{{$protocol->document}}</a>--}}
                                        <a href="{{"../../../protocols/".$protocol->name_pdf }}" target="_blank">{{$protocol->document}}</a>
                                    </p>
                                @else
                                    <p>Protocolo:
                                        <strong>
                                            <span class="alert-warning">Não existe protocolo associado</span>
                                        </strong>
                                    </p>
                                @endif
                            </div>

                            <div class="col-xs-1">
                                <p>MeSH:
                                </p>
                            </div>

                            <div class="col-xs-3">
                                @forelse($meshes as $mesh)
                                    <a href="http://www.ncbi.nlm.nih.gov/mesh/{{$mesh}}" target="_blank">{{$mesh}}</a>

                                    @if($countMeSHes)
                                        <strong>-</strong>
                                        <span class="hide">{{$countMeSHes--}}</span>
                                    @endif
                                @empty
                                    <strong>-</strong>
                                @endforelse
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-offset-8 col-xs-1">
                                <p>UMLS:</p>
                            </div>

                            <div class="col-xs-3">
                                <strong>
                                    @forelse($umlses as $umls)
                                        {{$umls}}

                                        @if($countUMLSes)
                                            -
                                            <span class="hide">{{$countUMLSes--}}</span>
                                        @endif
                                    @empty
                                        -
                                    @endforelse
                                </strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-offset-8 col-xs-1">
                                <p>MedDRA:</p>
                            </div>

                            <div class="col-xs-3">
                                <strong>
                                    @forelse($meddras as $meddra)
                                        {{$meddra}}

                                        @if($countMedDRAs)
                                            -
                                            <span class="hide">{{$countMedDRAs--}}</span>
                                        @endif
                                    @empty
                                        -
                                    @endforelse
                                </strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-8">
                                <p>Descrição:
                                    <textarea class="form-control vresize" rows="5" id="description"
                                              name="description" disabled>{{$disorder->description}}</textarea>
                                </p>
                            </div>

                            <div class="col-xs-1">
                                <p>OMIM:</p>
                            </div>

                            <div class="col-xs-3">
                                @forelse($omims as $omim)
                                    <a href="http://www.omim.org/entry/{{$omim}}" target="_blank" >{{$omim}}</a>

                                    @if($countOMIMs)
                                        <strong>-</strong>
                                        <span class="hide">{{$countOMIMs--}}</span>
                                    @endif
                                @empty
                                    <strong>-</strong>
                                @endforelse
                            </div>
                        </div>
                        @permission('view-medications')
                            <div class="row">
                                <div class="col-xs-8">
                                    <p>Medicamentos:
                                        <textarea class="form-control vresize" rows="5" id="drugs"
                                                  name="drugs" disabled>{{$disorder->drugs}}</textarea>
                                    </p>
                                </div>
                            </div>
                        @endpermission
                        @permission('view-procedures')
                            <div class="row">
                                <div class="col-xs-8">
                                    <p>Procedimentos:
                                        <textarea class="form-control vresize" rows="5" id="procedures"
                                                  name="procedures" disabled>{{$disorder->procedures}}</textarea>
                                    </p>
                                </div>
                            </div>
                        @endpermission
                        <div class="row">
                            <div class="col-xs-8">
                                <p>Referências Bibliográficas:
                                    <textarea class="form-control vresize" rows="5" id="references"
                                              name="references" disabled>{{$disorder->references}}</textarea>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab2">
                <div class="panel panel-primary panel-show">
                    <div class="panel-heading text-center">
                        <h4><strong>{{$disorder->name}}</strong></h4>
                    </div>

                    <div class="panel-body">
                        @if(count($synonyms))
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-geral">
                                <th class="text-center">ID</th>
                                <th class="text-center">Nome do Sinônimo</th>
                                <th class="text-center">Detalhes</th>
                                </thead>

                                @foreach($synonyms as $synonymous)
                                    <tbody>
                                    <td class="text-center table-geral">{{$synonymous->id}}</td>
                                    <td class="text-td">{{$synonymous->name}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-default" href="/synonyms/show/{{$synonymous->id}}">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                    </td>
                                    </tbody>
                                @endforeach
                            </table>

                            {!! $synonyms->links() !!}
                        @else
                            <strong>
                                <span class="alert-warning">Não existem sinônimos associados a essa doença</span>
                            </strong>
                        @endif
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab3">
                <div class="panel panel-primary panel-show">
                    <div class="panel-heading text-center">
                        <h4><strong>{{$disorder->name}}</strong></h4>
                    </div>

                    <div class="panel-body">
                        @if(count($signs))
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-geral">
                                <th class="text-center">ID</th>
                                <th class="text-center">Nome do Sinal</th>
                                <th class="text-center">Frequência</th>
                                <th class="text-center">Detalhes</th>
                                </thead>

                                @foreach($signs as $sign)
                                    <tbody>
                                    <td class="text-center table-geral">{{$sign->id}}</td>
                                    <td class="text-td">{{$sign->name}}</td>
                                    <td class="text-td text-center">{{$sign->frequency}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-default" href="/signs/show/{{$sign->id}}">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                    </td>
                                    </tbody>
                                @endforeach
                            </table>

                            {!! $signs->links() !!}
                        @else
                            <strong>
                                <span class="alert-warning">Não existem sinais associados a essa doença</span>
                            </strong>
                        @endif
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab4">
                <div class="panel panel-primary panel-show">
                    <div class="panel-heading text-center">
                        <h4><strong>{{$disorder->name}}</strong></h4>
                    </div>

                    <div class="panel-body">
                        @if(count($references))
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-geral">
                                <th class="text-center">ID</th>
                                <th class="text-center">Fonte</th>
                                <th class="text-center">Referência</th>
                                <th class="text-center">Map Relation</th>
                                <th class="text-center">Detalhes</th>
                                </thead>

                                @foreach($references as $reference)
                                    <tbody>
                                    <td class="text-center table-geral">{{$reference->id}}</td>
                                    <td class="text-td text-center">{{$reference->source}}</td>
                                    <td class="text-td text-center">{{$reference->reference}}</td>
                                    <td class="text-td">{{$reference->map_relation}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-default" href="/references/show/{{$reference->id}}">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                    </td>
                                    </tbody>
                                @endforeach
                            </table>

                            {!! $references->links() !!}
                        @else
                            <strong>
                                <span class="alert-warning">Não existem referências associadas a essa doença</span>
                            </strong>
                        @endif
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab5">
                <div class="panel panel-primary panel-show">
                    <div class="panel-heading text-center">
                        <h4><strong>{{$disorder->name}}</strong></h4>
                    </div>

                    <div class="panel-body">
                        @if(count($indicators))
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-geral">
                                <th class="text-center">ID</th>
                                <th class="text-center">Desordem</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Fonte</th>
                                <th class="text-center">Ano</th>
                                <th class="text-center">Detalhes</th>
                                </thead>

                                @foreach($indicators as $indicator)
                                    <tbody>
                                    <td class="text-center table-geral">{{$indicator->id}}</td>
                                    <td class="text-td text-center">{{$indicator->disorder->name}}</td>
                                    <td class="text-td text-center">{{$indicator->indicatorType->name}}</td>
                                    <td class="text-td text-center">{{$indicator->indicatorSource->name}}</td>
                                    <td class="text-td text-center">{{$indicator->year}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-default" href="/indicators/show/{{$indicator->id}}">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                    </td>
                                    </tbody>
                                @endforeach
                            </table>
                        @else
                            <strong>
                                <span class="alert-warning">Não existem indicadores associados a essa doença</span>
                            </strong>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="actions" class="row text-right">
        <div class="col-xs-12">
            <a href="/" class="btn btn-default">Voltar</a>
        </div>
    </div>

@endsection