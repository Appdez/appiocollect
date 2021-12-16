@extends('layouts.backend.dashboard')

@section('sessions')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <strong>{{ session('success') }}</strong>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <strong>{{ session('error') }}</strong>
            </div>
        </div>
    @endif
    @if (session('errors'))
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                @error('maxAge')
                    <strong>{{ $message }}</strong><br>
                @enderror

                @error('minAge')
                    <strong>{{ $message }}</strong><br>
                @enderror
                @error('email')
                    <strong>{{ $message }}</strong><br>
                @enderror
            </div>
        </div>
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                   @role('admin')
                        <div class="col-sm-3">
                            <a href="{{ route('relatorio.geral') }}" class="btn btn-dark w-100 float-right"
                                aria-expanded="false">
                                Baixar Relatório geral
                            </a>
                        </div>
                        @endrole

                    <div class="col-sm-3">
                        <div class="dropdown open w-100">
                            <button class="btn btn-dark dropdown-toggle  float-right" type="button" id="triggerId2" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Baixar relatórios todos meses
                                    </button>
                            <div class="dropdown-menu" aria-labelledby="triggerId2">
                                @foreach ($bairros as $bairro)
                                <a class="dropdown-item has-icon" href="{{ route('relatorio.bairro',$bairro->uuid) }}">
                                    <i class="fas fa-file-excel"></i>
                                    {{$bairro->name}}
                                </a>
                                @endforeach
                              </div>
                       </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="dropdown open w-100">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Relatórios do mês passado
                                    </button>
                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                @foreach ($bairros as $bairro)
                                <a class="dropdown-item has-icon" href="{{ route('relatorio',$bairro->uuid) }}">
                                    <i class="fas fa-file-excel"></i>
                                    {{$bairro->name}}
                                </a>
                                @endforeach
                              </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="dropdown open w-100">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="triggerId3" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Relatórios do mês actual
                                    </button>
                            <div class="dropdown-menu" aria-labelledby="triggerId3">
                                @foreach ($bairros as $bairro)
                                <a class="dropdown-item has-icon" href="{{ route('relatorio.mes.actual',$bairro->uuid) }}">
                                    <i class="fas fa-file-excel"></i>
                                    {{$bairro->name}}
                                </a>
                                @endforeach
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header row">
                    <a href="javascript:;" class="btn btn-primary daterange-btn icon-left btn-icon col-sm-12">
                        <i class="fas fa-calendar"></i>
                        Filtrar resumo por datas
                    </a>
                </div>
                <div class="card-body" id="card_bairros">

                    @foreach ($bairros as $key => $value)
                        <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted"></div>
                            <div class="font-weight-bold mb-1">{{ $value->name }}</div>
                            <div class="progress" data-height="3" style="height: 3px;">
                                <div class="progress-bar" role="progressbar" data-width="80%" aria-valuenow="80"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 80%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="col-sm-12">
                        <h4 class="float-left">Gráfico Resumo.</h4>
                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#filtroRelatorio">
                            <i class="fa fa-chart-line" aria-hidden="true"></i>
                            Usar filtro avançado
                        </button>
                    </div>

                </div>
                <div class="card-body">
                    <canvas id="myChart" height="158"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endpush
@push('cssLibs')
    <link rel="stylesheet" href="{{ asset('backend/prism/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/cropper/cropper.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">

@endpush
@push('jsLibs')
    <script src="{{ asset('backend/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('backend/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/prism/prism.js') }}"></script>
    <script src="{{ asset('backend/cropper/cropper.js') }}"></script>
    <script src="{{ asset('backend/chart/chart.min.js') }}"></script>
    <script src="{{ asset('backend/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('backend/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('backend/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('backend/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
@endpush

@push('js')
    <script>
        "use strict";


     $(document).ready(function () {

         $('#start_date').val(moment().subtract(1, 'month').startOf('month').format('DD-MM-YYYY'));
         $('#end_date').val(moment().subtract(1, 'month').endOf('month').format('DD-MM-YYYY'));


        /***
         *@author Nelson Mutane
         * */

         var myChart = document.getElementById("myChart").getContext('2d');
            chart(myChart,[], []);

        $('#daterange-cus').daterangepicker({
            ranges: {
                'Hoje': [moment(), moment()],
                'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                'Este Mês': [moment().startOf('month'), moment().endOf('month')],
                'Mês Passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')]
            },
            startDate: moment().subtract(1, 'month').startOf('month'),
            endDate: moment().subtract(1, 'month').endOf('month'),
            locale: {
                format: 'DD-MM-YYYY'
            },
            drops: 'down',
            opens: 'right'
        },function(start,end){
            $('#start_date').val(start.format('DD-MM-YYYY'));
            $('#end_date').val(end.format('DD-MM-YYYY'))
        });
        $('.daterange-btn').daterangepicker({
            ranges: {
                'Hoje': [moment(), moment()],
                'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                'Este Mês': [moment().startOf('month'), moment().endOf('month')],
                'Mês Passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        }, function(start, end) {
            $.ajax({
                type: "get",
                url: "{{ url('/filtered_data') }}/" + start.format('DD-MM-Y') + "/" + end.format(
                    'DD-MM-Y'),
                data: "data",
                dataType: "json",
                success: function(response) {
                    chart(myChart,response.keys, response.values)
                    const object = response.data;
                    var cardData = '';
                    for (const key in object) {
                        if (Object.hasOwnProperty.call(object, key)) {
                            const element = object[key];
                            if (key != 0 ) {
                            cardData += '<div class="mb-4">' +
                                '<div class="text-small float-right font-weight-bold text-muted">' +
                                element + '</div>' +
                                '<div class="font-weight-bold mb-1">' + key + '</div>' +
                                '<div class="progress" data-height="3" style="height: 3px;">' +
                                '<div class="progress-bar" role="progressbar" data-width="80%"' +
                                'aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">' +
                                '</div></div></div>';
                        }}
                    }

                    $('#card_bairros').empty();
                    $(cardData).appendTo('#card_bairros');
                    console.log(cardData);
                    console.log(myChart);
                },
                error: function(err) {
                    console.log(err);
                }
            });

            console.log(start.format('DD-MM-Y') + ";" + end.format('DD-MM-Y'));
            $('.daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        });
        $(".colorpickerinput").colorpicker({
            format: 'hex',
            component: '.input-group-append',
        });

        function chart(chart,keys, values) {
            var myChart = new Chart(chart, {
                type: 'line',
                data: {
                    labels: keys,
                    datasets: [{
                            label: 'Benificiarios atendidos',
                            data: values,
                            borderWidth: 2,
                            backgroundColor: 'rgba(254,86,83,.7)',
                            borderWidth: 0,
                            borderColor: 'transparent',
                            pointBorderWidth: 0,
                            pointRadius: 3.5,
                            pointBackgroundColor: 'transparent',
                            pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
                        },

                    ]
                },
                options: {
                    legend: {
                        display: true
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                drawBorder: false,
                                color: '#f2f2f2',
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 50,
                                callback: function(value, index, values) {
                                    return '' + value;
                                }
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: true,
                                tickMarkLength: 15,
                            }
                        }]
                    },
                }
            });
        }

        $('#filterByFilter').on('click', function (e) {
            console.log($('#filterForm').serialize());
            $.ajax({
                type: "post",
                url: "{{ url('/filtered_data') }}" ,
                data: $('#filterForm').serialize(),
                dataType: "json",
                success: function(response) {

                    console.log(response);

                    chart(myChart ,response.keys, response.values)
                    const object = response.data;
                    var cardData = '';
                    for (const key in object) {
                        if (Object.hasOwnProperty.call(object, key)) {
                            const element = object[key];
                            if (key != 0 ) {


                            cardData += '<div class="mb-4">' +
                                '<div class="text-small float-right font-weight-bold text-muted">' +
                                element + '</div>' +
                                '<div class="font-weight-bold mb-1">' + key + '</div>' +
                                '<div class="progress" data-height="3" style="height: 3px;">' +
                                '<div class="progress-bar" role="progressbar" data-width="80%"' +
                                'aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">' +
                                '</div></div></div>';
                            } }
                    }

                    $('#card_bairros').empty();
                    $(cardData).appendTo('#card_bairros');

                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    });
    </script>
@endpush

@section('modals')
    <div class="modal fade" tabindex="-1" role="dialog" id="filtroRelatorio">
        <div class="modal-dialog modal-lg w-70" role="document" style="width: 70% !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Baixar o relatório por filtro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('relatorio.filtro') }}" method="post"  id="filterForm">
                    @csrf
                    <div class="modal-body">
                        <div class="container form-group row">

                          <div class="form-group col-lg-4">
                            <label for="">Período</label>
                            <input type="hidden" name="start_date" id="start_date">
                            <input type="hidden" name="end_date" id="end_date">
                            <input type="text" name="period" id="daterange-cus" class="form-control " placeholder="Período" aria-describedby="helpId">
                          </div>


                          <div class="form-group col-lg-4">
                            <label for="">Frequência</label>
                            <select  multiple class="form-control selectric" name="number_of_visits[]" id="number_of_visits">
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5⁺</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-4">
                            <label for="Problema resolvido">Problema resolvido</label>
                            <select multiple class="form-control selectric" name="status[]" id="status">
                              <option value="1">Sim</option>
                              <option value="0">Não</option>
                            </select>
                          </div>

                           <div class="form-group col-lg-4">
                             <label for="">Bairro</label>
                             <select class="form-control selectric w-100" name="neighborhood_uuid[]" multiple>
                               @foreach ($bairros as $bairro)
                                <option value="{{$bairro->uuid}}">{{$bairro->name}}</option>
                               @endforeach
                             </select>
                           </div>
                           <div class="form-group col-lg-4">
                            <label for="">Genero</label>
                            <select class="form-control selectric w-100" name="genre_uuid[]" multiple>
                              @foreach ($generos as $genero)
                               <option value="{{$genero->uuid}}">{{$genero->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-lg-4 row mx-0 justify-content-between">
                            <label for="" class="col-lg-12">Faixa etária</label>
                            <input type="text" name="minAge"  class="form-control col-lg-5" placeholder="Min" >
                            <input type="text" name="maxAge"  class="form-control col-lg-5" placeholder="Max" >

                        </div>




                          <div class="form-group col-lg-6">
                            <label for="">Proviniência</label>
                            <select   class="form-control selectric w-100" name="provenace_uuid[]" multiple >
                              @foreach ($proviniencias as $proviniencia)
                               <option value="{{$proviniencia->uuid}}">{{$proviniencia->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-lg-6">
                            <label for="">Razão de visita</label>
                            <select class="form-control selectric w-100" name="purpose_of_visit_uuid[]" multiple>
                              @foreach ($razoes_das_visitas as $razoes_das_visita)
                               <option value="{{$razoes_das_visita->uuid}}">{{$razoes_das_visita->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-lg-6">
                            <label for="">Motivo de Abertura do Processo</label>
                            <select class="form-control selectric w-100" name="reason_opening_case_uuid[]" multiple>
                              @foreach ($motivos_de_abertura_de_processos as $motivos_de_abertura_de_processo)
                               <option value="{{$motivos_de_abertura_de_processo->uuid}}">{{$motivos_de_abertura_de_processo->name}}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="form-group col-lg-6">
                            <label for="">Serviço encaminhado</label>
                            <select class="form-control selectric w-100" name="forwarded_service_uuid[]" multiple>
                              @foreach ($servicos_encaminhados as $servicos_encaminhado)
                               <option value="{{$servicos_encaminhado->uuid}}">{{$servicos_encaminhado->name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal" id="filterByFilter">Ver Gráfico</button>
                        <button type="submit" class="btn btn-success">Baixar relatório</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


