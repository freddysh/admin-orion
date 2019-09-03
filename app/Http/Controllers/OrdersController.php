<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderProduct;
use App\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //
    public function lista($f1,$f2){
        $order_pending=Order::where('state','1')->get();
        $order_dispatched=Order::where('state','1')->get();
        $order_processed=Order::where('state','1')->get();
        //'0:cancelled,1:pending,2:dispatched,3:processed'
        return view('admin.order.lista',compact('order_pending','order_dispatched','order_processed'));
    }
    public function lista_post(Request $request){
        // return dd($f1.'_'.$f2);
        $f1=$request->input('desde');
        $f2=$request->input('hasta');
        $operaciones=Reserva::whereBetween('fecha_llegada',[$f1,$f2])->get();
        $proveedores=Proveedor::get();
        return view('admin.operaciones.lista',compact('operaciones','f1','f2','proveedores'));
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
}
