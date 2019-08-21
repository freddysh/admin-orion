<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function getProduct(){
        $products =Product::get();
        return view('admin.product.lista',compact('products'));
    }
    public function nuevo(){
        $categories = Category::get();
        $brands = Brand::get();
        return view('admin.product.nuevo',compact(['categories','brands']));
    }
    public function store(Request $request){
        $nombre=$request->input('nombre');
        $distrito_id=$request->input('distrito');
        $descripcion=$request->input('descripcion');
        $historia=$request->input('historia');
        $altura=$request->input('altura');
        $distancia=$request->input('distancia');
        $portada=$request->file('portada');
        $miniatura=$request->file('miniatura');
        $fotos=$request->file('foto');
        $existencias=Comunidad::where('nombre',$nombre)->count();
        if(trim($distrito_id)==''||trim($distrito_id)=='0'){
            return redirect()->back()->with('error','escoja un departamento, provincia y distrito')->withInput();
        }
        if($existencias>0){
            return redirect()->back()->with('error','La comunidada ya existe')->withInput();
        }
        else{
            $comunidad=new Comunidad();
            $comunidad->nombre=$nombre;
            $comunidad->descripcion=$descripcion;
            $comunidad->historia=$historia;
            $comunidad->distrito_id=$distrito_id;
            $comunidad->altura=$altura;
            $comunidad->distancia=$distancia;
            $comunidad->save();
            if(!empty($portada)){
                // foreach($fotos as $foto){
                    $comunidadfoto = new ComunidadFoto();
                    $comunidadfoto->comunidad_id=$comunidad->id;
                    $comunidadfoto->save();

                    $filename ='foto-'.$comunidadfoto->id.'.'.$portada->getClientOriginalExtension();
                    $comunidadfoto->imagen=$filename;
                    $comunidadfoto->estado='1';
                    $comunidadfoto->save();
                    Storage::disk('comunidades')->put($filename,  File::get($portada));
                // }
            }
            if(!empty($miniatura)){
                // foreach($fotos as $foto){
                    $comunidadfoto = new ComunidadFoto();
                    $comunidadfoto->comunidad_id=$comunidad->id;
                    $comunidadfoto->save();

                    $filename ='foto-'.$comunidadfoto->id.'.'.$miniatura->getClientOriginalExtension();
                    $comunidadfoto->imagen=$filename;
                    $comunidadfoto->estado='2';
                    $comunidadfoto->save();
                    Storage::disk('comunidades')->put($filename,  File::get($miniatura));
                // }
            }
            if(!empty($fotos)){
                foreach($fotos as $foto){
                    $comunidadfoto = new ComunidadFoto();
                    $comunidadfoto->comunidad_id=$comunidad->id;
                    $comunidadfoto->save();

                    $filename ='foto-'.$comunidadfoto->id.'.'.$foto->getClientOriginalExtension();
                    $comunidadfoto->imagen=$filename;
                    $comunidadfoto->estado='0';
                    $comunidadfoto->save();
                    Storage::disk('comunidades')->put($filename,  File::get($foto));
                }
            }
            // Alert()->success('Datos guardados.')->autoclose(3000);
            return redirect()->route('comunidad_nuevo_path')->with('success','Datos guardados');

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
        $nombre=$request->input('nombre');
        $id=$request->input('id');
        $distrito_id=$request->input('distrito');
        $descripcion=$request->input('descripcion');
        $historia=$request->input('historia');
        $portada_f=$request->file('portada_f');
        $portada=$request->input('portada');
        $miniatura=$request->input('miniatura');
        $miniatura_f=$request->file('miniatura_f');
        $fotos=$request->file('foto');
        $altura=$request->input('altura');
        $distancia=$request->input('distancia');

        $fotosExistentes=$request->input('fotos_');
        // dd($fotosExistentes);
        if(trim($distrito_id)==''||trim($distrito_id)=='0'){
            return redirect()->back()->with('error','escoja un departamento, provincia y distrito')->withInput();
        }
        $comunidad=Comunidad::find($id);
        $comunidad->nombre=$nombre;
        $comunidad->descripcion=$descripcion;
        $comunidad->historia=$historia;
        $comunidad->distrito_id=$distrito_id;
        $comunidad->altura=$altura;
        $comunidad->distancia=$distancia;
        $comunidad->save();
        // borramos de la db la foto de portada que han sido eliminadas por el usuario
        if(isset($portada)){
            $fotos_existentes=ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','1')->get();
            foreach ($fotos_existentes as $value) {
                # code...
                if($value->id!=$portada){
                    ComunidadFoto::find($value->id)->delete();
                }
            }
        }
        else{
            ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','1')->delete();
        }

        if(!empty($portada_f)){
            ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','1')->delete();
            // foreach($portada_f as $foto){
                $comunidadfoto = new ComunidadFoto();
                $comunidadfoto->comunidad_id=$comunidad->id;
                $comunidadfoto->save();

                $filename ='foto-'.$comunidadfoto->id.'.'.$portada_f->getClientOriginalExtension();
                $comunidadfoto->imagen=$filename;
                $comunidadfoto->estado='1';
                $comunidadfoto->save();
                Storage::disk('comunidades')->put($filename,  File::get($portada_f));
            // }
        }
        // borramos de la db la foto de portada que han sido eliminadas por el usuario
        if(isset($miniatura)){
            $fotos_existentes=ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','2')->get();
            foreach ($fotos_existentes as $value) {
                # code...
                if($value->id!=$miniatura){
                    ComunidadFoto::find($value->id)->delete();
                }
            }
        }
        else{
            ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','2')->delete();
        }

        if(!empty($miniatura_f)){
            ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','2')->delete();
            // foreach($miniatura_f as $foto){
                $comunidadfoto = new ComunidadFoto();
                $comunidadfoto->comunidad_id=$comunidad->id;
                $comunidadfoto->save();

                $filename ='foto-'.$comunidadfoto->id.'.'.$miniatura_f->getClientOriginalExtension();
                $comunidadfoto->imagen=$filename;
                $comunidadfoto->estado='2';
                $comunidadfoto->save();
                Storage::disk('comunidades')->put($filename,  File::get($miniatura_f));
            // }
        }
        // borramos de la db las fotos que han sido eliminadas por el usuario
        if(count((array)$fotosExistentes)>0){
            $fotos_existentes=ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','0')->get();
            foreach ($fotos_existentes as $value) {
                # code...
                if(!in_array($value->id,$fotosExistentes)){
                    ComunidadFoto::find($value->id)->delete();
                }
            }
        }
        else{
            ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','0')->delete();
         }
        if(!empty($fotos)){
            foreach($fotos as $foto){
                $comunidadfoto = new ComunidadFoto();
                $comunidadfoto->comunidad_id=$comunidad->id;
                $comunidadfoto->save();

                $filename ='foto-'.$comunidadfoto->id.'.'.$foto->getClientOriginalExtension();
                $comunidadfoto->imagen=$filename;
                $comunidadfoto->estado='0';
                $comunidadfoto->save();
                Storage::disk('comunidades')->put($filename,  File::get($foto));
            }
        }
        return redirect()->route('comunidad_lista_path')->with('success','Datos editados');
    }
    public function getFoto($filename){
        $file = Storage::disk('comunidades')->get($filename);
        return response($file, 200);
    }
    public function getDelete($id){
        if(Comunidad::destroy($id))
            return 1;
        else
            return 1;
    }
    public function mostrar_pagina($grupo_id,$estado){
        // try {
            //code...

                $temp=Comunidad::find($grupo_id);
                $temp->mostrar_en_pagina=$estado;
                $temp->save();

            if($estado==0){
                $estado_rpt=0;
                $clase_span='badge-success';
                $estado_span='Confirmado';
                $clase_confirmar='btn-danger';
                $estado_confirmar='No mostrar en pagina';
            }
            elseif($estado==1){
                $estado_rpt=1;
                $clase_span='badge-dark';
                $estado_span='Pendiente';
                $clase_confirmar='btn-success';
                $estado_confirmar='Mostrar en pagina';
            }

            return response()->json(['rpt'=>'1',
                                    'estado'=>$estado,
                                    'clase_span'=>$clase_span,
                                    'estado_span'=>$estado_span,
                                    'clase_confirmar'=>$clase_confirmar,
                                    'estado_confirmar'=>$estado_confirmar]);
    }
}
