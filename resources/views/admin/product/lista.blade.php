@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item active" aria-current="page">PRODUCTOS</li>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-9">
                                <b class="text-danger text-15">LISTA DE PRODUCTOS</b>
                            </div>
                            <div class="col-3 text-right">
                                <a href="{{ route('product_nuevo_path') }}" class="btn btn-info text-white"><i class="fas fa-plus-circle"></i> AGREGAR PRODUCTO</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <table class="table table-bordered table-hover table-striped">
                            <thead >
                                <tr>
                                    <th>#</th>
                                    <th>LOCALIZACION</th>
                                    <th>NOMBRE</th>
                                    <th>MOSTRAR EN PAGINA</th>
                                    <th>OPERACIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($products as $item)
                                    <tr id="row_lista_productos_{{ $item->id }}">
                                        <td>{{ $i }}</td>
                                        <td>
                                            {{ $item->distrito->distrito }}
                                        </td>
                                        <td>{{ $item->nombre }}</td>
                                        <td>
                                            <input type="hidden" id="mostrar_en_pagina_{{ $item->id }}" value="{{ $item->mostrar_en_pagina }}">
                                            @if ($item->mostrar_en_pagina==1)
                                                <button class="btn btn-success btn-sm" id="confirmar_{{ $item->id }}" onclick="mostrar_pagina('{{ $item->id }}',$('#mostrar_en_pagina_{{ $item->id }}').val())">Mostrar en pagina</button>
                                            @elseif($item->mostrar_en_pagina==0)
                                                <button class="btn btn-danger btn-sm" id="confirmar_{{ $item->id }}" onclick="mostrar_pagina('{{ $item->id }}',$('#mostrar_en_pagina_{{ $item->id }}').val())">No mostrar en pagina</button>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#comunidadModal_{{ $item->id }}">
                                                    <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="comunidadModal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <form action="{{ route('comunidad_editar_path') }}" method="POST" method="POST" enctype="multipart/form-data">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Editar datos</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group col-12">
                                                                    <label for="nombre">Nombre</label>
                                                                    <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombre" placeholder="Nombre de la comunidad" value="{{ $item->nombre }}">
                                                                </div>
                                                                <div class="form-group col-4">
                                                                    <label for="departamento">Departamento</label>
                                                                    <select class="form-control" name="departamento" id="departamento" onchange="mostrar_provincias($(this).val());">
                                                                        <option value="0">Escoja una opcion</option>
                                                                        @foreach ($departamentos as $item_)
                                                                            <option value="{{ $item_->id }}" @if ($item_->id==$item->distrito->provincia->departamento->id)
                                                                                selected
                                                                            @endif>{{ $item_->departamento }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-4">
                                                                    <label for="provincia">Provicia</label>
                                                                    <select class="form-control" name="provincia" id="provincia" onchange="mostrar_distritos($(this).val());">
                                                                        <option value="0">Escoja una opcion</option>
                                                                        @foreach ($provincias as $item_)
                                                                            <option value="{{ $item_->id }}" @if ($item_->id==$item->distrito->provincia->id)
                                                                                selected
                                                                            @endif>{{ $item_->provincia }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div id="distrito_id" class="form-group col-4">
                                                                    <label for="distrito">Distrito</label>
                                                                    <select class="form-control" name="distrito" id="distrito">
                                                                        <option value="0">Escoja una opcion</option>
                                                                        @foreach ($distritos as $item_)
                                                                            <option value="{{ $item_->id }}" @if ($item_->id==$item->distrito->id)
                                                                                selected
                                                                            @endif>{{ $item_->distrito }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-6">
                                                                        <label for="altura">Altura</label>
                                                                        <input type="text" class="form-control" id="altura" name="altura" value="{{$item->altura}}" aria-describedby="altura" placeholder="3420 msnm" required>
                                                                </div>
                                                                <div class="form-group col-6">
                                                                    <label for="distancia">Distancia</label>
                                                                    <input type="text" class="form-control" id="distancia" name="distancia" value="{{$item->distancia}}" aria-describedby="distancia" placeholder="2 horas de la ciudad del Cusco" required>
                                                                </div>
                                                                <div class="form-group col-12">
                                                                    <label for="descripcion">Descripcion</label>
                                                                    <textarea class="form-control descripcion" name="descripcion" id="descripcion" cols="30" rows="10">{{ $item->descripcion }}</textarea>
                                                                </div>
                                                                <div class="form-group col-12">
                                                                    <label for="historia">Historia</label>
                                                                    <textarea class="form-control descripcion" name="historia" id="historia" cols="30" rows="10">{{ $item->historia }}</textarea>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group col-12 text-left">
                                                                            <p><b>Portada</b></p>
                                                                            @foreach ($item->fotos->where('estado','1') as $foto)
                                                                                @if (Storage::disk('comunidades')->has($foto->imagen))
                                                                                    <figure class="figure m-3" id="{{ $item->id.'_'.$foto->id }}">
                                                                                        <img src="{{ route('comunidad_editar_imagen_path',$foto->imagen) }}" class="figure-img rounded" alt="A generic" width="200px" height="200px">
                                                                                        <figcaption class="figure-caption text-right mt-0">
                                                                                            <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_cliente('{{ $item->id.'_'.$foto->id }}')">
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
                                                                            <input type="file" name="portada_f" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group col-12 text-left">
                                                                            <p><b>Miniatura</b></p>
                                                                            @foreach ($item->fotos->where('estado','2') as $foto)
                                                                                @if (Storage::disk('comunidades')->has($foto->imagen))
                                                                                    <figure class="figure m-3" id="{{ $item->id.'_'.$foto->id }}">
                                                                                        <img src="{{ route('comunidad_editar_imagen_path',$foto->imagen) }}" class="figure-img rounded" alt="A generic" width="200px" height="200px">
                                                                                        <figcaption class="figure-caption text-right mt-0">
                                                                                            <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_cliente('{{ $item->id.'_'.$foto->id }}')">
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
                                                                            <input type="file" name="miniatura_f" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group col-12 text-left">
                                                                            <p><b>Galeria de fotos</b></p>
                                                                            @foreach ($item->fotos->where('estado','0') as $foto)
                                                                                @if (Storage::disk('comunidades')->has($foto->imagen))
                                                                                    <figure class="figure m-3" id="{{ $item->id.'_'.$foto->id }}">
                                                                                        <img src="{{ route('comunidad_editar_imagen_path',$foto->imagen) }}" class="figure-img rounded" alt="A generic" width="200px" height="200px">
                                                                                        <figcaption class="figure-caption text-right mt-0">
                                                                                            <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_cliente('{{ $item->id.'_'.$foto->id }}')">
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
                                            <a href="#" class="btn btn-danger" onclick="eliminar('{{ $item->id }}')"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
