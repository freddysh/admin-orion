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
                            @if ($order_product->state==1)
                                @php
                                    $total+=$order_product->quality*$order_product->pu;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    <b class="text-success text-20"><sup>S/. <span id="total_header">{{ number_format($total+$order->tax,2) }}</span></sup></b>
                    @if ($order->state==0)
                        <button class="btn btn-danger">CANCELADO</button>
                    @elseif ($order->state==1)
                        <button class="btn btn-danger">PENDIENTE</button>
                    @elseif ($order->state==2)
                        <button class="btn btn-primary">DESPACHADO</button>
                    @elseif ($order->state==3)
                        <button class="btn btn-success">PROCESADO</button>
                    @endif
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
                    <div class="row">
                        <div class="col-12">
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
                                            @if ($order_product->state==1)
                                                @php
                                                    $total+=$order_product->quality*$order_product->pu;
                                                @endphp
                                            @endif
                                        <tr>
                                            <td>{{ $order_product->quality }}</td>
                                            <td class="text-left">
                                                @foreach ($products_list->where('id',$order_product->product_id) as $producto)
                                                {{ $producto->category->name }} {{ $producto->brand->name }} {{ $producto->name }}
                                                @endforeach
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
                                            <td>
                                                @if ($order->state==1||$order->state==2)
                                                    <input id="toggle-event_{{ $order_product->id }}" type="checkbox" @if($order_product->state==1) checked @endif data-toggle="toggle" data-on="<i class='fas fa-check-circle'></i>" data-off="<i class='fas fa-times-circle'></i>" data-onstyle="success" data-offstyle="danger" value="{{ number_format($order_product->quality*$order_product->pu,2) }}">
                                                    <div class="d-none" id="console-event_{{ $order_product->id }}"></div>
                                                    <script>
                                                    $(function() {
                                                        $('#toggle-event_{{ $order_product->id }}').change(function() {
                                                        $('#console-event_{{ $order_product->id }}').html('Toggle: ' + $(this).prop('checked'))
                                                        var valor=0;
                                                        var precio=0;
                                                        var sub_total=parseFloat($('#sub_total').html());
                                                        var total_header=parseFloat($('#total_header').html());
                                                        precio=parseFloat($(this).val());
                                                        if($(this).prop('checked')){
                                                            valor=1;
                                                            sub_total+=precio;
                                                            total_header+=precio;
                                                        }
                                                        else{
                                                            sub_total-=precio;
                                                            total_header-=precio;
                                                        }
                                                        var order_product_id={{ $order_product->id }}
                                                        $.ajaxSetup({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        $.ajax({
                                                        type:'POST',
                                                        url:"{{ route('ordenes.editar_orden_product') }}",
                                                        data:{order_product_id:order_product_id,state:valor},
                                                        success:function(data){
                                                            console.log('data:'+data);
                                                            $('#total_header').html(total_header);
                                                            $('#sub_total').html(sub_total);
                                                            $('#total_foot').html(total_header);
                                                        }
                                                        });
                                                        })
                                                    })
                                                    </script>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td colspan="3"><b>SUB TOTAL</b></td>
                                        <td class="text-right"><b><span id="sub_total">{{ number_format($total,2) }}</span></b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><b>TAX</b></td>
                                        <td class="text-right"><b>{{ number_format($order->tax,2) }}</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><b>TOTAL</b></td>
                                        <td class="text-right"><b><span id="total_foot">{{ number_format($total+$order->tax,2) }}</span></b></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-12 text-right">
                            <form action="{{ route('ordenes.acciones_orden_product') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $order->id }}">
                                @if ($order->state==1)
                                <div class="btn btn-group">
                                    <button class="btn btn-primary" name="accion" value="DESPACHAR">DESPACHAR</button>
                                    <button class="btn btn-outline-primary" name="accion" value="CANCELAR">CANCELAR</button>
                                </div>
                                @elseif ($order->state==2)
                                    <div class="btn btn-group">
                                        <button class="btn btn-success" name="accion" value="PROCESAR">PROCESAR</button>
                                        <button class="btn btn-outline-primary" name="accion" value="CANCELAR">CANCELAR</button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
