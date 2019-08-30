<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //
    public function lista($f1,$f2){
        $order_pending=Order::where('estado','1')->get();
        $order_dispatched=Order::where('estado','2')->get();
        $order_processed=Order::where('estado','3')->get();
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

}
