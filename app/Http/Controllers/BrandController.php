<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    //
    public function getMarca(){
        $brands =Brand::all();
        return view('admin.marca.lista',compact('brands'));
    }
    public function nuevo(){
        return view('admin.marca.nuevo');
    }
    public function store(Request $request){
        $nombre=$request->input('nombre');
        // $state=$request->input('state');
        $existencias=brand::where('name',$nombre)->count();

        if($existencias>0){
            return redirect()->back()->with('error','La marca ya existe')->withInput();
        }
        else{
            $brand=new Brand();
            $brand->name=$nombre;
            $brand->state=1;
            $brand->save();
            // Alert()->success('Datos guardados.')->autoclose(3000);
            return redirect()->route('marca_nuevo_path')->with('success','Datos guardados');

        }
    }

    public function editar(Request $request){
        $nombre=$request->input('nombre');
        $id=$request->input('id');
        // dd($fotosExistentes);

        $brand=Brand::find($id);
        $brand->name=$nombre;
        $brand->state=1;
        $brand->save();

        return redirect()->route('marca_lista_path')->with('success','Datos editados');
    }
    public function getDelete($id){
        $brand=Brand::find($id);
        $products=Product::where('brand_id',$id)->count('id');
        if($products>0){
            return 2;
        }
        else{
            if($brand->delete())
                return 1;
            else
                return 0;
        }
    }
}
