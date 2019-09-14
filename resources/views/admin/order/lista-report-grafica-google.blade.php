@php
    use Khill\Lavacharts\Lavacharts;
@endphp
@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">ORDENES</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{route('reserva.lista')}}">REPORT</a></li>

@endsection
@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="row">
    <div class="col">
        <label class="sr-only" for="tipo_filtro">Filtrar por</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-filter"></i>
                </div>
            </div>
            <select class="form-control" name="filtro" id="filtro" onchange="mostrar_filtro_report_grafica($(this).val())">
                <option value="Por-anio" @if($opcion=='por-anio') selected @endif>Por años</option>
                <option value="Por-meses" @if($opcion=='por-mes') selected @endif>Por meses</option>
            </select>
        </div>
    </div>
    <div class="col @if($opcion=='por-anio') d-none @endif" id="f_anio_mes">
        <form action="{{ route('ordenes.lista.report.grafica-post') }}" method="post">
            <div class="row">
                <div class="col">
                    <label class="sr-only" for="anio_mes_anio">Anio</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Anio</div>
                        </div>
                        <select class="form-control" id="anio_mes_anio" name="anio">
                            @foreach ($anio_ as $item)
                                <option value="{{ $item }}" @if (date("Y")==$item) selected @endif>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <label class="sr-only" for="anio_mes_mes">Mes</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Mes</div>
                        </div>
                        <select class="form-control" name="mes" id="anio_mes_mes">
                            <option value="01" @if($opcion=='por-mes')  @if($mes=='01') selected @endif @endif>Enero</option>
                            <option value="02" @if($opcion=='por-mes')  @if($mes=='02') selected @endif @endif>Febrero</option>
                            <option value="03" @if($opcion=='por-mes')  @if($mes=='03') selected @endif @endif>Marzo</option>
                            <option value="04" @if($opcion=='por-mes')  @if($mes=='04') selected @endif @endif>Abril</option>
                            <option value="05" @if($opcion=='por-mes')  @if($mes=='05') selected @endif @endif>Mayo</option>
                            <option value="06" @if($opcion=='por-mes')  @if($mes=='06') selected @endif @endif>Junio</option>
                            <option value="07" @if($opcion=='por-mes')  @if($mes=='07') selected @endif @endif>Julio</option>
                            <option value="08" @if($opcion=='por-mes')  @if($mes=='08') selected @endif @endif>Agosto</option>
                            <option value="09" @if($opcion=='por-mes')  @if($mes=='09') selected @endif @endif>Septiembre</option>
                            <option value="10" @if($opcion=='por-mes')  @if($mes=='10') selected @endif @endif>Octubre</option>
                            <option value="11" @if($opcion=='por-mes')  @if($mes=='11') selected @endif @endif>Noviembre</option>
                            <option value="12" @if($opcion=='por-mes')  @if($mes=='12') selected @endif @endif>Diciembre</option>
                        </select>
                        <div class="input-group-prepend">
                                @csrf
                            <button class="btn btn-primary" type="submit" name="opcion" value="por_mes"> <i class="fas fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col @if($opcion=='por-mes') d-none @endif" id="f_anio">
        <form action="{{ route('ordenes.lista.report.grafica-post') }}" method="post">
            <label class="sr-only" for="anio_anio">Anio</label>
            <div class="input-group">
                <div class="input-group-prepend">
                <div class="input-group-text">Anio</div>
                </div>
                <select class="form-control" id="anio_anio" name="anio">
                    @foreach ($anio_ as $item)
                        <option value="{{ $item }}" @if (date("Y")==$item) selected @endif>{{ $item }}</option>
                    @endforeach
                </select>
                <div class="input-group-prepend">
                    @csrf
                    <button class="btn btn-primary" type="submit" name="opcion" value="por_anio"> <i class="fas fa-search"></i> Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="chart_div"></div>
<script type="text/javascript">
$( document ).ready(function() {
    google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawTrendlines);

function drawTrendlines() {
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', 'Pedidos');
      data.addColumn('number', 'Ventas');
      data.addRows([
        @foreach($arreglo as $key => $fila)
        [{{ $key }}, {{ $fila['pedidos'] }}, {{ $fila['ventas'] }}],
        @endforeach
    ]);

      var options = {
        hAxis: {
          title: 'Mes'
        },
        vAxis: {
          title: 'Soles'
        },
        colors: ['#AB0D06', '#007329'],
        trendlines: {
          0: {type: 'exponential', color: '#333', opacity: 1}
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
});
</script>

@endsection
