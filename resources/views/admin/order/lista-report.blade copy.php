@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">ORDENES</a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="{{route('reserva.lista')}}">REPORT</a></li>

@endsection
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="row">
    <div class="col">
        <form action="{{ route('ordenes.lista.post.report') }}" method="post">
            <div class="row">
                <div class="col">
                    <label class="sr-only" for="fecha_ini">Desde</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Desde</div>
                        </div>
                        <input type="date" class="form-control" id="fecha_ini" name="desde" value="{{ $f1 }}" required>
                    </div>
                </div>
                <div class="col">
                    <label class="sr-only" for="fecha_hasta">Hasta</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Hasta</div>
                        </div>
                        <input type="date" class="form-control" id="fecha_hasta" name="hasta" value="{{ $f2 }}" required>
                    </div>
                </div>
                <div class="col">
                    @csrf
                    <button type="submit" class="btn btn-primary"><i class="fas fa-calendar"></i> Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>CODIGO</th>
                    <th>CLIENTE</th>
                    <th>ORDENADO</th>
                    <th>PROCESADO</th>
                    <th>MONTO</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total=0;
                    $i=0;
                @endphp
                    @foreach ($orders->sortBy('processed_date') as $item)
                    @php
                        $fecha_actual=new Carbon();
                        $fecha_actual->subHour(5);
                        $fecha_procesado = Carbon::parse($item->processed_date);
                        $fecha_ordenado = Carbon::parse($item->pending_date);
                        $nroDias=$fecha_actual->diffInDays($fecha_procesado,true);
                        $nroDiasOrdenado=$fecha_actual->diffInDays($fecha_ordenado,true);
                        $total_soles=0;
                        $i++;
                    @endphp
                    @foreach ($item->order_products as $product)
                        @php
                            $total_soles+=$product->quality*$product->pu;
                        @endphp
                    @endforeach
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $fecha_ordenado->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $fecha_procesado->format('d-m-Y H:i:s') }}</td>
                        <td><sup>S/.</sup>{{ number_format($total_soles+$item->tax,2) }}</td>
                    </tr>
                    @php
                        $total+=$total_soles+$item->tax;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="5"><b>TOTAL</b></td>
                    <td><b><sup>S/.</sup>{{ number_format($total,2) }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


@endsection
