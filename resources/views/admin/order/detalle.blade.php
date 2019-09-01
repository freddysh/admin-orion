@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">ORDENES</a></li>
<li class="breadcrumb-item active" aria-current="page">DETALLE</li>

@endsection
@section('content')
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-header">
                    <b>Datos del cliente</b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <b>Cliente:</b> {{ $order->full_name }}</br>
                            <b>Celular:</b> {{ $order->phone }}</br>
                            <b>Email:</b> {{ $order->email }}</br>
                            <b class="text-primary">Notas:</b> {{ $order->notes }}
                        </div>
                        <div class="col-6">
                            <b>Departanento:</b> {{ $order->departament }}</br>
                            <b>Provincia:</b> {{ $order->province }}</br>
                            <b>Distrito:</b> {{ $order->distrite }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="card">
                <div class="card-header">
                    <b>Total</b>
                </div>
                <div class="card-body">
                    @php
                        $total=0;
                    @endphp
                    @if ($order->order_products)
                        @foreach ($order->order_products as $order_product)
                            @php
                                $total+=$order_product->quality*$order_product->pu;
                            @endphp
                        @endforeach
                    @endif
                    <b class="text-success text-20"><sup>S/.{{ number_format($total+$order->tax,2) }}</sup></b>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <b>Detalle de la orden</b>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr class="bg-secondary text-white mb-0">
                                <th style="width:10%">CANTIDAD</th>
                                <th style="width:50%">PRODUCTO</th>
                                <th style="width:10%">P.U.</th>
                                <th style="width:10%">TOTAL</th>
                                <th style="width:20%">OPERACIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total=0;
                            @endphp
                            @if ($order->order_products)
                                @foreach ($order->order_products as $order_product)
                                @php
                                $total+=$order_product->quality*$order_product->pu;
                                @endphp
                                <tr>
                                    <td>{{ $order_product->quality }}</td>
                                    <td class="text-left">
                                    {{ $order_product->product_id}}
                                    </td>
                                    <td class="text-right">{{ number_format($order_product->pu,2)}}
                                        {{-- <input type="hidden" id="estado_actividad_{{ $actividad->id }}" value="{{ $actividad->estado }}">
                                        <select name="estados" id="confirmar_actividad_{{ $actividad->id }}" class="form-control" onchange="confirmar_('actividad','{{ $actividad->id }}',$('#estado_actividad_{{ $actividad->id }}').val(),$(this).val())">
                                            <option value="0" @if($actividad->estado==0) selected @endif>Pendiente</option>
                                            <option value="1" @if($actividad->estado==1) selected @endif>Confirmar</option>
                                            <option value="2" @if($actividad->estado==2) selected @endif>Anular</option>
                                        </select> --}}
                                    </td>
                                    <td class="text-right">{{ number_format($order_product->quality*$order_product->pu,2)}}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td colspan="3"><b>SUB TOTAL</b></td>
                                <td class="text-right"><b>{{number_format($total,2) }}</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>TAX</b></td>
                                <td class="text-right"><b>{{ number_format($order->tax,2) }}</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>TOTAL</b></td>
                                <td class="text-right"><b>{{ number_format($total+$order->tax,2) }}</b></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
