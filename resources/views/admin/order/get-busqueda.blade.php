
@php
use Carbon\Carbon;
@endphp
@if (count($orders->where('state','1'))>0)
    <div class="col border border-danger">
        <div class="row">
            <div class="col-12">
                @foreach ($orders->where('state','1')->sortBy('pending_date') as $item)
                    @php
                        $fecha_actual=new Carbon();
                        $fecha_actual->subHour(5);
                        $fecha_pending = Carbon::parse($item->pending_date);
                        $fecha_ordenado = Carbon::parse($item->pending_date);
                        $nroDias=$fecha_actual->diffInDays($fecha_pending,true);
                        $nroDiasOrdenado=$fecha_actual->diffInDays($fecha_ordenado,true);
                        $total_soles=0;
                        $clase_advertencia='';
                    @endphp
                    @if ($nroDias<=7)
                        @php
                            $clase_advertencia='bg-advertencia';
                        @endphp
                    @endif
                    @foreach ($item->order_products as $product)
                        @php
                            $total_soles+=$product->quality*$product->pu;
                        @endphp
                    @endforeach
                    <div class="row reserva-caja {{ $clase_advertencia}}">
                        <div class="col-9 px-1 text-left">
                            <a href="{{ route('ordenes.detalle',$item->id) }}" class=" text-decoration-none text-15">
                                <b class="text-primary">{{ $item->full_name }}</b>
                            </a>
                            {{-- @if($item->estado=='2')
                                <span class="badge badge-danger text-11">Reserva cancelada !</span>
                            @endif --}}
                        </div>
                        <div class="col-3 px-1 text-right">
                            <sup>S/.</sup> {{number_format($total_soles+$item->tax,2) }}
                        </div>
                        <div class="col-8 px-1 text-left">Pendinte
                            <i class="fas fa-calendar"></i> {{ $fecha_llegada_->format('d-m-Y H:i:s') }}
                        </div>
                        <div class="col-4 px-1 text-right">
                            Hace {{ $nroDias }} dias
                        </div>
                        <div class="col-8 px-1 bg-dark text-white text-left">Ordenado
                            <i class="fas fa-calendar"></i> {{ $fecha_ordenado->format('d-m-Y H:i:s') }}
                        </div>
                        <div class="col-4 px-1 bg-dark text-white text-right">
                            Hace {{ $nroDiasOrdenado }} dias
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@if (count($orders->where('state','2'))>0)
<div class="col border border-primary">
        <div class="row bg-primary">
            <div class="col-4 px-0 pt-2 text-center"><b class="text-white">DESPACHADO</b></div>
            <div class="col-8 px-0 d-none">
                <select class="form-control" name="filtro" id="filtro" onchange="filtro_reserva($(this).val(),'nuevo')">
                    <option value="codigo">Codigo</option>
                    <option value="nombre">Nombre</option>
                    <option value="fechas">Entre fechas</option>
                    <option value="mes_anio">mm-aaaa</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @foreach ($orders->where('state','2')->sortBy('dispatched_date') as $item)
                    @php
                        $fecha_actual=new Carbon();
                        $fecha_actual->subHour(5);
                        $fecha_despachado = Carbon::parse($item->dispatched_date);
                        $fecha_ordenado = Carbon::parse($item->pending_date);
                        $nroDias=$fecha_actual->diffInDays($fecha_despachado,true);
                        $nroDiasOrdenado=$fecha_actual->diffInDays($fecha_ordenado,true);
                        $total_soles=0;
                        $clase_advertencia='';
                    @endphp
                    @if ($nroDias<=7)
                        @php
                            // $clase_advertencia='bg-advertencia';
                            $clase_advertencia='';
                        @endphp
                    @endif
                    @foreach ($item->order_products as $product)
                        @php
                            $total_soles+=$product->quality*$product->pu;
                        @endphp
                    @endforeach
                    <div class="row reserva-caja {{ $clase_advertencia}}">
                        <div class="col-9 px-1 text-left">
                            <a href="{{ route('ordenes.detalle',$item->id) }}" class=" text-decoration-none text-15">
                                <b class="text-primary">{{ $item->full_name }}</b>
                            </a>
                            {{-- @if($item->estado=='2')
                                <span class="badge badge-danger text-11">Reserva cancelada !</span>
                            @endif --}}
                        </div>
                        <div class="col-3 px-1 text-right">
                            <sup>S/.</sup> {{number_format($total_soles+$item->tax,2) }}
                        </div>
                        <div class="col-8 px-1 text-left">Despachado
                            <i class="fas fa-calendar"></i> {{ $fecha_despachado->format('d-m-Y H:i:s') }}
                        </div>
                        <div class="col-4 px-1 text-right">
                            Hace {{ $nroDias }} dias
                        </div>
                        <div class="col-8 bg-dark text-white px-1 text-left">Ordenado
                            <i class="fas fa-calendar"></i> {{ $fecha_ordenado->format('d-m-Y H:i:s') }}
                        </div>
                        <div class="col-4 bg-dark text-white px-1 text-right">
                            Hace {{ $nroDiasOrdenado }} dias
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@if (count($orders->where('state','3'))>0)
<div class="col border border-success">
        <div class="row bg-success">
            <div class="col-4 px-0 pt-2 text-center"><b class="text-white">PROCESADO</b></div>
            <div class="col-8 px-0 d-none">
                <select class="form-control" name="filtro" id="filtro" onchange="filtro_reserva($(this).val(),'nuevo')">
                    <option value="codigo">Codigo</option>
                    <option value="nombre">Nombre</option>
                    <option value="fechas">Entre fechas</option>
                    <option value="mes_anio">mm-aaaa</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @foreach ($orders->where('state','3')->sortBy('processed_date') as $item)
                    @php
                        $fecha_actual=new Carbon();
                        $fecha_actual->subHour(5);
                        $fecha_procesado = Carbon::parse($item->processed_date);
                        $fecha_ordenado = Carbon::parse($item->pending_date);
                        $nroDias=$fecha_actual->diffInDays($fecha_procesado,true);
                        $nroDiasOrdenado=$fecha_actual->diffInDays($fecha_ordenado,true);
                        $total_soles=0;
                        $clase_advertencia='';
                    @endphp
                    @if ($nroDias<=7)
                        @php
                            $clase_advertencia='';
                        @endphp
                    @endif
                    @foreach ($item->order_products as $product)
                        @php
                            $total_soles+=$product->quality*$product->pu;
                        @endphp
                    @endforeach
                    @if ($nroDias<=7)
                        <div class="row reserva-caja">
                            <div class="col-9 px-1 text-left">
                                <a href="{{ route('ordenes.detalle',$item->id) }}" class=" text-decoration-none text-15">
                                    <b class="text-primary">{{ $item->full_name }}</b>
                                </a>
                                {{-- @if($item->estado=='2')
                                    <span class="badge badge-danger text-11">Reserva cancelada !</span>
                                @endif --}}
                            </div>
                            <div class="col-3 px-1 text-right">
                            <sup>S/.</sup> {{number_format($total_soles+$item->tax,2) }}
                            </div>
                            <div class="col-8 px-1 text-left">Procesado
                                <i class="fas fa-calendar"></i> {{ $fecha_procesado->format('d-m-Y H:i:s') }}
                            </div>
                            <div class="col-4 px-1 text-right">
                                Hace {{ $nroDias }} dias
                            </div>
                            <div class="col-8 bg-dark text-white px-1 text-left">Ordenado
                                <i class="fas fa-calendar"></i> {{ $fecha_ordenado->format('d-m-Y H:i:s') }}
                            </div>
                            <div class="col-4 bg-dark text-white px-1 text-right">
                                Hace {{ $nroDiasOrdenado }} dias
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
@if (count($orders->where('state','0'))>0)
<div class="col border border-danger">
        <div class="row bg-danger">
            <div class="col-4 pt-2 text-left"><b class="text-white">CANCELADO</b></div>
            <div class="col-8 px-0 d-none">
                <select class="form-control" name="filtro" id="filtro" onchange="filtro_reserva($(this).val(),'nuevo')">
                    <option value="codigo">Codigo</option>
                    <option value="nombre">Nombre</option>
                    <option value="fechas">Entre fechas</option>
                    <option value="mes_anio">mm-aaaa</option>
                </select>
            </div>
        </div>
        <div class="row  d-none">
            <div id="codigo_nuevo" class="col-12 px-0">
                <div class="input-group px-0 mx-0">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Codigo</div>
                    </div>
                    <input type="text" class="form-control" id="codigo" placeholder="Codigo">
                </div>
            </div>
            <div id="nombre_nuevo" class="col-12 px-0 d-none">
                <div class="input-group px-0 mx-0">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Codigo</div>
                    </div>
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                </div>
            </div>
            <div id="fechas_nuevo" class="col-12 px-0 form-inline d-none">
                <div class="input-group px-0 mx-0">
                    <div class="input-group-prepend">
                        <div class="input-group-text">D</div>
                    </div>
                    <input type="date" class="form-control" id="codigo" placeholder="Codigo">
                    <div class="input-group-prepend">
                        <div class="input-group-text">H</div>
                    </div>
                    <input type="date" class="form-control" id="codigo" placeholder="Codigo">
                </div>
            </div>
            <div id="mes_anio_nuevo" class="col-12 px-0 d-none">
                <div class="input-group px-0 mx-0">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Mes</div>
                    </div>
                    <input type="text" class="form-control" id="mes" placeholder="mm">
                    <div class="input-group-prepend">
                            <div class="input-group-text">Año</div>
                    </div>
                    <input type="text" class="form-control" id="anio" placeholder="aaaa">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @foreach ($orders->where('state','0')->sortBy('canceled_date') as $item)
                    @php
                        $fecha_actual=new Carbon();
                        $fecha_actual->subHour(5);
                        $fecha_cancelado = Carbon::parse($item->canceled_date);
                        $fecha_ordenado = Carbon::parse($item->pending_date);
                        $nroDias=$fecha_actual->diffInDays($fecha_cancelado,true);
                        $nroDiasOrdenado=$fecha_actual->diffInDays($fecha_ordenado,true);
                        $total_soles=0;
                        $clase_advertencia='';
                    @endphp
                    @if ($nroDias<=7)
                        @php
                            $clase_advertencia='';
                        @endphp
                    @endif
                    @foreach ($item->order_products as $product)
                        @php
                            $total_soles+=$product->quality*$product->pu;
                        @endphp
                    @endforeach
                    @if ($nroDias<=7)
                        <div class="row reserva-caja">
                            <div class="col-9 px-1 text-left">
                                <a href="{{ route('ordenes.detalle',$item->id) }}" class=" text-decoration-none text-15">
                                    <b class="text-primary">{{ $item->full_name }}</b>
                                </a>
                                {{-- @if($item->estado=='2')
                                    <span class="badge badge-danger text-11">Reserva cancelada !</span>
                                @endif --}}
                            </div>
                            <div class="col-3 px-1 text-right">
                            <sup>S/.</sup> {{number_format($total_soles+$item->tax,2) }}
                            </div>
                            <div class="col-8 px-1 text-left">Cancelado
                                <i class="fas fa-calendar"></i> {{ $fecha_cancelado->format('d-m-Y H:i:s') }}
                            </div>
                            <div class="col-4 px-1 text-right">
                                Hace {{ $nroDias }} dias
                            </div>
                            <div class="col-8 bg-dark text-white px-1 text-left">Ordenado
                                <i class="fas fa-calendar"></i> {{ $fecha_ordenado->format('d-m-Y H:i:s') }}
                            </div>
                            <div class="col-4 bg-dark text-white px-1 text-right">
                                Hace {{ $nroDiasOrdenado }} dias
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
