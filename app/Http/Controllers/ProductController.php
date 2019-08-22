<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\Category;
use App\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    //
    public function getProduct(){
        $products =Product::get();
        $brands = Brand::get();
        $categories = Category::get();
        return view('admin.product.lista',compact('products','brands','categories'));
    }
    public function nuevo(){
        $categories = Category::get();
        $brands = Brand::get();
        return view('admin.product.nuevo',compact(['categories','brands']));
    }
    public function store(Request $request){
        $marca=$request->input('marca');
        $categoria=$request->input('categoria');
        $codigo=$request->input('codigo');
        $nombre=$request->input('nombre');
        $descripcion=$request->input('descripcion');
        $detalle=$request->input('detalle');
        $precio=$request->input('precio');
        $precio_online=$request->input('precio_online');
        $portada=$request->file('portada');
        // $miniatura=$request->file('miniatura');
        $fotos=$request->file('foto');
        $existencias_codigo=Product::where('code',$codigo)->count();
        $existencias_nombre=Product::where('name',$nombre)->count();
        // if(trim($distrito_id)==''||trim($distrito_id)=='0'){
        //     return redirect()->back()->with('error','escoja un departamento, provincia y distrito')->withInput();
        // }
        if($existencias_codigo>0){
            return redirect()->back()->with('error','El producto con codigo '.$codigo.' ya existe')->withInput();
        }
        if($existencias_nombre>0){
            return redirect()->back()->with('error','El producto con nombre '.$nombre.' ya existe')->withInput();
        }
        else{
            $product=new Product();
            $product->brand_id=$marca;
            $product->code=$codigo;
            $product->name=$nombre;
            $product->description=$descripcion;
            $product->detail=$detalle;
            $product->price=$precio;
            $product->price_promo=$precio_online;
            $product->state=1;
            $product->unity_id=0;
            $product->category_id=$categoria;
            $product->save();
            if(!empty($portada)){
                // foreach($fotos as $foto){
                    $productfoto = new ProductPhoto();
                    $productfoto->product_id=$product->id;
                    $productfoto->save();

                    $filename ='foto-'.$productfoto->id.'.'.$portada->getClientOriginalExtension();
                    $productfoto->photo=$filename;
                    $productfoto->state='1';
                    $productfoto->save();
                    Storage::disk('product')->put($filename,  File::get($portada));
                // }
            }
            // if(!empty($miniatura)){
            //     // foreach($fotos as $foto){
            //         $comunidadfoto = new ComunidadFoto();
            //         $comunidadfoto->comunidad_id=$comunidad->id;
            //         $comunidadfoto->save();

            //         $filename ='foto-'.$comunidadfoto->id.'.'.$miniatura->getClientOriginalExtension();
            //         $comunidadfoto->imagen=$filename;
            //         $comunidadfoto->estado='2';
            //         $comunidadfoto->save();
            //         Storage::disk('comunidades')->put($filename,  File::get($miniatura));
            //     // }
            // }
            if(!empty($fotos)){
                foreach($fotos as $foto){
                    $productfoto = new ProductFoto();
                    $productfoto->comunidad_id=$product->id;
                    $productfoto->save();

                    $filename ='foto-'.$productfoto->id.'.'.$foto->getClientOriginalExtension();
                    $productfoto->photo=$filename;
                    $productfoto->state='0';
                    $productfoto->save();
                    Storage::disk('product')->put($filename,  File::get($foto));
                }
            }
            // Alert()->success('Datos guardados.')->autoclose(3000);
            return redirect()->route('product_nuevo_path')->with('success','Datos guardados');

        }
    }
    public function mostrarProvincias(Request $request){

        $categoria_id=$request->categoria_id;
        $producto_id=$request->producto_id;
        if($request->ajax()){
            $provincias = Provincia::where('departamento_id',$request->departamento_id)->get();
            $data = view('admin.comunidad.mostrar-provincias-ajax',compact('provincias','categoria_id','producto_id'))->render();
            return \Response::json(['options'=>$data]);
        }
    }
    public function mostrarDistritos(Request $request){
        if($request->ajax()){
            $distritos = Distrito::where('provincia_id',$request->provincia_id)->get();
            $data = view('admin.comunidad.mostrar-distritos-ajax',compact('distritos'))->render();
            return \Response::json(['options'=>$data]);
        }
    }
    public function editar(Request $request){
        $id=$request->input('id');
        $marca=$request->input('marca');
        $categoria=$request->input('categoria');
        $codigo=$request->input('codigo');
        $nombre=$request->input('nombre');
        $descripcion=$request->input('descripcion');
        $detalle=$request->input('detalle');
        $precio=$request->input('precio');
        $precio_online=$request->input('precio_online');
        $portada_f=$request->file('portada_f');
        $portada=$request->input('portada');
        // $miniatura=$request->input('miniatura');
        // $miniatura_f=$request->file('miniatura_f');
        $fotos=$request->file('foto');
        $fotosExistentes=$request->input('fotos_');
        // dd($fotosExistentes);
        // if(trim($distrito_id)==''||trim($distrito_id)=='0'){
        //     return redirect()->back()->with('error','escoja un departamento, provincia y distrito')->withInput();
        // }
        $product=Product::find($id);
        $product->brand_id=$marca;
        $product->code=$codigo;
        $product->name=$nombre;
        $product->description=$descripcion;
        $product->detail=$detalle;
        $product->price=$precio;
        $product->price_promo=$precio_online;
        $product->category_id=$categoria;
        $product->save();
        // borramos de la db la foto de portada que han sido eliminadas por el usuario
        if(isset($portada)){
            $fotos_existentes=ProductPhoto::where('product_id',$product->id)->where('state','1')->get();
            foreach ($fotos_existentes as $value) {
                # code...
                if($value->id!=$portada){
                    ProductPhoto::find($value->id)->delete();
                }
            }
        }
        else{
            ProductPhoto::where('product_id',$product->id)->where('state','1')->delete();
        }

        if(!empty($portada_f)){
            ProductPhoto::where('product_id',$product->id)->where('state','1')->delete();
            // foreach($portada_f as $foto){
                $comunidadfoto = new ProductPhoto();
                $comunidadfoto->product_id=$product->id;
                $comunidadfoto->save();

                $filename ='foto-'.$comunidadfoto->id.'.'.$portada_f->getClientOriginalExtension();
                $comunidadfoto->photo=$filename;
                $comunidadfoto->state='1';
                $comunidadfoto->save();
                Storage::disk('product')->put($filename,  File::get($portada_f));
            // }
        }
        // borramos de la db la foto de portada que han sido eliminadas por el usuario
        // if(isset($miniatura)){
        //     $fotos_existentes=ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','2')->get();
        //     foreach ($fotos_existentes as $value) {
        //         # code...
        //         if($value->id!=$miniatura){
        //             ComunidadFoto::find($value->id)->delete();
        //         }
        //     }
        // }
        // else{
        //     ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','2')->delete();
        // }

        // if(!empty($miniatura_f)){
        //     ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','2')->delete();
        //     // foreach($miniatura_f as $foto){
        //         $comunidadfoto = new ComunidadFoto();
        //         $comunidadfoto->comunidad_id=$comunidad->id;
        //         $comunidadfoto->save();

        //         $filename ='foto-'.$comunidadfoto->id.'.'.$miniatura_f->getClientOriginalExtension();
        //         $comunidadfoto->imagen=$filename;
        //         $comunidadfoto->estado='2';
        //         $comunidadfoto->save();
        //         Storage::disk('comunidades')->put($filename,  File::get($miniatura_f));
        //     // }
        // }
        // borramos de la db las fotos que han sido eliminadas por el usuario
        // if(count((array)$fotosExistentes)>0){
        //     $fotos_existentes=ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','0')->get();
        //     foreach ($fotos_existentes as $value) {
        //         # code...
        //         if(!in_array($value->id,$fotosExistentes)){
        //             ComunidadFoto::find($value->id)->delete();
        //         }
        //     }
        // }
        // else{
        //     ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','0')->delete();
        //  }
        if(!empty($fotos)){
            foreach($fotos as $foto){
                $comunidadfoto = new ProductPhoto();
                $comunidadfoto->product_id=$product->id;
                $comunidadfoto->save();

                $filename ='foto-'.$comunidadfoto->id.'.'.$foto->getClientOriginalExtension();
                $comunidadfoto->photo=$filename;
                $comunidadfoto->state='0';
                $comunidadfoto->save();
                Storage::disk('product')->put($filename,  File::get($foto));
            }
        }
        return redirect()->route('product_lista_path')->with('success','Datos editados');
    }
    public function getFoto($filename){
        $file = Storage::disk('product')->get($filename);
        return response($file, 200);
    }
    public function getDelete($id){
        if(Product::destroy($id))
            return 1;
        else
            return 1;
    }
    public function mostrar_pagina($grupo_id,$estado){
        // try {
            //code...

                $temp=Product::find($grupo_id);
                $temp->state=$estado;
                $temp->save();

            if($estado==0){
                $estado_rpt=0;
                $clase_span='badge-success';
                $estado_span='Confirmado';
                $clase_confirmar='btn-danger';
                $estado_confirmar='<i class="fas fa-eye-slash"></i>';
            }
            elseif($estado==1){
                $estado_rpt=1;
                $clase_span='badge-dark';
                $estado_span='Pendiente';
                $clase_confirmar='btn-success';
                $estado_confirmar='<i class="fas fa-eye"></i>';
            }

            return response()->json(['rpt'=>'1',
                                    'estado'=>$estado,
                                    'clase_span'=>$clase_span,
                                    'estado_span'=>$estado_span,
                                    'clase_confirmar'=>$clase_confirmar,
                                    'estado_confirmar'=>$estado_confirmar]);
    }
}
