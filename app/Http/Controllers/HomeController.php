<?php

namespace App\Http\Controllers;

use App\Distrito;
use App\Comunidad;
use App\Provincia;
use App\Departamento;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
//    public function inicio()
//    {
//        return view('page.home');
//    }
    public function index(Request $request)
    {
        // $request->user()->authorizeRoles(['user', 'admin','asociacion']);
        // return view('admin.index');

        $request->user()->authorizeRoles(['user', 'admin','asociacion']);
        // $departamentos =Departamento::get();
        // $provincias =Provincia::get();
        // $distritos =Distrito::get();
        // $comunidades = Comunidad::get();
        // return view('admin.index');
        return view('admin.index');
    }

}
