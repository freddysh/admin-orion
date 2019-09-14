<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderProduct;
use App\Product;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;

class OrdersController extends Controller
{
    //
    public function lista(){
        $order_pending=Order::where('state','1')->get();
        $order_dispatched=Order::where('state','2')->get();
        $order_processed=Order::where('state','3')->get();
        //'0:cancelled,1:pending,2:dispatched,3:processed'
        return view('admin.order.lista',compact('order_pending','order_dispatched','order_processed'));
    }
    public function getOrder(Request $request){
        $valor=trim($request->input('valor'));
        // return response()->json([$request->all()]);
        if(trim($valor)!=''){
            $orders=Order::where('full_name','like','%'.$valor.'%')->Orwhere('email','like','%'.$valor.'%')->Orwhere('code','like','%'.$valor.'%')->get();
            // return dd($orders);
            // $reserva=Reserva::where('codigo',$valor)->orwhere('nombre','like',"%$valor%")->get();
            return view('admin.order.get-busqueda',compact('orders'));
        }
    }
    public function lista_report($f1,$f2){
        $orders=Order::whereBetween('processed_date',[$f1,$f2])->where('state','3')->get();
        return view('admin.order.lista-report',compact('orders','f1','f2'));
    }
    public function lista_report_post(Request $request){
        $f1=$request->input('desde');
        $f2=$request->input('hasta');
        return redirect()->route('ordenes.lista.report',[$f1,$f2]);
    }
    public function detalle($order_id){
        $order=Order::findOrFail($order_id);
        $products_list=Product::get();
        return view('admin.order.detalle',compact('order','products_list'));
    }
    public function habilitar(Request $request){
        $order_product_id=$request->input('order_product_id');
        $state=$request->input('state');
        $orderProduct=OrderProduct ::findOrFail($order_product_id);
        $orderProduct->state=$state;
        $orderProduct->save();
    }
    public function acciones(Request $request){
        $accion=$request->input('accion');
        $id=$request->input('id');
        $order=Order::find($id);
        if($accion=='DESPACHAR'){
            $order->state=2;
        }
        elseif($accion=='PROCESAR'){
            $order->state=3;
        }
        elseif($accion=='CANCELAR'){
            $order->state=0;
        }
        $order->save();
        return redirect()->route('ordenes.detalle',$id);
    }
    public function lista_report_grafica($anio){
        $arreglo=[];
        for($i=1;$i<=12;$i++){
            $mes=$i;
            $ultimo_dia='31';
            if($i<10){
                $mes='0'.$i;
            }
            if($i==1||$i==3||$i==5||$i==7||$i==8||$i==10||$i==12){
                $ultimo_dia='31';
            }
            elseif($i==2){
                if($anio%4==0){
                    $ultimo_dia='29';
                }
                else{
                    $ultimo_dia='28';
                }
            }
            else{
                $ultimo_dia='30';
            }

            $orders=Order::whereBetween('processed_date',[$anio.'-'.$mes.'-01',$anio.'-'.$mes.'-'.$ultimo_dia])
                            ->where('state','3')->get();
            $total_=0;
            foreach($orders as $items){
                foreach($items->order_products as $item){
                    if($item->state==1){
                        $total_+=$item->quality*$item->pu;
                    }
                }
                $total_+=$items->tax;
            }
            $arreglo[$i]= array('ultimo_dia'=>$anio.'-'.$mes.'-'.$ultimo_dia,'total'=>$total_);
        }
        //    dd($arreglo);

        $lava = new Lavacharts; // See note below for Laravel

        $temperatures = $lava->DataTable();
        $temperatures->addDateColumn('Date')
                     ->addNumberColumn('Total')
                     ->addRow([$arreglo[1]['ultimo_dia'],$arreglo[1]['total']])
                     ->addRow([$arreglo[2]['ultimo_dia'],$arreglo[2]['total']])
                     ->addRow([$arreglo[3]['ultimo_dia'],$arreglo[3]['total']])
                     ->addRow([$arreglo[4]['ultimo_dia'],$arreglo[4]['total']])
                     ->addRow([$arreglo[5]['ultimo_dia'],$arreglo[5]['total']])
                     ->addRow([$arreglo[6]['ultimo_dia'],$arreglo[6]['total']])
                     ->addRow([$arreglo[7]['ultimo_dia'],$arreglo[7]['total']])
                     ->addRow([$arreglo[8]['ultimo_dia'],$arreglo[8]['total']])
                     ->addRow([$arreglo[9]['ultimo_dia'],$arreglo[9]['total']])
                     ->addRow([$arreglo[10]['ultimo_dia'],$arreglo[10]['total']])
                     ->addRow([$arreglo[11]['ultimo_dia'],$arreglo[11]['total']])
                     ->addRow([$arreglo[12]['ultimo_dia'],$arreglo[12]['total']]);

        $lava->LineChart('Temps', $temperatures, [
            'title' => 'VENTAS DEL ANIO '.$anio
        ]);

        return view('admin.order.lista-report-grafica',compact('lava'));
    }
    public function lista_report_grafica_google($anio){
        $arreglo=[];
        for($i=1;$i<=12;$i++){
            $mes=$i;
            $ultimo_dia='31';
            if($i<10){
                $mes='0'.$i;
            }
            if($i==1||$i==3||$i==5||$i==7||$i==8||$i==10||$i==12){
                $ultimo_dia='31';
            }
            elseif($i==2){
                if($anio%4==0){
                    $ultimo_dia='29';
                }
                else{
                    $ultimo_dia='28';
                }
            }
            else{
                $ultimo_dia='30';
            }

            $orders=Order::whereBetween('processed_date',[$anio.'-'.$mes.'-01',$anio.'-'.$mes.'-'.$ultimo_dia])
                            ->where('state','3')->get();
            $orders_pedidos=Order::whereBetween('processed_date',[$anio.'-'.$mes.'-01',$anio.'-'.$mes.'-'.$ultimo_dia])
                            ->whereIn('state',['1','2','3','0'])->get();
            $ventas=0;
            foreach($orders as $items){
                foreach($items->order_products as $item){
                    if($item->state==1){
                        $ventas+=$item->quality*$item->pu;
                    }
                }
                $ventas+=$items->tax;
            }

            $pedidos=0;
            foreach($orders_pedidos as $items){
                foreach($items->order_products as $item){
                    if($item->state==1){
                        $pedidos+=$item->quality*$item->pu;
                    }
                }
                $pedidos+=$items->tax;
            }
            $arreglo[$i]= array('ultimo_dia'=>$anio.'-'.$mes.'-'.$ultimo_dia,'pedidos'=>$pedidos,'ventas'=>$ventas);
        }

        $anios=Order::where('state','!=','0')->pluck('processed_date');
        $anio_=[];
        foreach($anios as $anio){
            if(!in_array( substr($anio,0,4),$anio_)){
                $anio_[]=substr($anio,0,4);
            }
        }
        $opcion='por-anio';
        return view('admin.order.lista-report-grafica-google',compact('arreglo','anio_','opcion','anio'));
    }
    public function lista_report_grafica_google_($anio,$mes){
        $orders=Order::where('processed_date',$anio.'-'.$mes.'-11')
                            ->where('state','3')->get();
        dd($orders);
        $arreglo=[];
        // for($i=1;$i<=12;$i++){
        //     $mes=$i;
            $ultimo_dia='31';
            // if($mes<10){
            //     $mes='0'.$mes;
            // }
            if($mes==1||$mes==3||$mes==5||$mes==7||$mes==8||$mes==10||$mes==12){
                $ultimo_dia='31';
            }
            elseif($mes==2){
                if($anio%4==0){
                    $ultimo_dia='29';
                }
                else{
                    $ultimo_dia='28';
                }
            }
            else{
                $ultimo_dia='30';
            }

        for($i=1;$i<=$ultimo_dia;$i++){
            $dia=$i;
            if($dia<10){
                $dia='0'.$dia;
            }
            $orders=Order::whereIn('processed_date',[$anio.'-'.$mes.'-'.$dia,$anio.'-'.$mes.'-'.$dia])
                            ->where('state','3')->get();
            $orders_pedidos=Order::whereIn('processed_date',[$anio.'-'.$mes.'-'.$dia,$anio.'-'.$mes.'-'.$dia])
                            ->whereIn('state',['1','2','3','0'])->get();
            $ventas=0;
            foreach($orders as $items){
                foreach($items->order_products as $item){
                    if($item->state==1){
                        $ventas+=$item->quality*$item->pu;
                    }
                }
                $ventas+=$items->tax;
            }

            $pedidos=0;
            foreach($orders_pedidos as $items){
                foreach($items->order_products as $item){
                    if($item->state==1){
                        $pedidos+=$item->quality*$item->pu;
                    }
                }
                $pedidos+=$items->tax;
            }
            $arreglo[$dia]= array('ultimo_dia'=>$anio.'-'.$mes.'-'.$dia,'pedidos'=>$pedidos,'ventas'=>$ventas);
        }

        $anios=Order::where('state','!=','0')->pluck('processed_date');
        $anio_=[];
        foreach($anios as $anio){
            if(!in_array( substr($anio,0,4),$anio_)){
                $anio_[]=substr($anio,0,4);
            }
        }
        $opcion='por-mes';
        dd($arreglo);
        return view('admin.order.lista-report-grafica-google',compact('arreglo','anio_','opcion','anio','mes'));
    }
    public function lista_report_grafica_google_post(Request $request){
        $accion=$request->input('opcion');
        if($accion=='por_anio'){
            $anio=$request->input('anio');
            // dd($anio);
            return redirect()->route('ordenes.lista.report.grafica',$anio);
        }
        elseif($accion=='por_mes'){
            $anio=$request->input('anio');
            $mes=$request->input('mes');
            // dd($anio.'_'.$mes);
            return redirect()->route('ordenes.lista.report.grafica_',[$anio,$mes]);
        }
    }
}
