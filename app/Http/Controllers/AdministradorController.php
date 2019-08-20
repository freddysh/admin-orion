<?php

namespace App\Http\Controllers;

use App\Role;
use App\Asociacion;
use App\Departamento;
use App\User;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    //
    public function get(){
        $administradores = User::get();
        return view('admin.administrador.lista',compact(['administradores']));
    }
    public function nuevo(){
        return view('admin.administrador.nuevo');
    }
    public function editar(Request $request){
        $nombre=$request->input('nombre');
        $id=$request->input('id');
        $celular=$request->input('celular');
        $email=$request->input('email');
        $password=$request->input('password');
        $re_password=$request->input('re_password');
        $estado=$request->input('estado');

        if($password!=$re_password){

            return redirect()->back()->with('error','Las contraseñas no coinciden')->withInput();
        }
        $asociacion=User::find($id);
        $asociacion->name=$nombre;
        $asociacion->celular=$celular;
        $asociacion->email=$email;
        $asociacion->password=bcrypt($password);
        $asociacion->password2=$password;
        $asociacion->state=$estado;
        $asociacion->save();
        $asociacion_role = Role::where('name', 'admin')->first();

        $asociacion->roles()->detach($asociacion_role);
        $asociacion->roles()->attach($asociacion_role);
        return redirect()->route('administrador_lista_path')->with('success','Datos editados');
    }
    public function store(Request $request){
        $nombre=$request->input('nombre');
        $celular=$request->input('celular');
        $email=$request->input('email');
        $password=$request->input('password');
        $re_password=$request->input('re_password');
        $estado=$request->input('estado');

        if(trim($password)!=trim($re_password)){
            return redirect()->back()->with('error','las contraseñas no coinciden, vuelva a ingresar los datos')->withInput();
        }
        $existencias=User::where('email',$email)->count();
        if($existencias>0){
            return redirect()->back()->with('error','El usuario con email '.$email.' ya existe')->withInput();
        }
        else{
            $user=new User();
            $user->name=$nombre;
            $user->celular=$celular;
            $user->email=$email;
            $user->password=bcrypt($password);
            $user->password2=$password;
            $user->state=$estado;
            $user->save();
            //le asignamos un rol "asociacion"
            $user_role = Role::where('name', 'admin')->first();
            $user->roles()->attach($user_role);
            return redirect()->route('administrador_nuevo_path')->with('success','Datos guardados');

        }
    }
    public function getDelete($id){

        $user=User::find($id);
        $user_role = Role::where('name', 'admin')->first();
        $user->roles()->detach($user_role);

        if($user->delete())
            return 1;
        else
            return 0;
    }
}
