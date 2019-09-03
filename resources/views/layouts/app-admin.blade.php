<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mietnia') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/funciones.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
</head>
<body>
            <div id="wrapper" class="toggled">

                <!-- Sidebar -->
                @include('layouts.nav')

                <!-- /#sidebar-wrapper -->
                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <div class="row">
                        <div class="col-1 ">
                            <a href="#menu-toggle" id="menu-toggle" class="navbar-brand">
                                <i class="fas fa-bars fa-2x"></i>
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
                        </div>
                        <div class="col-8">
                            <nav  aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @yield('breadcrumb')
                                </ol>
                            </nav>
                        </div>
                        <div class="col-3">
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->email }} <span class="caret"></span>
                                </button>
                                @php
                                    $item=Auth::user();
                                @endphp
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  {{--  <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#asociacionModal_{{ $item->id }}">Editar</a>  --}}
                                  <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#asociacionModal_{{ $item->id }}">Editar</a>
                                  <a class="dropdown-item" href="{{ route('logout') }}"
                                      onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                      {{ __('Cerrar') }}
                                  </a>
                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                  </form>


                                </div>
                              </div>

                        </div>
                    </div>
<!-- Modal -->
<div class="modal fade" id="asociacionModal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('asociacion.editar.modal') }}" method="POST" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @if($item->comunidad_id>0)
                        <div class="form-group col-12">
                            <label for="ruc">Ruc</label>
                            <input type="text" class="form-control" id="ruc" name="ruc" aria-describedby="ruc" placeholder="Ruc" value="{{ $item->ruc }}">
                        </div>
                        @endif
                        <div class="form-group col-12">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombre" placeholder="Nombre comercial" value="{{ $item->nombre }}">
                        </div>
                        @if($item->comunidad_id>0)
                        <div class="form-group col-12">
                            <label for="contacto">Contacto</label>
                            <input type="text" class="form-control" id="contacto" name="contacto" aria-describedby="contacto" placeholder="contacto" value="{{ $item->contacto }}">
                        </div>
                        @endif
                        <div class="form-group col-12">
                            <label for="celular">Celular</label>
                            <input type="text" class="form-control" id="celular" name="celular" aria-describedby="celular" placeholder="Celular" value="{{ $item->celular }}">
                        </div>
                        <div class="form-group col-12">
                            <label for="direccion">Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" aria-describedby="direccion" placeholder="Direccion" value="{{ $item->direccion }}">
                        </div>
                        <div class="form-group col-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="email" value="{{ $item->email }}">
                        </div>
                        <div class="form-group col-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" aria-describedby="password" placeholder="password" value="{{ $item->password_2 }}">
                        </div>
                        <div class="form-group col-6">
                                <label for="password">Re password</label>
                                <input type="password" class="form-control" id="repassword" name="repassword" aria-describedby="password" placeholder="password" value="{{ $item->password_2 }}">
                            </div>
                        @if($item->comunidad_id>0)
                        <div class="form-group col-4">
                            <label for="departamento">Departamento</label>
                            <select class="form-control" name="departamento" id="departamento" onchange="mostrar_provincias_modal($(this).val());">
                                <option value="0">Escoja una opcion</option>

                                    @foreach ($departamentos as $item_)
                                        <option value="{{ $item_->id }}" @if ($item_->id==$item->comunidad->distrito->provincia->departamento_id)
                                            selected
                                        @endif>{{ $item_->departamento }}</option>
                                    @endforeach

                            </select>
                        </div>

                        <div class="form-group col-4">
                            <label for="provincia">Provicia</label>
                            <select class="form-control" name="provincia" id="provincia" onchange="mostrar_distritos_modal($(this).val());">
                                <option value="0">Escoja una opcion</option>
                                @foreach ($provincias->where('departamento_id',$item->comunidad->distrito->provincia->departamento_id) as $item_)
                                    <option value="{{ $item_->id }}" @if ($item_->id==$item->comunidad->distrito->provincia_id)
                                        selected
                                    @endif>{{ $item_->provincia }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="distrito_id" class="form-group col-4">
                            <label for="distrito">Distrito</label>
                            <select class="form-control" name="distrito" id="distrito" onchange="mostrar_comunidades_modal($(this).val(),'{{ $item->id }}');">
                                <option value="0">Escoja una opcion</option>
                                @foreach ($distritos->where('provincia_id',$item->comunidad->distrito->provincia_id) as $item_)
                                    <option value="{{ $item_->id }}" @if ($item_->id==$item->comunidad->distrito_id)
                                        selected
                                    @endif>{{ $item_->distrito }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="distrito_id" class="form-group col-4">
                            <label for="comunidad">comunidad</label>
                            <select class="form-control" name="comunidad" id="comunidad_{{ $item->id }}">
                                <option value="0">Escoja una opcion</option>
                                @foreach ($comunidades->where('distrito_id',$item->comunidad->distrito->id) as $item_)
                                    <option value="{{ $item_->id }}" @if ($item_->id==$item->comunidad->id)
                                        selected
                                    @endif>{{ $item_->nombre }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="row">
                            <div class="col-6">
                                <div class="form-group col-12 text-left">
                                    <p><b>Portada</b></p>
                                    @foreach ($item->fotos->where('estado','1') as $foto)
                                        @if (Storage::disk('asociaciones')->has($foto->imagen))
                                            <figure class="figure m-3" id="{{ $item->id.'_'.$foto->id }}">
                                                <img src="{{ route('asociacion.editar.imagen',$foto->imagen) }}" class="figure-img rounded" alt="A generic" width="200px" height="200px">
                                                <figcaption class="figure-caption text-right mt-0">
                                                    <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('{{ $item->id.'_'.$foto->id }}')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </figcaption>
                                                <input type="hidden" name="portada" value="{{ $foto->id }}">
                                            </figure>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="form-group col-12">
                                    <label for="foto">Foto</label>
                                    <input type="file" name="portada_f" multiple class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group col-12 text-left">
                                    <p><b>Miniatura</b></p>
                                    @foreach ($item->fotos->where('estado','2') as $foto)
                                        @if (Storage::disk('asociaciones')->has($foto->imagen))
                                            <figure class="figure m-3" id="{{ $item->id.'_'.$foto->id }}">
                                                <img src="{{ route('asociacion.editar.imagen',$foto->imagen) }}" class="figure-img rounded" alt="A generic" width="200px" height="200px">
                                                <figcaption class="figure-caption text-right mt-0">
                                                    <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('{{ $item->id.'_'.$foto->id }}')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </figcaption>
                                                <input type="hidden" name="miniatura" value="{{ $foto->id }}">
                                            </figure>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="form-group col-12">
                                    <label for="foto">Foto</label>
                                    <input type="file" name="miniatura_f" multiple class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-12 text-left">
                                    <p><b>Galeria de fotos</b></p>
                                        @foreach ($item->fotos->where('estado','0') as $foto)
                                            @if (Storage::disk('asociaciones')->has($foto->imagen))
                                                <figure class="figure m-3" id="{{ $item->id.'_'.$foto->id }}">
                                                    <img src="{{ route('asociacion.editar.imagen',$foto->imagen) }}" class="figure-img rounded" alt="A generic" width="200px" height="200px">
                                                    <figcaption class="figure-caption text-right mt-0">
                                                        <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('{{ $item->id.'_'.$foto->id }}')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </figcaption>
                                                    <input type="hidden" name="fotos_[]" value="{{ $foto->id }}">
                                                </figure>
                                            @endif
                                        @endforeach
                                </div>
                                <div class="form-group col-12">
                                    <label for="foto">Foto</label>
                                    <input type="file" name="foto[]" multiple class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="descripcion">Descripcion</label>
                            <textarea name="descripcion" id="descripcion" class="form-control descripcion"  cols="30" rows="10" >{{ $item->descripcion }}</textarea>
                        </div>
                        @endif
                    </div>

                </div>
                <div class="modal-footer text-right">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
                    @yield('content')
                </div> <!-- /#page-content-wrapper -->
            </div> <!-- /#wrapper -->
            <!-- Bootstrap core JavaScript -->
            <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap.bundle.min.js"></script> <!-- Menu Toggle Script -->
            <script>
              $(function(){
                $("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("toggled");
                });

                $(window).resize(function(e) {
                  if($(window).width()<=768||$(window).width()<=1024){
                    $("#wrapper").removeClass("toggled");
                  }else{
                    $("#wrapper").addClass("toggled");
                  }
                });
              });

                function mostrar_provincias_modal(departamento_id){
                    // alert('hola:'+departamento_id);
                    console.log('departamento_id:'+departamento_id);
                    if(departamento_id>0){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                        type:'POST',
                        url:"{{route('comunidad_mostrar_provincias_path')}}",
                        data:{departamento_id:departamento_id},
                        success:function(data){
                            $("select[name='provincia'").html('');
                            $("select[name='provincia'").html(data.options);
                        }
                        });
                    }
                }
                function mostrar_distritos_modal(provincia_id){
                    // alert('hola:'+departamento_id);
                    console.log('departamento_id:'+provincia_id);
                    if(provincia_id>0){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                        type:'POST',
                        url:"{{route('comunidad_mostrar_distritos_path')}}",
                        data:{provincia_id:provincia_id},
                        success:function(data){
                            $("select[name='distrito'").html('');
                            $("select[name='distrito'").html(data.options);
                        }
                        });
                    }
                }
                function mostrar_comunidades_modal(distrito_id,asociacion_id){
                    // alert('hola:'+departamento_id);
                    console.log('distrito_id:'+distrito_id);
                    if(distrito_id>0){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                        type:'POST',
                        url:"{{route('comunidad_mostrar_comunidades_')}}",
                        data:{distrito_id:distrito_id},
                        success:function(data){
                            $("select[name='comunidad'").html('');
                            $("select[name='comunidad'").html(data.options);
                            // $("#comunidad_"+asociacion_id).html('');
                            // $("#comunidad_"+asociacion_id).html(data.options);
                        }
                        });
                    }
                }
            </script>




</body>

</html>
